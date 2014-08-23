<?php

namespace Feedme;

use \Phalcon\Config;

abstract class InstanceAbstract
{
    protected $_conf;

    abstract protected function _registerDirectories();

    public function __construct()
    {
        $this->_loadConfigurations();
        $this->_registerDirectories();
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
