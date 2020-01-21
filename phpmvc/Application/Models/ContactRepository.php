<?php

namespace Application\Models;

require_once("Repository.php");

class ContactRepository extends Repository
{

  function create($data)
  {
      $sql = "INSERT INTO `contact` (`contact_name`, `contact_email`, `contact_message`, `contact_date`) VALUES ('%s', '%s', '%s', '%s')";

      $sql = sprintf($sql, $data['nom'], $data['email'], $data['message'], $data['date']);

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
