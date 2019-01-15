<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }

    public function getUsers()
    {
        $this->db->query("SELECT * FROM users");

        return $this->db->results();
    }

    public function checkUsernameExist($username)
    {
        $this->db->get($this->table, ["username", "=", $username]);
        if ($this->db->count()) {
            return true;
        } else {
            return false;
        }
        
    }

    public function register($data)
    {
        if ($this->db->insert($this->table, ["username" => $data['username'], "password" => $data['password']])) {
            return true;
        } else {
            return false;
        }
    }

    public function login($data)
    {
        $this->db->get($this->table, ["username", "=", $data['username']]);
        $user = $this->db->first();

        $hashed_password = $user->password;
        if (password_verify($data['password'], $hashed_password)) {
            return $user;
        } else {
            return false;
        }

    }
}