<?php

use System\Databases\Database;
use System\Databases\Mysql;
use System\Databases\Mysqli;
use System\Databases\Mssql;

class DatabaseFactory
{
    public static function create(): Database
    {
        foreach ($_ENV as $key => $value) {
            putenv("{$key}={$value}");
        }
        $dbType = getenv('DB_TYPE');

        switch ($dbType) {
            case 'mysql':
                return new Mysql();
            case 'mysqli':
                return new Mysqli();
            case 'mssql':
                return new Mssql();
            default:
                throw new \Exception("Unsupported database type: $dbType");
        }
    }
}
