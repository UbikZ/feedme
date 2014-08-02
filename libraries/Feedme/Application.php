<?php

namespace Feedme;

// Phalcon
use Phalcon\Config,
    Phalcon\Loader,
    Phalcon\DI\FactoryDefault as DI,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\Url,
    Phalcon\Mvc\View,
    Phalcon\Mvc\View\Engine\Volt,
    Phalcon\Mvc\Model\Metadata\Memory,
    Phalcon\Session\Adapter\Files,
    Phalcon\Flash\Session,
    Phalcon\DI\FactoryDefault,
    Phalcon\Assets\Manager;

// Feedme
use Feedme\Plugins\Security,
    Feedme\Db\Factory as DbFactory,
    Feedme\Components\Dashboard;

class Application
{
    private $_conf;

    public function __construct()
    {
        $this->_loadConfigurations();
        $this->_registerDirectories();
    }

    public function run()
    {
        try {
            $di = new FactoryDefault();

            $this->_registerDispatcher($di);
            $this->_registerUrl($di);
            $this->_registerView($di);
            $this->_registerDatabase($di);
            $this->_registerMetadata($di);
            $this->_registerSession($di);
            $this->_registerFlash($di);
            $this->_registerComponents($di);

            $application = new \Phalcon\Mvc\Application();
            $application->setDI($di);
            echo $application->handle()->getContent();

        } catch (Phalcon\Exception $e) {
            echo $e->getMessage();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Load global / local configuration and set some php settings
     */
    private function _loadConfigurations()
    {
        $config = new \Phalcon\Config(require_once(APP_PATH . '/config/configs/global.php'));
        if (file_exists($localConfPath = sprintf(APP_PATH . '/config/configs/%s.php', APPLICATION_ENV))) {
            $localConf = require_once($localConfPath);
            if (is_array($localConf)) {
                $config->merge($localConf);
            }
        }

        $this->setConf($config);

        // Set php settings
        $phpSettings = isset($config->phpSettings) ? $config->phpSettings : array();
        if (!empty($phpSettings)) {
            foreach ($phpSettings as $key => $value) {
                ini_set($key, $value);
            }
        }
    }

    /**
     * Register application directories
     */
    private function _registerDirectories()
    {
        $loader = new Loader();
        $loader->registerDirs(
            array(
                ROOT_PATH . $this->getConf()->application->controllersDir,
                ROOT_PATH . '/app/models'
            )
        )->register();
    }

    /**
     * Register the dispatcher
     * - We added some Security plugin to provide ACL
     * @param DI $di
     */
    private function _registerDispatcher(DI &$di)
    {
        $di->set('dispatcher', function () use ($di) {
            $eventsManager = $di->getShared('eventsManager');
            $security = new Security($di);
            $eventsManager->attach('dispatch', $security);
            $dispatcher = new Dispatcher();
            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });
    }

    /**
     * Register the URL component (provide generation)
     * @param DI $di
     */
    private function _registerUrl(DI &$di)
    {
        $di->set('url', function () {
            $url = new Url();
            $url->setBaseUri($this->getConf()->application->baseUri);

            return $url;
        });
    }

    /**
     * todo : externalize this in `Feedme\Manager\Assets` namespace
     * Register several custom components
     * @param DI $di
     */
    private function _registerComponents(DI &$di)
    {
        $di->set('dashboard', function () {
            return new Dashboard();
        });

        $di->set('assets', function () {
            $prefixPath = 'libraries';
            $assetManager = new Manager();
            $bMinify = $this->getConf()->application->minify;

            // Global javascript (with minify)
            $assetManager
                ->collection('global-js')
                ->setTargetPath('cache/min.js')
                ->setTargetUri('cache/min.js')
                ->addJs($prefixPath . '/jquery/dist/jquery.js')
                ->addJs($prefixPath . '/bootstrap/dist/js/bootstrap.js')
                ->addJs($prefixPath . '/jquery.gritter/js/jquery.gritter.js')
                ->join($bMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Jsmin());

            // Global css (with minify)
            $assetManager
                ->collection('global-css')
                ->setTargetPath('cache/min.css')
                ->setTargetUri('cache/min.css')
                ->addCss($prefixPath . '/bootstrap/dist/css/bootstrap.css')
                ->addCss($prefixPath . '/animate.css/animate.css')
                ->addCss($prefixPath . '/font-awesome/css/font-awesome.css')
                ->addCss($prefixPath . '/jquery.gritter/css/jquery.gritter.css')
                ->addCss('assets/common/css/kill-bootstrap.css')
                ->addCss('assets/common/css/theme.css')
                ->addCss('assets/common/css/style.css')
                ->join($bMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Cssmin());

            // Local css (authentication)
            $assetManager
                ->collection('auth-css')
                ->setTargetPath('cache/auth.min.css')
                ->setTargetUri('cache/auth.min.css')
                ->addCss('assets/authentication/css/style.css')
                ->join($bMinify)
                ->addFilter(new \Phalcon\Assets\Filters\Cssmin());

            return $assetManager;
        });
    }

    /**
     * Register template engine (volt here)
     * @param DI $di
     */
    private function _registerView(DI &$di)
    {
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir(ROOT_PATH . $this->getConf()->application->viewsDir);
            $view->registerEngines(array(
                ".volt" => 'volt'
            ));

            return $view;
        });

        $di->set('volt', function ($view, $di) {
            $volt = new Volt($view, $di);
            $volt->setOptions(array("compiledPath" => CACHE_PATH . "/volt/"));

            return $volt;
        }, true);
    }

    /**
     * Register database connection with specific adapter
     * @param DI $di
     */
    private function _registerDatabase(DI &$di)
    {
        $di->set('db', function () {
            return DbFactory::getDriver(array(
                "adapter" => $this->getConf()->database->adapter,
                "host" => $this->getConf()->database->host,
                "username" => $this->getConf()->database->username,
                "password" => $this->getConf()->database->password,
                "dbname" => $this->getConf()->database->dbname
            ));
        });
    }

    /**
     * Register metadata adapter (todo: improve this in factory mode)
     * @param DI $di
     */
    private function _registerMetadata(DI &$di)
    {
        $di->set('modelsMetadata', function () {
            if (isset($this->getConf()->metadata)) {
                $metadataAdapter = 'Phalcon\Mvc\Model\Metadata\\' . $this->getConf()->metadata->adapter;

                return new $metadataAdapter();
            }

            return new Memory();
        });
    }

    /**
     * Register session
     * @param DI $di
     */
    private function _registerSession(DI &$di)
    {
        $di->set('session', function () {
            $session = new Files();
            $session->start();

            return $session;
        });
    }

    /**
     * Register flash message with specific css classes
     * @param DI $di
     */
    private function _registerFlash(DI &$di)
    {
        $di->set('flash', function () {
            return new Session(array(
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'warning' => 'alert alert-warning',
                'notice' => 'alert alert-info',
            ));
        });

    }

    // Getters & Setters

    public function getConf()
    {
        return $this->_conf;
    }

    public function setConf($conf)
    {
        $this->_conf = $conf;
    }
}
