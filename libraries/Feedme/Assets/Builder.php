<?php

namespace Feedme\Assets;

use Phalcon\Assets\Filters\Cssmin;
use Phalcon\Assets\Filters\Jsmin;
use \Phalcon\Assets\Manager;

class Builder
{
    const JS = 'js';
    const CSS = 'css';

    /** @var  array */
    protected $conf = array();
    /** @var  boolean */
    protected $isMinify = false;
    /** @var  Manager */
    protected $assetManager;

    /**
     * @param \Phalcon\Assets\Manager $assetManager
     */
    public function setAssetManager($assetManager)
    {
        $this->assetManager = $assetManager;
    }

    /**
     * @return \Phalcon\Assets\Manager
     */
    public function getAssetManager()
    {
        return $this->assetManager;
    }

    /**
     * @param boolean $isMinify
     */
    public function setMinify($isMinify)
    {
        $this->isMinify = $isMinify;
    }

    /**
     * @return boolean
     */
    public function getMinify()
    {
        return $this->isMinify;
    }

    /**
     * @param $conf
     * @throws \Exception
     */
    public function setConf($conf)
    {
        if (!is_array($conf)) {
            throw new \Exception('Wrong type parameter in `' . __CLASS__ . '`');
        }
        $this->conf = $conf;
    }

    /**
     * @return array
     */
    public function getConf()
    {
        return $this->conf;
    }

    public function __construct(array $conf, $isMinify = false)
    {
        $this->setConf($conf);
        $this->setIsMinify($isMinify);
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
                        ->join($this->getIsMinify())
                        ->addFilter($this->getFilter($type));
                    foreach ($elements as $element) {
                        $this->add($this->assetManager, $type, $element);
                    }
                }
            }
        }
    }

    /**
     * @param Manager $assetManager
     * @param $type
     * @param $element
     */
    private function add(Manager &$assetManager, $type, $element)
    {
        if ($element) {
            if (self::JS === $type) {
                $assetManager->addJs($element);
            } elseif (self::CSS === $type) {
                $assetManager->addCss($element);
            }
        }
    }

    /**
     * @param $type
     * @return null|Cssmin|Jsmin
     */
    private function getFilter($type)
    {
        $filter = null;
        if (self::JS === $type) {
            $filter = new Jsmin();
        } elseif (self::CSS === $type) {
            $filter = new Cssmin();
        }

        return $filter;
    }
}
