<?php

return array(
    "phpSettings" => array(
        "display_errors" => false,
        "error_log" => LOGS_PATH . '/php.log'
    ),
    "database" => array(
        "host" => "my_host",
        "adapter" => "my_adapter",
        "username" => "root",
        "password" => "toor",
        "dbname" => "my_dbname",
        "charset" => "utf8"
    ),
    "application" => array(
        "controllersDir" => "/app/controllers/",
        "tasksDir" => "/app/tasks/",
        "viewsDir" => "/app/views/",
        "baseUri" => "/",
        "minify" => false,
        "volt" => array(
            "compile" => false
        )
    ),
    "metadata" => array(
        "adapter" => "Apc",
        "suffix" => "my-suffix",
        "lifetime" => 86400
    )
);
