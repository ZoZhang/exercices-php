<?php
require 'Application/Bootstrap.php'; //Contient les informations de configuration de l'application

session_start(); //démarre une session PHP, pour que l'on puisse utiliser $_SESSION (pour l'identification utilisateur par exemple)

//récupère le paramètre "action" de l'url qui sera utilisé par le contrôleur
if (!isset($_GET['action'])) {
  $action = "accueil";
} else {
  $action = $_GET['action'];
}

$controller = new Application\Controllers\Frontend(); //Crée un objet Frontend, qui est le contrôleur de base de l'application

if (isset($_GET['type']) && 'admin' == $_GET['type']) {
    $controller = new Application\Controllers\Backend();
}

if (is_callable(array($controller, $action))) { //on vérifie si la méthode "$action" existe dans le contrôleur "$controller"
  $controller->$action(); //si oui, on l'appelle
} else {
  $controller->index(); //si non, on appelle la méthode index(), ou une méthode d'erreur par exemple
}
