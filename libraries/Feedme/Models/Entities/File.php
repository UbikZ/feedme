<?php

namespace Feedme\Models\Entities;

class File
{
    /** @var  string */
    protected $_name;
    /** @var  string */
    protected $_extension;
    /** @var  string */
    protected $_mime;
    /** @var  string */
    protected $_publicPath;
    /** @var  string */
    protected $_serverPath;
    /** @var  float */
    protected $_size;
    /** @var  \DateTime */
    protected $_addDate;

    public function __construct($path)
    {
        if (!is_null($path) && file_exists(realpath($path))) {
            $infos = pathinfo($path);
            $this->setName($infos['filename']);
            $this->setExtension($infos['extension']);
            $this->setMime(mime_content_type($path));
            $this->setAddDate(date('d F Y', filemtime($path)));
            $this->setSize(floatval(filesize($path) / 1024));
        }
    }

    /**
     * @param string $addDate
     */
    public function setAddDate($addDate)
    {
        $this->_addDate = $addDate;
    }

    /**
     * @return string
     */
    public function getAddDate()
    {
        return $this->_addDate;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->_extension = $extension;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->_extension;
    }

    /**
     * @param string $mime
     */
    public function setMime($mime)
    {
        $this->_mime = $mime;
    }

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->_mime;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $publicPath
     */
    public function setPublicPath($publicPath)
    {
        $this->_publicPath = $publicPath;
    }

    /**
     * @return string
     */
    public function getPublicPath()
    {
        return $this->_publicPath;
    }

    /**
     * @param string $serverPath
     */
    public function setServerPath($serverPath)
    {
        $this->_serverPath = $serverPath;
    }

    /**
     * @return string
     */
    public function getServerPath()
    {
        return $this->_serverPath;
    }

    /**
     * @param float $size
     */
    public function setSize($size)
    {
        $this->_size = $size;
    }

    /**
     * @return float
     */
    public function getSize()
    {
        return $this->_size;
    }
}
