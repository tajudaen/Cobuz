<?php

namespace App\Controllers;

use Core\Controller;
use Core\Session;

class Game extends Controller
{
    public function __construct()
    {
        if (!Session::isLoggedIn()) {
            redirect('register/login');
        }
        $this->model = $this->model('\App\Models\Game');
    }
    public function run()
    {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'entry' => trim(sanitize($_POST['entry'])),
                'entry_err' => '',

            ];

             // Validate entry
            if (empty($data['entry'])) {
                $data['entry_err'] = 'Please enter your 4 digit entry';
                $this->view('users/index', $data);
            } elseif (strlen($data['entry']) != 4) {
                $data['entry_err'] = 'Entry must be 4 Numbers';
                $this->view('users/index', $data);
            } elseif (!is_numeric($data['entry'])) {
                $data['entry_err'] = 'Entry must be 4 digits';
                $this->view('users/index', $data);
            } else {
                $data = $this->model->match($data['entry']);
                $this->view('users/index', $data);
            }
        } else {
            $data = [
                'entry' => '',
                'entry_err' => '',

            ];

            $this->view('users/index', $data);
        }

    }


}