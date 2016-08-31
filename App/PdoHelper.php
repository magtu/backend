<?php

namespace App;

class PdoHelper
{
  private static $dbh = null;
  public static function get()
  {
    if (PdoHelper::$dbh) {
      return PdoHelper::$dbh;
    }
    try {
      require_once '../config.php';
      PdoHelper::$dbh = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=UTF8',DB_USER,DB_PASS);
    } catch(PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
    return PdoHelper::$dbh;
  }
}
