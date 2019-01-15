<?php

namespace Core;

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $pdo;
    private $query;
    private $count = 0;
    private $results;
    private $error = false;
    private static $instance = null;

    private function __construct()
    {

        try {
            $this->pdo = new \PDO(
                'mysql:host=' . $this->host . '; dbname=' .
                    $this->dbname,
                $this->user,
                $this->pass
            );

            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);

        } catch (\PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
            file_put_contents(ROOT . DS . 'log' . DS . 'database' . DS . 'DatabaseLog.log', $e->__toString(), FILE_APPEND);
        }

    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function query($sql, array $params = [])
    {
        $this->error = false;
        if ($this->query = $this->pdo->prepare($sql)) {
            if (count($params)) {
                $x = 1;
                foreach ($params as $param) {
                    $this->query->bindValue($x, $param);
                    $x++;
                }
            }
            if ($this->query->execute()) {
                $this->results = $this->query->fetchAll(\PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
            } else {
                $this->error = true;
            }
        }
        return $this;
    }

    public function action($action, $table, array $where)
    {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if (in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }

    public function get($table, $where)
    {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }

    public function insert($table, array $fields)
    {
        if (count($fields)) {
            $keys = array_keys($fields);
            $values = null;
            $x = 1;

            foreach ($fields as $field) {
                $values .= '?';
                if ($x < count($fields)) {
                    $values .= ', ';
                }
                $x++;
            }
            $sql = "INSERT INTO $table (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

            if (!$this->query($sql, $fields)->error()) {
                return true;
            }
        }

        return false;
    }

    public function update($table, $id, $fields)
    {
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if ($x < count($fields)) {
                $set .= ', ';
            }

            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function error()
    {
        return $this->error;
    }

    public function results()
    {
        return $this->results;
    }

    public function count()
    {
        return $this->count;
    }

    public function first()
    {
        return $this->results()[0];
    }
}