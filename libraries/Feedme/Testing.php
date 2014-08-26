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
            $this->_registerNamespaces();

        } catch (\Phalcon\Exception $e) {
            echo "Phalcon Exception : " . $e->getMessage();
            exit(255);
        } catch (\PDOException $e) {
            echo "PHP Exception : " . $e->getMessage();
            exit(255);
        }
    }

    /**
     * Register application namespaces
     */
    protected function _registerNamespaces()
    {
        $loader = new Loader();
        $loader->registerNamespaces(
            array(
                'controllers' => ROOT_PATH . $this->getConf()->application->controllersDir,
            )
        )->register();
    }
}
