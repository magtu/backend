<?php

class Mysql
{    
    public static function get()
    {
        require __DIR__.'/../config.php';
        $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if ($mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        return $mysqli;
    }
    public static function close($mysql) {
        $mysql->close();
    }
}