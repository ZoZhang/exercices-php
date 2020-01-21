<?php

namespace Application\Models;

require_once("Repository.php");

class CommentsRepository extends Repository
{
  function create($data)
  {
      $sql = "INSERT INTO `comments` (`post_id`, `comment_name`, `comment_email`, `comment_content`, `comment_date`) VALUES ('%s', '%s', '%s', '%s', '%s')";

      $sql = sprintf($sql, $data['id'], $data['nom'], $data['email'], $data['content'], $data['date']);

      $statement = $this->db->prepare($sql);

      try {
          $statement->execute();
      } catch (PDOException $e) {
          echo "Statement failed: " . $e->getMessage();
          return false;
      }

      return $statement->rowCount();
  }

  function update()
  {
  }

  function delete($ids = [])
  {
      $sql = "DELETE FROM comments WHERE ";
      $where =  sprintf("post_id in (%s)", $ids);

      $sql .=  $where;

      $statement = $this->db->prepare($sql);

      try {
          $statement->execute();
      } catch (PDOException $e) {
          echo "Statement failed: " . $e->getMessage();
          return false;
      }

      return $statement->rowCount();
  }

  function all($post_id)
  {
      $sql = sprintf("SELECT * FROM comments WHERE post_id=%d order by comment_date desc", $post_id);
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
