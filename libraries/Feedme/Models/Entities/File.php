<?php

namespace Feedme\Models\Entities;

class File
{
    /** @var  string */
    protected $name;
    /** @var  string */
    protected $extension;
    /** @var  string */
    protected $mime;
    /** @var  string */
    protected $publicPath;
    /** @var  string */
    protected $serverPath;
    /** @var  float */
    protected $size;
    /** @var  string */
    protected $addDate;

    public function __construct($psPath, $pbStatic = true)
    {
        if (!is_null($psPath)) {
            $path = $psPath;
            if ($pbStatic) {
                $path = PUBLIC_PATH . '/' . $psPath;
            }
            if (file_exists(realpath($path))) {
                $infos = pathinfo($path);
                $this->setName($infos['filename']);
                $this->setExtension($infos['extension']);
                $this->setMime(mime_content_type($path));
                $this->setAddDate(date('d F Y', filemtime($path)));
                $this->setSize(round(filesize($path) / 1024, 2));
                $this->setPublicPath($psPath);
            }
        }
    }

    /**
     * @param string $addDate
     */
    public function setAddDate($addDate)
    {
        $this->addDate = $addDate;
    }

    /**
     * @return string
     */
    public function getAddDate()
    {
        return $this->addDate;
    }

    /**
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $mime
     */
    public function setMime($mime)
    {
        $this->mime = $mime;
    }

    /**
     * @return string
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $publicPath
     */
    public function setPublicPath($publicPath)
    {
        $this->publicPath = $publicPath;
    }

    /**
     * @return string
     */
    public function getPublicPath()
    {
        return $this->publicPath;
    }

    /**
     * @param string $serverPath
     */
    public function setServerPath($serverPath)
    {
        $this->serverPath = $serverPath;
    }

    /**
     * @return string
     */
    public function getServerPath()
    {
        return $this->serverPath;
    }

    /**
     * @param float $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return float
     */
    public function getSize()
    {
        return $this->size;
    }
}
