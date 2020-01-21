<?php

namespace Application\Models;

require_once("Repository.php");

class NewslettreRepository extends Repository
{
  function create($email)
  {
      $sql = "INSERT INTO `newsletter` (`newsletter_email`) VALUES ('".$email."')";

      $statement = $this->db->prepare($sql);

      try {
          $statement->execute();
      } catch (PDOException $e) {
          echo "Statement failed: " . $e->getMessage();
          return false;
      }

      return $statement->rowCount();
  }

  function read($email)
  {
      $sql = "SELECT * FROM newsletter WHERE newsletter_email='".$email."'";

      $statement = $this->db->prepare($sql);

      try {
      $statement->execute();
    } catch (PDOException $e) {
      echo "Statement failed: " . $e->getMessage();
      return false;
    }
    return $statement->fetch();
  }

  function update()
  {
  }

  function delete()
  {
  }

  function all($categories = array())
  {
      $where = "";
      $sql = "SELECT * FROM posts WHERE ";

      if (count($categories)) {
          $categories = implode('\',\'', $categories);
          $where = "post_category in('".$categories."')";
      } else {
          $where =  "post_category is not null";
      }

      $sql .=  $where;

      $statement = $this->db->prepare($sql);

      try {

          $statement->execute();
      } catch (PDOException $e) {
          echo "Statement failed: " . $e->getMessage();
          return false;
      }

      return $statement->fetchAll();
  }
}
