<?php

/**
 * Console application (for all jobs/scripts/crons)
 */

namespace Feedme;

use Phalcon\DI\FactoryDefault\CLI as CliDI;
use Phalcon\CLI\Console as ConsoleApp;
use Phalcon\Loader;

class Console extends InstanceAbstract
{
    /**
     * @param $argc
     * @param array $argv
     */
    public function run($argc, $argv = array())
    {
        try {
            $di = new CliDI();

            $console = new ConsoleApp();
            $console->setDI($di);

            $arguments = array();
            $this->_handleArguments($arguments, $argv);
            $this->_enableTasksChain($di, $console);
            $this->_registerDatabase($di);

            $console->handle($arguments);

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
                ROOT_PATH . $this->getConf()->application->tasksDir,
            )
        )->register();
    }

    /**
     * @param CliDI      $di
     * @param ConsoleApp $console
     */
    private function _enableTasksChain(CliDI &$di, ConsoleApp $console)
    {
        $di->setShared('console', $console);
    }

    /**
     * Process the console arguments
     * @param array $args
     * @param array $argv
     */
    private function _handleArguments(array &$args, array $argv)
    {
        foreach ($argv as $k => $arg) {
            if ($k == 1) {
                $args['task'] = $arg;
            } elseif ($k == 2) {
                $args['action'] = $arg;
            } elseif ($k >= 3) {
                $args['params'][] = $arg;
            }
        }
    }
}
