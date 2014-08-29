<?php

/**
 * Testing application (for all phpunit etc.)
 */

namespace Feedme;

use Phalcon\Loader;

class Testing extends InstanceAbstract
{
    public function run()
    {
        try {
            $this->registerNamespaces();

        } catch (\Phalcon\Exception $e) {
            echo "Phalcon Exception : " . $e->getMessage();
        } catch (\PDOException $e) {
            echo "PHP Exception : " . $e->getMessage();
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
}
