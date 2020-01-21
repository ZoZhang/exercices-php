<?php
//afficher les erreurs PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/**
 * Identifiants de la base de données
 */
//DEFINE('DB_DRIVER','sqlite');
//DEFINE('DB_PATH', realpath("./database.sqlite") );

DEFINE('DB_DRIVER','mysql'); //décommenter pour utiliser MySQL plutôt que SQLite (il faut alors commenter la ligne 11)
DEFINE('DB_HOST','localhost');
DEFINE('DB_NAME','exercice_blog');
DEFINE('DB_USER','root');
DEFINE('DB_PWD','root');

/**
 * Base URL du site pour générer des liens dans l'application
 */
// $base_url = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
$base_url = '/';
DEFINE('BASE_URL',$base_url);


/**
 * Chargement automatique des classes
 * Lorsque l'on crée un objet avec "new", cette fonction est appelée pour inclure les fichiers automatiquement
 */
function autoload($class)
{
    //le nom de la class appellée avec le namespace est du type "Application\Models\Post". Avec la fonction substr on récupère la dernière partie du nom, après le \
    $class = substr($class, strrpos($class, '\\') + 1); 

    //on vérifie que le fichier existe et si oui on l'inclut
    if (is_file('Application/Models/'.$class . '.php')) {
        require_once 'Application/Models/'.$class . '.php';
    } 

    //on vérifie que le fichier existe et si oui on l'inclut
    if (is_file('Application/Views/'.$class . '.php')) {
        require_once 'Application/Views/'.$class . '.php';
    } 

    //on vérifie que le fichier existe et si oui on l'inclut
    if (is_file('Application/Controllers/'.$class . '.php')) {
        require_once 'Application/Controllers/'.$class . '.php';
    } 
}
spl_autoload_register('autoload'); // On enregistre la fonction en autoload pour qu'elle soit appelée dès qu'on essaie d'instancier une classe non déclarée.
