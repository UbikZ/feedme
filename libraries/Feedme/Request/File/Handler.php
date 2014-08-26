<?php

namespace Feedme\Request\File;

use Phalcon\Http\RequestInterface;

class Handler
{
    /**
     * @param  RequestInterface $reqFile
     * @param $request
     * @param  string           $dirPath
     * @param  array            $options
     * @return null|string
     */
    public static function moveTo(RequestInterface $reqFile, &$request, $dirPath = 'uploads', $options = array())
    {
        $result = null;

        $files = $reqFile->getUploadedFiles();
        if (true == ($reqFile->hasFiles()) && is_array($files) && isset($files[0])) {
            $file = $files[0];
            $filename = $dirPath . '/' . (isset($options['idUser']) ? $options['idUser'] : '') . $file->getName();
            $file->moveTo(PUBLIC_PATH . '/' . $filename);
            $result = $filename;
        }

        return $result;
    }
}
