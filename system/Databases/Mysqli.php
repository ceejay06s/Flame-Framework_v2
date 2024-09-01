<?php

namespace System\Databases;

use \mysqli_sql_exception;
use \Logs;

use \mysql_affected_rows;

class Mysqli implements Database
{
    private $conn;
    private $results;
    private $fields;
    private $affectedRows;

    public function __construct()
    {
        $this->connect();
    }



    private function connect()
    {
        try {
            $this->conn = new \mysqli(
                getenv('DB_HOST'),
                getenv('DB_USER'),
                getenv('DB_PASSWORD'),
                getenv('DB_NAME')
            );
            if ($this->conn->connect_error) {
                throw new mysqli_sql_exception($this->conn->connect_error);
            }
        } catch (mysqli_sql_exception $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public function query($sql, $params = [])
    {
        return $this->execute($sql, $params);
    }
    public function execute($sql, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            if ($stmt) {
                if (!empty($params)) {
                    $types = '';
                    $values = [];
                    foreach ($params as $key => $value) {
                        $types .= gettype($value) === 'string' ? 's' : 'i';
                        $values[] = $value;
                    }
                    $stmt->bind_param($types, ...$values);
                }
                $stmt->execute();
                $this->results = $stmt->get_result();
                $this->affectedRows = $stmt->affected_rows;
                return $this;
            } else {
                throw new mysqli_sql_exception($this->conn->error);
            }
        } catch (mysqli_sql_exception $e) {
            echo "Error: " . $e->getMessage();
            echo $sql;
            return false;
        }
    }

    public function select($table, $columns = "*", $where = null, $orderBy = null, $limit = null)
    {
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
        $this->query($sql);
        $results = [];
        foreach ($this->get() as $row) {
            $results[] = $row;
        }
        return $results;
    }

    public function insert($table, $data)
    {
        $columns = implode(",", array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $this->query($sql);
        return $this->affectedRows;
    }

    public function update($table, $data, $where)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key='$value'";
        }
        $set = implode(",", $set);
        $sql = "UPDATE $table SET $set WHERE $where";
        $this->query($sql);
        return $this->affectedRows;
    }

    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $this->query($sql);
        return $this->affectedRows;
    }

    public function lastInsertId()
    {
        return $this->conn->insert_id;
    }

    public function close()
    {
        $this->conn->close();
    }
    public function get()
    {
        $res = [];
        while ($result = $this->results->fetch_assoc()) {
            $res[] = $result;
        }
        $this->results = $res;
        return $this->results;
    }
    public function first()
    {
        $res = $this->get();
        return reset($res);
    }
    public function last()
    {
        $res = $this->get();
        return end($res);
    }
    public function listFields($table)
    {
        $sql = "DESCRIBE $table";
        $this->query($sql);

        $fields = [];
        foreach ($this->get() as $row) {
            $fields[] = $row['Field'];
        }
        $this->fields = $fields;
        return $this->fields;
    }
}
