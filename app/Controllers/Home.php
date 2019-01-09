<?php

namespace App\Controllers;

use Core\Controller;

class Home extends Controller
{
    public function index()
    {
        $this->view('index');
    }

    public function about($id)
    {
        $this->view('pages/about', ['page' => 'Can you me']);
    }
}