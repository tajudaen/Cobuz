<?php

namespace App\Models;

use Core\Model;

class User extends Model
{
    public function getUsers()
    {
        $this->db->query("SELECT * FROM users");

        return $this->db->results();
    }
}