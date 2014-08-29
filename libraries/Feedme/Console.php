<?php

/**
 * Console application (for all jobs/scripts/crons)
 */

namespace Feedme;

use Phalcon\DI\FactoryDefault\CLI as CliDI;
use Phalcon\CLI\Console as ConsoleApp;
use Phalcon\Exception;
use Phalcon\Loader;

class Console extends InstanceAbstract
{
    /**
     * @param array $argv
     */
    public function run($argv = array())
    {
        try {
            $depInjection = new CliDI();
            $console = new ConsoleApp();
            $arguments = array();

            $this->handleArguments($arguments, $argv);
            $this->enableTasksChain($depInjection, $console);
            $this->registerDatabase($depInjection);

            $console->setDI($depInjection);
            $console->handle($arguments);

        } catch (Exception $e) {
            echo $e->getMessage();
        } catch (\PDOException $e) {
            echo $e->getMessage();
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
                'tasks' => ROOT_PATH . $this->getConf()->application->tasksDir,
            )
        )->register();
    }

    /**
     * @param CliDI      $depInjection
     * @param ConsoleApp $console
     */
    private function enableTasksChain(CliDI &$depInjection, ConsoleApp $console)
    {
        $depInjection->setShared('console', $console);
    }

    /**
     * Process the console arguments
     * @param array $args
     * @param array $argv
     */
    private function handleArguments(array &$args, array $argv)
    {
        $nsPrefix = 'tasks\\';
        foreach ($argv as $k => $arg) {
            if ($k == 1) {
                $args['task'] = $nsPrefix . $arg;
            } elseif ($k == 2) {
                $args['action'] = $arg;
            } elseif ($k >= 3) {
                $args['params'][] = $arg;
            }
        }
    }
}
