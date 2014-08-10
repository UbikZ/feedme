<?php

namespace Feedme\Utils;

class Extract
{
    public static function directoryToArray($directory, $uri, $recursive = false, $public = true)
    {
        $array_items = array();
        if ($handle = opendir($directory)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    if (is_dir($directory . "/" . $file) && $recursive) {
                        $array_items = array_merge($array_items, directoryToArray($directory . "/" . $file, $recursive));
                    } else {
                        $item = preg_replace("/\/\//si", "/", $directory . "/" . $file);
                        if ($public) {
                            preg_match('#public.+#', realpath($item), $matches);
                            $item = isset($matches[0]) ? str_replace('public/', $uri, $matches[0]) : $item;
                        }
                        $array_items[] = $item;
                    }
                }
            }
            closedir($handle);
        }

        return $array_items;
    }
}