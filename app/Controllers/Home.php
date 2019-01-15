<?php

namespace App\Controllers;

use Core\Controller;
class Home extends Controller
{
    public function __construct()
    {
        
    }
    public function index()
    {

        $this->view('index');
    }

    
}