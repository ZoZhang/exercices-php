<?php

namespace Application\Controllers;

Class Frontend {

    public $view;

    function __construct() {
        $this->view = new \Application\Views\View();
    }

    /**
     * Affiche la page d'accueil
     */
    function index()
    {
        //Exemple de récupération d'une page en base de données
        $page_repository = new \Application\Models\PageRepository(); //on instancie un repository
        $donnees_page_accueil = $page_repository->read('accueil'); //on récupère les données depuis la base de données

        $page_accueil = new \Application\Models\Page( $donnees_page_accueil ); //on instancie un objet page (Un modèle) avec les données récupérées par le repository

        //On passe notre objet à la vue. Dans la fichier de la vue, on pourra utiliser la variable $page
        $this->view->setVar('page', $page_accueil);

        //Autre exemple pour passer des données à la View
        /***********************************************/
        //À compléter
        //On doit récupérer les articles depuis la base de données et les initialiser
        //puis les passer à la view
        /***********************************************/

        $posts = [];
        $article_repository = new \Application\Models\ArticleRepository();
        $article_donnees = $article_repository->all();

        if ($article_donnees) {
            foreach($article_donnees as $article) {
                $posts[] =  new \Application\Models\Article($article);
            }
            $this->view->setVar('posts', $posts);
        }

        //On donne le nom de la vue que l'on veut appeler
        $this->view->setVar('view', 'frontend/accueil');

        //on appelle la template, qui va utiliser la view que l'on a choisie
        //La fonction render utilise template.php par défaut, mais on peut lui spécifier une autre template en paramètre
        echo $this->view->render();
    
    }

    /**
     * Affiche une page
     * @param String $name: l'url de la page (colonne)
     */
    function page($name = "accueil")
    {
      if(isset($_GET['name']) and $_GET['name'] != "") $name = $_GET['name'];

        $page = new \Application\Models\Page([]);

        $this->view->setVar('page', $page);
        $this->view->setVar('view', 'frontend/'.$name);

        //on appelle la template, qui va utiliser la view que l'on a choisie
        echo $this->view->render();
    }

    /**
     * Affiche la page des articles
     * @param String $category : Permet de trier les articles par catégorie
     */
    function articles($category = null) {

        /***********************************************/
        //À compléter
        //On doit récupérer les articles depuis la base de données et les initialiser
        //puis les passer à une view
        /***********************************************/

        $category = !is_null($category) ? $category : $_GET['category'];

        $page_view = 'frontend/article';

        $page_article = new \Application\Models\Page([
            'post_title'    =>  'Page d\'arcitle ' . $category,
            'post_content'    =>  'Contenu de la page d\'arcitle sous la categorie <strong>' . $category .'</strong>'
        ]);

        $article_repository = new \Application\Models\ArticleRepository();
        $article_donnee = $article_repository->all([$category]);

        $posts = [];
        if ($article_donnee) {
            foreach($article_donnee as $article) {
                $posts[] =  new \Application\Models\Article($article);
            }

            $this->view->setVar('posts', $posts);
        } else {
            $page_view = 'articles not founds';
        }

        $this->view->setVar('page', $page_article);
        $this->view->setVar('view', $page_view);

        //on appelle la template, qui va utiliser la view que l'on a choisie
        echo $this->view->render();
    }

    /**
     * Affiche la page d'un article
     * @param String $name : Le nom de l'article à afficher
     */
    function article($name = null) {

        /***********************************************/
        //À compléter
        //On doit récupérer l'article depuis la base de données puis l'initialiser
        //puis le passer à une view
        /***********************************************/

        $name = isset($_GET['name']) && !empty($_GET['name']) ? $_GET['name'] : $name;

        $page_view = 'frontend/article-name';

        $page_article = new \Application\Models\Page([
            'post_title'    =>  'Page d\'arcitle',
            'post_content'    =>  'Contenu de la page d\'arcitle par son name <strong>' . $name .'</strong>'
        ]);

        $article_repository = new \Application\Models\ArticleRepository();
        $article_donnee = $article_repository->read($name);

        $posts = [];
        if ($article_donnee) {
           $posts[] =  new \Application\Models\Article($article_donnee);
           $this->view->setVar('posts', $posts);
        } else {
            $page_view = 'article';
        }

        $this->view->setVar('page', $page_article);
        $this->view->setVar('view', $page_view);

        //on appelle la template, qui va utiliser la view que l'on a choisie
        echo $this->view->render();
    }

    /**
     * Affiche et traite le formulaire de contact
     */
    function contact() {

        /***********************************************/
        //À compléter
        //On doit appeler le formulaire s'il n'y a pas de $_POST
        //S'il y a du $_POST, on doit le vérifier, l'enregistrer en base de données puis afficher un message
        /***********************************************/

        $page_view = 'frontend/contact';

        $page_article = new \Application\Models\Page([
            'post_title'    =>  'Page contact',
            'post_content'    =>  'Contenu de la page contact'
        ]);

        if (count($_POST)) {
            $response = ['error' => true, 'message' => []];

            $nom = isset($_POST['nom']) && !empty($_POST['nom']) ? $_POST['nom'] : null;
            $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : null;
            $message = isset($_POST['message']) && !empty($_POST['message']) ? $_POST['message'] : null;

            $data = ['nom' => $nom, 'email' => $email, 'message' => $message, 'date' => date('Y-m-d H:i:s')];

            if (!$nom) {
                $response['message'][] =  'Veuillez saissir votre nom.';
            }

            if (!$email) {
                $response['message'][] =  'L\'addresse email est obligatoire.';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['message'][] =  'Veuillez saissir une bonne addresse email.';
            }

            if (!$message) {
                $response['message'][] =  'Veuillez saissir votre message.';
            }

            if($nom && $email && $message){

                if (!get_magic_quotes_gpc()){
                    foreach ($data as &$val) {
                        if (is_string($val)) {
                            $val = addslashes($val);
                        }
                    }
                }

                $contact_repository = new \Application\Models\ContactRepository();
                $contact_donne = $contact_repository->create($data);

                if ($contact_donne) {
                    $response = [
                        'error' => false,
                        'message' => ['Merci pour votre message, nous vous répondrons dans les plus brefs délais']
                    ];

                    $data = [];
                } else {
                    $response['message'] =  ['Il y une erreur du server, réssayer régulièrement'];
                }
            }

            $this->view->setVar('contact_info', $data);
            $this->view->setVar('contact_response', $response);
        }

        $this->view->setVar('page', $page_article);
        $this->view->setVar('view', $page_view);

        //on appelle la template, qui va utiliser la view que l'on a choisie
        echo $this->view->render();
    }

    /**
     * Traite le formulaire de newsletter
     */
    function newsletter() {

        /***********************************************/
        /***********************************************/

        if (count($_POST)) {
            $response = ['newslettre_error' => true, 'newslettre_message' => []];
            $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : null;

            if (!$email) {
                $response['newslettre_message'][] = 'L\'addresse email est obligatoire.';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['newslettre_message'][] = 'Veuillez saissir une bonne addresse email';
            }

            $newslettre_repository = new \Application\Models\NewslettreRepository();
            $email_donnee = $newslettre_repository->read($email);

            if ($email_donnee) {
                $response['newslettre_message'][] = 'Cet e-mail est déjà abonné, veuillez essayer un autre e-mail';
            } else {

                $email_donnee = $newslettre_repository->create($email);
                if (!$email_donnee) {
                    $response['newslettre_message'][] = 'Il y une erreur du server, réssayer régulièrement';
                } else {
                    $response['newslettre_error'] = false;
                    $response['newslettre_message'][] = 'Félicitations, votre abonnement a réussi';
                }
            }

            $this->view->setVar('newslettre_response', $response);

            if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
                return $this->index();
            } else {

                $page_infos = explode('?', $_SERVER['HTTP_REFERER']);
                $page_infos = end($page_infos);
                parse_str($page_infos, $page_args);
 
                if (isset($page_args['action']) && 'newsletter' != $page_args['action'] && is_callable([$this, $page_args['action']])) {
                    $newArg = http_build_query($response);
                    $redirct_url = $_SERVER['HTTP_REFERER'] . '&' . $newArg;

                    header("Location: {$redirct_url}");
                    exit;

                    //$arg = end($page_args);
                    //              return call_user_func_array([$this, $page_args['action']], [$arg]);
                } else {
                    return $this->index();
                }
            }
        }
    }

    /**
     * Traite le formulaire de comments
     */
    function comments()
    {
        if (count($_POST)) {
            $response = ['error' => true, 'comment_message' => []];
            $id = isset($_POST['post_id']) && !empty($_POST['post_id']) ? $_POST['post_id'] : null;
            $nom = isset($_POST['nom']) && !empty($_POST['nom']) ? $_POST['nom'] : null;
            $email = isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : null;
            $content = isset($_POST['content']) && !empty($_POST['content']) ? $_POST['content'] : null;

            $redirct_url = $_SERVER['HTTP_REFERER'];
            $data = ['id' => $id, 'nom' => $nom, 'email' => $email, 'content' => $content, 'date' => date('Y-m-d H:i:s')];

            if(!$id) {
                $response['comment_message'][] =  'Il y une erreur du server, réssayer régulièrement';
                $response = array_merge($data, $response);
                $redirct_url .= '&' . http_build_query($response) . '#comments';
                header("Location: {$redirct_url}");
                exit;
            }

            if (!$nom) {
                $response['comment_message'][] =  'Veuillez saissir votre nom.';
            }

            if (!$email) {
                $response['comment_message'][] =  'L\'addresse email est obligatoire.';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response['comment_message'][] =  'Veuillez saissir une bonne addresse email.';
            }

            if (!$content) {
                $response['comment_message'][] =  'Veuillez saissir votre message.';
            }

            if($nom && $email && $content){

                if (!get_magic_quotes_gpc()){
                    foreach ($data as &$val) {
                        if (is_string($val)) {
                            $val = addslashes($val);
                        }
                    }
                }

                $contact_repository = new \Application\Models\CommentsRepository();
                $contact_donne = $contact_repository->create($data);

                if ($contact_donne) {
                    $data = [];
                    $response['error'] = false;
                    $response['comment_message'][] = 'Merci pour votre commentaire';
                } else {
                    $response['comment_message'][] =  'Il y une erreur du server, réssayer régulièrement';
                }
            }

            $response = array_merge($data, $response);
            $redirct_url .= '&' . http_build_query($response) . '#comments';
            header("Location: {$redirct_url}");
            exit;
        }
    }

}
