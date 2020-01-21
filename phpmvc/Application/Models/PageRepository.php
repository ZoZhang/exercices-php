<?php

namespace Application\Models;

require_once("Repository.php");

class PageRepository extends Repository
{
  /**
   * Crée une page dans la base de données
   */
  function create()
  {
  }

  /**
   * Récupère une page dans la base de données
   */
  function read($name)
  {
    $statement = $this->db->prepare('SELECT * from posts WHERE post_type="page" and post_name="'.$name.'"');
    
    try {

      $statement->execute();
    
    } catch (PDOException $e) {
      echo "Statement failed: " . $e->getMessage();
      return false;
    }

    return $statement->fetch();
  }

  /**
   * Met une page à jour dans la base de données
   */
  function update($name)
  {
  }

  /**
   * Efface une page de la base de données
   */
  function delete($name)
  {
  }

  /**
   * Récupère une liste de pages depuis la base de données
   * @param $categories la catégorie à séléctionner
   */
  function all($categories = array())
  {
  }
}
