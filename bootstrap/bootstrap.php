<?php
use Core\Router;

    // load configuration and other functions
    require_once ROOT . DS . 'config' . DS . 'config.php';
    require_once ROOT . DS . 'config' . DS . 'functions.php';

    // autoloading classes
    require ROOT . DS . 'vendor/autoload.php';

    // Route the request
    try {
        Router::route($url);
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
