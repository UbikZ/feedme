<?php

/**
 * Base FRONT/BACK Applicaiton
 */

namespace Feedme;

// Phalcon
use Phalcon\Loader;
use Phalcon\DI\FactoryDefault as DI;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Session\Adapter\Files;
use Phalcon\Flash\Session;
use Phalcon\DI\FactoryDefault;
use Phalcon\Assets\Manager;
use Phalcon\Events\Manager as EventsManager;

// Feedme
use Feedme\Plugins\Security;
use Feedme\Logger\Factory as LoggerFactory;
use Feedme\Components\Dashboard;

class Application extends InstanceAbstract
{

    public function run()
    {
        try {
            $depInjection = new FactoryDefault();

            $this->registerDispatcher($depInjection);
            $this->registerUrl($depInjection);
            $this->registerView($depInjection);
            $this->registerDatabase($depInjection);
            $this->registerSession($depInjection);
            $this->registerFlash($depInjection);
            $this->registerComponents($depInjection);

            $application = new \Phalcon\Mvc\Application();
            $application->setDI($depInjection);
            echo $application->handle()->getContent();

        } catch (\Phalcon\Exception $e) {
            LoggerFactory::getLogger('phalcon')->error($e->getMessage());
        } catch (\PDOException $e) {
            LoggerFactory::getLogger('database')->error($e->getMessage());
        } catch (\Exception $e) {
            LoggerFactory::getLogger('error')->error($e->getMessage());
        }
    }

