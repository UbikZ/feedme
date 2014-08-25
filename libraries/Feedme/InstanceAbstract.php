<?php

namespace Feedme;

use Feedme\Db\Factory as DbFactory;
use Feedme\Db\Handler as DbHandler;

use Phalcon\Config;
use Phalcon\DiInterface;

abstract class InstanceAbstract
{
    protected $_conf;

    abstract protected function _registerDirectories();

    public function __construct()
    {
        $this->_loadConfigurations();
        $this->_registerDirectories();
    }

    protected function _checkApplicationIntegrity()
    {
        if (!extension_loaded('phalcon')) {
            throw new \Phalcon\Exception('Install phalcon extension before.');
        }
    }

    /**
     * Load global / local configuration and set some php settings
     */
    protected function _loadConfigurations()
    {
        $config = new Config(require_once(APP_PATH . '/config/configs/global.php'));
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
     * Register database connection with specific adapter
     * @param DiInterface $di
     */
    protected function _registerDatabase(DiInterface &$di)
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
        return $this->_conf;
    }

    public function setConf($conf)
    {
        $this->_conf = $conf;
    }
}
