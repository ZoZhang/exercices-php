<?php

namespace Application\Models;

use Exception;

abstract class Repository
{
  protected $db;

  function __construct()
  {
    $this->db = $this->connexion();
  }

  protected function connexion()
  {
    try {

      if (DB_DRIVER == 'sqlite') $db = new \PDO('sqlite:' . DB_PATH);
      else $db = new \PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PWD);

    } catch (Exception $e) {
      print "Erreur de connexion à la base de données : " . $e->getMessage() . "<br/>";
      die();
    }
    return $db;
  }
}
