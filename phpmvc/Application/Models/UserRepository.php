<?php

namespace Application\Models;

require_once("Repository.php");

class UserRepository extends Repository
{
    function create() {

    }

    function read($data)
    {
        $sql = 'SELECT * FROM users ';
        $where = sprintf('WHERE id=%d', $data);

        if (!is_numeric($data)) {
            $where = sprintf('WHERE user_login=\'%s\'', $data);
        }

        $sql .= $where;
        $statement = $this->db->prepare($sql);
  
       try {
         $statement->execute();
       } catch (PDOException $e) {
        echo "Statement failed: " . $e->getMessage();
        return false;
      }
  
      return $statement->fetch();
    }

    function update() {

    }

    function delete() {

    }

    function all() {
        
    }
}