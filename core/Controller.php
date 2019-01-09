<?php

namespace Core;

use Core\Application;

class Controller extends Application
{
    protected $controller;
    protected $method;
    protected $view;
    protected $model;

    public function __construct($controller, $method)
    {
        parent::__construct();
        $this->controller = $controller;
        $this->method = $method;
    }

    public function model($model)
    {
        if (!class_exists($model)) {
            throw new \Exception("Model not found");
        } 
        return new $model;
    }

    public function view($view, $data = [])
    {
        if (!file_exists(ROOT . DS . 'app' . DS . 'views' . DS . $view . '.php')) {
            throw new \Exception("View not found");
        } else {
            require_once ROOT . DS . 'app' . DS . 'views' . DS . $view . '.php';
        }
    }
}