    /**
     * Register application namespaces
     */
    protected function registerNamespaces()
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            array(
                'controllers' => ROOT_PATH . $this->getConf()->application->controllersDir,
            )
        )->register();
    }

    /**
     * Register the dispatcher
     * - We added some Security plugin to provide ACL
     * @param DI $depInjection
     */
    private function registerDispatcher(DI &$depInjection)
    {
        $depInjection->set('dispatcher', function () use ($depInjection) {
            $eventsManager = new EventsManager();
            $security = new Security($depInjection);
            $eventsManager->attach('dispatch', $security);

            $eventsManager->attach("dispatch:beforeException", function ($event, Dispatcher $dispatcher, $exception) {
                if ($exception instanceof Dispatcher\Exception) {
                    $dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'notFound'
                    ));

                    return false;
                }

                $dispatcher->forward(array(
                    'controller' => 'index',
                    'action' => 'internalError'
                ));

                return false;
            });

            $depInjectionspatcher = new Dispatcher();
            $depInjectionspatcher->setDefaultNamespace('controllers');
            $depInjectionspatcher->setEventsManager($eventsManager);

            return $depInjectionspatcher;
        });
    }

    /**
     * Register the URL component (provide generation)
     * @param DI $depInjection
     */
    private function registerUrl(DI &$depInjection)
    {
        $depInjection->set('url', function () {
            $url = new Url();
            $url->setBaseUri($this->getConf()->application->baseUri);

            return $url;
        });
    }

    /**
     * Register several custom components
     * @param DI $depInjection
     */
    private function registerComponents(DI &$depInjection)
    {
        $depInjection->set('dashboard', function () {
            return new Dashboard();
        });

        $depInjection->set('assets', function () {
            $prefixPath = 'libraries';
            $assetManager = new Manager();
            $isMinify = $this->getConf()->application->minify;

            // Global javascript (with minify)
            $assetManager
                ->collection('global-js')
                ->setTargetPath('cache/min.js')
                ->setTargetUri('cache/min.js')
                ->addJs($prefixPath . '/jquery/dist/jquery.js')
                ->addJs($prefixPath . '/bootstrap/dist/js/bootstrap.js')
                ->addJs($prefixPath . '/notifyjs/dist/notify.js')
                ->addJs($prefixPath . '/notifyjs/dist/styles/bootstrap/notify-bootstrap.js')
                ->addJs($prefixPath . '/blueimp-tmpl/js/tmpl.js')
                ->addJs($prefixPath . '/blueimp-gallery/js/blueimp-gallery.js')
                ->addJs($prefixPath . '/blueimp-gallery/js/blueimp-gallery-helper.js')
                ->addJs($prefixPath . '/blueimp-gallery/js/blueimp-gallery-fullscreen.js')
                ->addJs($prefixPath . '/blueimp-gallery/js/blueimp-gallery-indicator.js')
                ->addJs($prefixPath . '/blueimp-gallery/js/jquery.blueimp-gallery.js')
                ->addJs('assets/common/js/common.js')
                ->join($isMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Jsmin());

            // Global css (with minify)
            $assetManager
                ->collection('global-css')
                ->setTargetPath('cache/min.css')
                ->setTargetUri('cache/min.css')
                ->addCss($prefixPath . '/bootstrap/dist/css/bootstrap.css')
                ->addCss($prefixPath . '/animate.css/animate.css')
                ->addCss($prefixPath . '/font-awesome/css/font-awesome.css')
                ->addCss($prefixPath . '/blueimp-gallery/css/blueimp-gallery.css')
                ->addCss('assets/common/css/kill-bootstrap.css')
                ->addCss('assets/common/css/notify.css')
                ->addCss('assets/common/css/theme.css')
                ->addCss('assets/common/css/style.css')
                ->join($isMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Cssmin());

            // Local css (authentication)
            $assetManager
                ->collection('auth-css')
                ->setTargetPath('cache/auth.min.css')
                ->setTargetUri('cache/auth.min.css')
                ->addCss('assets/authentication/css/style.css')
                ->join($isMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Cssmin());

            // Local css (dashboard)
            $assetManager
                ->collection('dash-css')
                ->setTargetPath('cache/dash.min.css')
                ->setTargetUri('cache/dash.min.css')
                ->addCss('assets/dashboard/css/style.css')
                ->addCss($prefixPath . '/pace/themes/pace-theme-minimal.css')
                ->join($isMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Cssmin());

            // Local js (dashboard)
            $assetManager
                ->collection('dash-js')
                ->setTargetPath('cache/dash.min.js')
                ->setTargetUri('cache/dash.min.js')
                ->addJs('assets/dashboard/js/jquery.menu.js')
                ->addJs('assets/dashboard/js/theme.js')
                ->addJs($prefixPath . '/pace/pace.js')
                ->join($isMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Jsmin());

            // Local js (wall)
            $assetManager
                ->collection('wall-js')
                ->setTargetPath('cache/wall.min.js')
                ->setTargetUri('cache/wall.min.js')
                ->addJs('assets/wall/js/jquery.wall.js')
                ->join($isMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Jsmin());

            // Local js (contact)
            $assetManager
                ->collection('contact-js')
                ->setTargetPath('cache/contact.min.js')
                ->setTargetUri('cache/contact.min.js')
                ->addJs('assets/contact/js/jquery.contact.js')
                ->join($isMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Jsmin());

            // Local js (contact)
            $assetManager
                ->collection('feed-js')
                ->setTargetPath('cache/feed.min.js')
                ->setTargetUri('cache/feed.min.js')
                ->addJs('assets/feed/js/jquery.feed.js')
                ->join($isMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Jsmin());

            return $assetManager;
        });
    }

    /**
     * Register template engine (volt here)
     * @param DI $depInjection
     */
    private function registerView(DI &$depInjection)
    {
        $depInjection->set('view', function () {
            $view = new View();
            $view->setViewsDir(ROOT_PATH . $this->getConf()->application->viewsDir);
            $view->registerEngines(array(
                ".phtml" => "Phalcon\Mvc\View\Engine\Php",
                ".volt" => 'volt'
            ));

            return $view;
        });

        $depInjection->set('volt', function ($view, $depInjection) {
            $volt = new Volt($view, $depInjection);
            $volt->setOptions(array(
                "compiledPath" => CACHE_PATH . "/volt/",
                "compileAlways" => $this->getConf()->application->volt->compile
            ));

            return $volt;
        }, true);
    }

    /**
     * Register session
     * @param DI $depInjection
     */
    private function registerSession(DI &$depInjection)
    {
        $depInjection->set('session', function () {
            $session = new Files();
            $session->start();

            return $session;
        });
    }

    /**
     * Register flash message with specific css classes
     * @param DI $depInjection
     */
    private function registerFlash(DI &$depInjection)
    {
        $depInjection->set('flash', function () {
            return new Session(array(
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'warning' => 'alert alert-warning',
                'notice' => 'alert alert-info',
            ));
        });

    }
}
