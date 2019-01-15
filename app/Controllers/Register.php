<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use Core\Session;

class Register extends Controller
{
    public function __construct()
    {
        $this->model = $this->model('\App\Models\User');
    }

    public function register()
    {
        if (Session::isloggedIn()) {
            redirect('users/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => trim(sanitize($_POST['username'])),
                'password' => trim(sanitize($_POST['password'])),
                'confirm_password' => trim(sanitize($_POST['confirm_password'])),
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',

            ];

            // Validate Username
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            } else {
                // Check username
                if ($this->model->checkUsernameExist($data['username'])) {
                    $data['username_err'] = 'Username is already taken';
                }
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            // Validate Confirm Password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Make sure errors are empty
            if (empty($data['username_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                // Validated
          
                // Hash Password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register User
                if ($this->model->register($data)) {
                    redirect('register/login');
                } else {
                    die('Ooops... Registration could not be completed');
                }
                die('SUCCESS');
            } else {
                // Load view with errors
                $this->view('registration/register', $data);
            }
        } else {
            $data = [
                'username' => '',
                'password' => '',
                'confirm_password' => '',
                'username_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',

            ];

            $this->view('registration/register', $data);
        }
    }

    public function login()
    {
        if (Session::isloggedIn()) {
            redirect('users/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => trim(sanitize($_POST['username'])),
                'password' => trim(sanitize($_POST['password'])),
                'username_err' => '',
                'password_err' => '',

            ];

            // Validate Username
            if (empty($data['username'])) {
                $data['username_err'] = 'Please enter username';
            } else {
            // Check username
                if (!$this->model->checkUsernameExist($data['username'])) {
                    $data['username_err'] = 'No user found';
                }
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }

            if (empty($data['username_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->model->login($data);
                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';

                    $this->view('registration/login', $data);                    
                }
            } else {
                // Load view with errors
                $this->view('registration/login', $data);
            }

        } else {
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => ''

            ];

            $this->view('registration/login', $data);
        }
    }

    protected function createUserSession($user)
    {
        Session::put('user_id', $user->id);
        Session::put('username', $user->username);
        redirect('users/index');
    }

    public function logout()
    {
        Session::delete('user_id');
        Session::delete('username');
        session_destroy();
        redirect('register/login');
    }

}