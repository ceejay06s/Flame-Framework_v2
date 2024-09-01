<?php

namespace System\Databases;

interface Database
{
    public function query($sql, $params = []);
    public function select($table, $columns = "*", $where = null, $orderBy = null, $limit = null);
    public function insert($table, $data);
    public function update($table, $data, $where);
    public function delete($table, $where);
    public function listFields($table);
    public function get();
    public function first();
    public function last();
}
