<?php

namespace Feedme\Assets;

use \Phalcon\Assets\Manager;

class Builder
{
    const JS = 'js';
    const CSS = 'css';

    /** @var  array */
    protected $_conf = array();
    /** @var  boolean */
    protected $_bMinify = false;
    /** @var  Manager */
    protected $_assetManager;

    /**
     * @param \Phalcon\Assets\Manager $assetManager
     */
    public function setAssetManager($assetManager)
    {
        $this->_assetManager = $assetManager;
    }

    /**
     * @return \Phalcon\Assets\Manager
     */
    public function getAssetManager()
    {
        return $this->_assetManager;
    }

    /**
     * @param boolean $bMinify
     */
    public function setBMinify($bMinify)
    {
        $this->_bMinify = $bMinify;
    }

    /**
     * @return boolean
     */
    public function getBMinify()
    {
        return $this->_bMinify;
    }

    /**
     * @param array $conf
     */
    public function setConf($conf)
    {
        if (!is_array($conf)) {
            throw new \Exception('Wrong type parameter in `' . __CLASS__ . '`');
        }
        $this->_conf = $conf;
    }

    /**
     * @return array
     */
    public function getConf()
    {
        return $this->_conf;
    }

    public function __construct(array $conf, $bMinify = false)
    {
        $this->setConf($conf);
        $this->setBMinify($bMinify);
        $this->setAssetManager(new Manager());
    }

    /**
     * Load assets from configuration with Phalcon asset manager
     */
    public function load()
    {
        foreach ($this->getConf() as $namespace => $types) {
            foreach ($types as $type => $elements) {
                if (count($elements) > 0) {
                    $this->getAssetManager()
                        ->collection($namespace . '-' . $type)
                        ->setTargetPath('cache/' . $namespace . '.js')
                        ->setTargetUri('cache/' . $namespace . '.js')
                        ->join($this->getBMinify())
                        ->addFilter($this->_getFilter($type));
                    foreach ($elements as $element)
                        $this->_add($this->_assetManager, $type, $element);
                }
            }
        }
    }

    /**
     * @param Manager $am
     * @param $type
     * @param $el
     */
    private function _add(Manager &$am, $type, $el)
    {
        if ($el) {
            if (self::JS === $type)
                $am->addJs($el);
            else if (self::CSS === $type)
                $am->addCss($el);

        }
    }

    /**
     * @param Manager $am
     * @param $type
     */
    private function _getFilter($type)
    {
        $filter = null;
        if (self::JS === $type)
            $filter = new \Phalcon\Assets\Filters\Jsmin();
        else if (self::CSS === $type)
            $filter = new \Phalcon\Assets\Filters\Cssmin();

        return $filter;
    }
}
