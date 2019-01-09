<?php

namespace Core;

use Core\Database;

class Model
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}