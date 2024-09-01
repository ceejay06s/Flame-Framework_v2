<?php

class Logs
{
    private static $log_file = APP_PATH . DS . 'tmp/logs/app.log';

    public function __construct()
    {
        self::$log_file = APP_PATH . DS . 'tmp/logs/app.log';
    }

    public static function info($message)
    {
        self::write($message, 'INFO');
    }

    public static function debug($message)
    {
        self::write($message, 'DEBUG');
    }

    public static function save($filename, $message, $level = 'INFO')
    {
        self::$log_file = APP_PATH . DS . 'tmp/logs/' . $filename;
        self::write($message, $level);
    }

    private static function write($message, $level)
    {
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = "[$timestamp] [$level] ";
        $log_entry .= print_r($message, true) . "\n";
        file_put_contents(self::$log_file, $log_entry, FILE_APPEND);
    }
}
