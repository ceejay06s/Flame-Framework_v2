<?php

namespace System\Databases;

use PDO;
use PDOException;

class Mysql implements Database
{
    private $conn;
    private $results;
    private $fields;
    private $query;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->conn = new PDO(
                "mysql:host=" . getenv('DB_HOST') . ";dbname=" . getenv('DB_NAME'),
                getenv('DB_USER'),
                getenv('DB_PASSWORD')
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function query($sql, $params = [])
    {
        $this->execute($sql, $params);
        return $this;
    }

    private function execute($sql, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            $this->results = $stmt;
            return $this;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function select($table, $columns = "*", $where = null, $orderBy = null, $limit = null)
    {
        if (is_array($columns)) {
            $columns = implode(",", $columns);
        }

        $sql = "SELECT $columns FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        $this->query = $sql;
        $this->execute($sql);
        return $this->get();
    }

    public function get()
    {
        return $this->results->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($table, $data)
    {
        $columns = implode(",", array_keys($data));
        $values = ":" . implode(",:", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $this->execute($sql, $data);
        return $this->results->rowCount();
    }

    public function update($table, $data, $where)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key=:$key";
        }
        $set = implode(",", $set);
        $sql = "UPDATE $table SET $set WHERE $where";
        $this->execute($sql, $data);
        return $this->results->rowCount();
    }

    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        $this->execute($sql);
        return $this->results->rowCount();
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function close()
    {
        $this->conn = null;
    }
    public function listFields($table)
    {
        $sql = "DESCRIBE $table";
        $fields = [];
        $this->execute($sql);
        $record = $this->get();
        foreach ($record as $row) {
            $fields[] = $row['Field'];
        }
        $this->fields = $fields;
        return $this->fields;
    }

    public function first()
    {
        $rec = $this->get();
        return reset($rec);
    }

    public function last()
    {
        $rec = $this->get();
        return  end($rec);
    }
}
