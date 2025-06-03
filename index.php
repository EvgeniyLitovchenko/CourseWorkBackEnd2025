<?php

use classes\Core;

spl_autoload_register(function ($class_name) {
    $path = str_replace('\\', '/', $class_name) . '.php';
    if (file_exists($path)) {
        include_once $path;
    }
});


$core = Core::getInstance();
$core->Init();
$core->run();
$core->done();
