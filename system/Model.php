<?php

class Model
{
    private $db;
    public $table;
    public $fields = [];
    protected $conditions = [];
    protected $limit;
    protected $offset;

    public function __construct()
    {

        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        $this->db = DatabaseFactory::create();
        $inflector = new Inflector;

        if (get_class($this) !== "Model" && is_null($this->table)) {
            $this->table = strtolower($inflector->tableize(get_class($this)));
            $this->listFields();
        }
    }

    public function query($sql, $params = [])
    {
        return $this->db->query($sql, $params);
    }

    public function select($table, $column = '*', $conditions = '', $orderBy = '', $limit = '')
    {
        return $this->db->select($table, $column, $conditions, $orderBy, $limit);
    }

    public function first($sql, $params = [])
    {
        $result = $this->db->select(null, null, $sql, null, 1, $params);
        return $result ? $result[0] : null;
    }

    public function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function update($table, $data, $where)
    {
        return $this->db->update($table, $data, $where);
    }

    public function delete($table, $where)
    {
        return $this->db->delete($table, $where);
    }
    public function listFields()
    {
        $this->fields = $this->db->listFields($this->table);
        return $this->fields;
    }

    public function createTable($table, $fields)
    {
        $sql = "CREATE TABLE IF NOT EXISTS $table (";
        $fieldSql = [];
        foreach ($fields as $field => $type) {
            $fieldSql[] = "$field $type";
        }
        $sql .= implode(", ", $fieldSql) . ")";
        return $this->db->query($sql);
    }
}
