<?php

return array(
    "phpSettings" => array(
        "display_errors" => false
    ),
    "database" => array(
        "host" => "my_host",
        "adapter" => "my_adapter",
        "username" => "root",
        "password" => "toor",
        "dbname" => "my_dbname"
    ),
    "application" => array(
        "controllersDir" => "/app/controllers/",
        "viewsDir" => "/app/views/",
        "baseUri" => "/"
    ),
    "metadata" => array(
        "adapter" => "Apc",
        "suffix" => "my-suffix",
        "lifetime" => 86400
    )
);
