<?php

namespace Application\Views;

class View
{
    protected $data;

    /**
     * Cette fonction a pour but de produire l'affichage de l'application
     * Elle inclut le fichier template.php
     * 
     * Dans les méthodes des contrôleurs (comme Frontend.php):
     * 
     *  On donne le nom de la vue que l'on veut utiliser avec (par exemple):
     *   $this->view->setVar('view', 'frontend/accueil'); // ->va chercher le fichier Application/Views/frontend/accueil.php
     * 
     *  Pour passer des variables depuis le contrôleur vers la vue, on écrit dans la méthode du contrôleur: 
     *   $this->view->setVar('posts', $des_posts);
     *  alors dans le fichier de la vue, on pourra utiliser la variable $posts pour accéder aux valeurs de $des_posts
     */
    function render($template = 'template') {
        ob_start();
        // you can access $this->data in template
        require "Application/Views/".$template.".php";
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

    /**
     * Cette fonction permet de passer des variables depuis le contrôleur vers la vue
     */
    function setVar($key, $val) {
        $this->data[$key] = $val;
    }
}