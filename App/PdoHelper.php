<?php

namespace Magtu\App;

class PdoHelper
{
  private static $dbh = null;
  public static function get()
  {
    if ($dbh) {
      return $dbh;
    }
    try {
      $dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PASS);
    } catch(PDOException $e) {
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
    }
    return $dbh;
  }
}
