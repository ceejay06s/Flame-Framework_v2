<?php
#[\AllowDynamicProperties]
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

        try {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
            $dotenv->load();
            $this->db = DatabaseFactory::create();
            $inflector = new Inflector;

            if (get_class($this) !== "Model" && is_null($this->table)) {
                $this->table = strtolower($inflector->tableize(get_class($this)));
                $this->checkTableExists($this->table) ? $this->listFields() : throw new Exception("Table '{$this->table}' Not Found...");
            }
        } catch (Exception $e) {
            // Handle the exception here, e.g., log it or display an error message
            echo "Error: " . $e->getMessage();
        }
    }

    public function query($sql, $params = [])
    {
        return $this->db->query($sql, $params);
    }

    public function select($column = '*', $conditions = '', $orderBy = '', $limit = '', $table = null)
    {
        $table = is_null($table) ? $this->table : $table;
        return $this->db->select($table, $column, $conditions, $orderBy, $limit);
    }

    public function first($sql, $params = [])
    {
        $result = $this->db->select(null, null, $sql, null, 1, $params);
        return $result ? $result[0] : null;
    }

    public function insert($data, $table = null)
    {
        $table = is_null($table) ? $this->table : $table;

        return $this->db->insert($table, $data);
    }

    public function update($data, $where, $table)
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
    public function checkTableExists($table)
    {
        return $this->db->checkTableExists($table);
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
