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
            $this->_registerDirectories();

        } catch (\Phalcon\Exception $e) {
            echo $e->getMessage();
            exit(255);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit(255);
        }
    }

    /**
     * Register application directories
     */
    protected function _registerDirectories()
    {
        $loader = new Loader();
        $loader->registerDirs(
            array(
                ROOT_PATH . $this->getConf()->application->controllersDir,
            )
        )->register();
    }
}
