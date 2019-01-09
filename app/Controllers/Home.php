<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
class Home extends Controller
{
    public function __construct()
    {
        $this->model = $this->model('\App\Models\User');
    }
    public function index()
    {
        $users = $this->model->getUsers();
        $data = ['users' => $users];

        $this->view('index', $data);
    }

    public function about($id)
    {
        $this->view('pages/about', ['page' => 'Can you me']);
    }
}