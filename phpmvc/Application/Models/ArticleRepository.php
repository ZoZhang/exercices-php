<?php

namespace Application\Models;

require_once("Repository.php");

class ArticleRepository extends Repository
{
  function create($data = [])
  {
      $sql = 'INSERT INTO `posts` (`post_author`, `post_date`, `post_content`, `post_title`, `post_status`, `post_name`, `post_type`, `post_category`) VALUES';
      $sql .= sprintf('(\'%s\',\'%s\',\'%s\',\'%s\',\'%s\',\'%s\',\'%s\',\'%s\')', $data['post_author'], $data['post_date'], $data['post_content'], $data['post_title'], $data['post_status'], $data['post_name'], $data['post_type'], $data['post_category']);

      $statement = $this->db->prepare($sql);

      try {
          $statement->execute();
      } catch (PDOException $e) {
          echo "Statement failed: " . $e->getMessage();
          return false;
      }

      return $this->db->lastInsertId();
  }

  function read($data, $options = [])
  {
      $where = '';
      $sql = 'SELECT * FROM posts WHERE post_type=\'article\'';

      if (is_numeric($data)) {
          $where .= sprintf('AND id=%d', $data);
      } else if (is_string($data)) {
          $where .= sprintf('AND post_name="%s"', $data);
      } else if (is_null($data)) {
          $where = ' AND post_type="article"';
      }

      if (isset($options['status'])) {
          $where .= sprintf(' AND post_status=\'%s', $options['status']);
      }

      if (is_null($data)) {
          $where .= 'order by post_date desc limit 0,1';
      }

      $sql .=  $where;

      $statement = $this->db->prepare($sql);

      try {
      $statement->execute();
    } catch (PDOException $e) {
      echo "Statement failed: " . $e->getMessage();
      return false;
    }

    return $statement->fetch();
  }

  function update($id = null, $data = [])
  {
      $sql = 'UPDATE posts SET ';

      foreach ($data as $key => $val) {
          $sql .= sprintf('%s=\'%s\',', $key, $val);
      }

      $sql = substr($sql, 0, -1);
      $sql .=  sprintf(' WHERE id =%d', $id);

      $statement = $this->db->prepare($sql);

      try {
          $statement->execute();
      } catch (PDOException $e) {
          echo "Statement failed: " . $e->getMessage();
          return false;
      }

      return $statement->rowCount();
  }

  function delete($ids = [])
  {
      $sql = "DELETE FROM posts WHERE ";
      $where =  sprintf("id in (%s)", $ids);

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

  function all($categories = [], $options = [])
  {
      $sql = "SELECT * FROM posts WHERE post_type='article'";

      if (count($categories)) {
          $categories = implode('\',\'', $categories);
          $where = " AND post_category in('".$categories."')";
      } else {
          $where =  " AND post_category is not null";
      }

      if (isset($options['status'])) {
          $where .= sprintf(' AND post_status=\'%s', $options['status']);
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
