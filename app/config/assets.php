<?php

// External libraries (from bower manager)
$externLibPath = 'libraries';
// Internal libraries (own js/css files)
$internLibPath = 'assets';

return array(
    /* Global configuration */
    'global' => array(
        'js' => array(
            $externLibPath . '/jquery/dist/jquery.js',
            $externLibPath . '/bootstrap/dist/js/bootstrap.js',
            $externLibPath . '/notifyjs/dist/notify.js',
            $externLibPath . '/notifyjs/dist/styles/bootstrap/notify-bootstrap.js',
        ),
        'css' => array(
            $externLibPath . '/bootstrap/dist/css/bootstrap.css',
            $externLibPath . '/animate.css/animate.css',
            $externLibPath . '/font-awesome/css/font-awesome.css',
            $internLibPath . '/common/css/kill-bootstrap.css',
            $internLibPath . '/common/css/theme.css',
            $internLibPath . '/common/css/style.css',
        )
    ),
    /* Local configuration */
    // Authentication
    'auth' => array(
        'js' => array(),
        'css' => array(
            $internLibPath . '/authentication/css/style.css',
        )
    ),
    // Dashboard
    'dash' => array(
        'js' => array(
            $internLibPath . '/dasboard/js/theme.js',
            $internLibPath . '/dasboard/js/jquery.menu.js',
            $externLibPath . '/pace/pace.js',
        ),
        'css' => array(
            $internLibPath . '/dashboard/css/style.css',
            $externLibPath . '/pace/themes/pace-theme-minimal.css',
        )
    )
);
