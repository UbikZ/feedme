<?php

namespace Feedme;

use Feedme\Db\Factory as DbFactory;
use Feedme\Db\Handler as DbHandler;

use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Exception;

abstract class InstanceAbstract
{
    protected $conf;

    abstract protected function registerNamespaces();

    public function __construct()
    {
        $this->checkApplicationIntegrity();
        $this->loadConfigurations();
        $this->registerNamespaces();
    }

    protected function checkApplicationIntegrity()
    {
        if (!extension_loaded('phalcon')) {
            throw new Exception('Install phalcon extension before.');
        }
    }

    /**
     * Load global / local configuration and set some php settings
     */
    protected function loadConfigurations()
    {
        $config = new Config(require_once(APP_PATH . '/config/configs/global.php'));
        if (file_exists($localConfPath = sprintf(APP_PATH . '/config/configs/%s.php', APPLICATION_ENV))) {
            $localConf = require_once($localConfPath);
            if (is_array($localConf)) {
                $config->merge(new Config($localConf));
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
     * Register database connection with specific adapter
     * @param DiInterface $di
     */
    protected function registerDatabase(DiInterface &$di)
    {
        $dbConf = array(
            "adapter" => $this->getConf()->database->adapter,
            "host" => $this->getConf()->database->host,
            "username" => $this->getConf()->database->username,
            "password" => $this->getConf()->database->password,
            "dbname" => $this->getConf()->database->dbname,
            "charset" => $this->getConf()->database->charset
        );

        // ORM-less setup
        DbHandler::$conf = $dbConf;
        // ORM setup
        $di->set('db', function () use ($dbConf) {
            return DbFactory::getDriver($dbConf);
        });
    }

    // Getters & Setters

    public function getConf()
    {
        return $this->conf;
    }

    public function setConf($conf)
    {
        $this->conf = $conf;
    }
}
