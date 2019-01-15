<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Core\Session;

class Users extends Controller
{
    public function __construct()
    {
        if (!Session::isLoggedIn()) {
            redirect('register/login');
        }
        $this->model = $this->model('\App\Models\User');
    }

    public function index()
    {
        $this->view('users/index');
    }
}