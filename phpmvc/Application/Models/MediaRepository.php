<?php

namespace Application\Models;

require_once("Repository.php");

class MediaRepository extends Repository
{
    function create($post_id1, $data = [])
    {
        $sql = 'INSERT INTO `posts` (`post_author`, `post_date`, `post_title`, `post_status`, `post_name`, `post_type`) VALUES';
        $sql .= sprintf('(\'%s\',\'%s\',\'%s\',\'%s\',\'%s\',\'%s\')', $data['post_author'], $data['post_date'], $data['post_title'], $data['post_status'], $data['post_name'], $data['post_type']);

        $statement = $this->db->prepare($sql);

        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Statement failed: " . $e->getMessage();
            return false;
        }

        $post_id2 = $this->db->lastInsertId();

        $this->bind($post_id1, $post_id2);

        return $post_id2;
    }

    function bind($post_id1, $post_id2)
    {
        $sql = 'INSERT INTO `posts_posts` (`post_id1`, `post_id2`) VALUES';
        $sql .= sprintf('(%d,%d)',$post_id1, $post_id2);

        $statement = $this->db->prepare($sql);

        try {
            $statement->execute();
        } catch (PDOException $e) {
            echo "Statement failed: " . $e->getMessage();
            return false;
        }

        return true;
    }

    function read($id) {
      $statement = $this->db->prepare('SELECT p.id,p.post_title, p.post_name FROM `posts_posts` pp LEFT JOIN `posts` p ON pp.post_id2 = p.id AND p.post_type = \'file\' where pp.post_id1 =' . $id);
  
      try {
  
        $statement->execute();
      } catch (PDOException $e) {
        echo "Statement failed: " . $e->getMessage();
        return false;
      }
  
      return $statement->fetch();
    }

    function update($id, $data = [])
    {
        $sql = 'UPDATE posts SET ';

        foreach ($data as $key => $val) {
            $sql .= sprintf('%s=\'%s\',', $key, $val);
        }

        $sql = substr($sql, 0, -1);
        $sql .=  sprintf(' WHERE id =%d AND post_type=\'file\'', $id);

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
        $sql = "DELETE pp.*,p.* FROM posts_posts as pp LEFT JOIN posts as p ON pp.post_id2 = p.id WHERE";
        $where =  sprintf(" pp.post_id1 in (%s)", $ids);

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
}