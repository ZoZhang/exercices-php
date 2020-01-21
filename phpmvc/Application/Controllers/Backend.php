<?php

namespace Application\Controllers;

Class Backend {

    public $view;

    protected $page;

    function __construct()
    {
        $this->view = new \Application\Views\View();

        $request_uri = $_SERVER['REQUEST_URI'];
        $base_url = 'http://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];

        $this->page = [
            'base_url'  => $base_url,
            'request_uri'  => $request_uri
        ];
    }

    function index()
    {
        $redirct_url = sprintf('%s?type=admin&action=login', $this->page['base_url']);
        header("Location: {$redirct_url}");
        exit;
    }

    /**
     *  l’ajout, l’édition et la suppression d’un article.
     */
    function login()
    {
        $page_view = 'backend/login';
        $redirct_url = sprintf('%s?type=admin&action=articles', $this->page['base_url']);
        $reference_url = isset($_GET['reference_url']) ? base64_decode($_GET['reference_url']) : $redirct_url;

        if (count($_POST)) {

            $response = ['error' => true, 'message' => []];
            $username = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : null;
            $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;

            if(!$username) {
                $response['message'][] =  'Veuillez saissir votre username';
            }

            if (!$password) {
                $response['message'][] =  'Veuillez saissir votre mot de passe';
            }

            $data = ['username'=> $username, 'password' => $password];

            if($username && $password){

                $user_model = new \Application\Models\User();
                if ($user_model->login($username, $password)) {
                    header("Location: {$reference_url}");
                    exit;
                } else {
                    $response['message'][] = 'L\'utilisateur n\'existe pas, veuillez ressaisir';
                }
            }

            $this->view->setVar('infos', $data);
            $this->view->setVar('response', $response);
        }

        $this->view->setVar('view', $page_view);
        //on appelle la template, qui va utiliser la view que l'on a choisie
        echo $this->view->render('template-admin');
    }

    function logout()
    {
        $user_model = new \Application\Models\User();
        $user_model->logout();
        $redirct_url = $this->page['base_url'];
        header("Location: {$redirct_url}");
        exit;
    }

    function articles()
    {
        // vérifier l'autentification.
        $page_view = 'backend/articles';

        $admin_model = new \Application\Models\User();
        $reference_url = $this->page['base_url'] . $this->page['request_uri'];

        if (!$user_id = $admin_model->isLogin()) {
            $redirct_url = sprintf('%s?action=login&type=admin&reference_url=%s', $this->page['base_url'], base64_encode($reference_url));
            header("Location: {$redirct_url}");
            exit;
        }

        $user_name = $admin_model->user_name();

        $id = isset($_POST['id']) && $_POST['id'] ? $_POST['id'] : (isset($_GET['id']) && $_GET['id'] ? $_GET['id'] : null);
        $method = isset($_POST['method']) && $_POST['method'] ? $_POST['method'] : (isset($_GET['method']) && $_GET['method'] ? $_GET['method'] : null);
        $response = ['error' => true, 'message' => []];

        switch ($method) {

                case 'delete':

                    $ids = isset($_POST['selected']) && $_POST['selected'] ? $_POST['selected'] : null;

                    if (!$ids && !$id) {
                        $response['message'][] =  'Vous devez sélectionner au moins un article à supprimer';
                    } else {

                        $delete = $ids;

                        if ($id) {
                            $delete[] = $id;
                        }

                        $delete_ids = implode(',', $delete);

                        $comments_repository = new \Application\Models\CommentsRepository();
                        $is_comment_delete = $comments_repository->delete($delete_ids);

                        $media_repository = new \Application\Models\MediaRepository();
                        $media_donnee = $media_repository->read($id);
                        $is_media_delete = $media_repository->delete($delete_ids);
                         
                        if ($media_donnee && false !== $is_media_delete) {
                             $media_model = new \Application\Models\Media;
                             $media_model->delete_image($media_donnee['post_name']);
                        }

                        if (false !== $is_comment_delete && false !== $is_media_delete) {

                            $article_repository = new \Application\Models\ArticleRepository();
                            $is_article_delete = $article_repository->delete($delete_ids);

                            if (false !== $is_article_delete) {
                                $method = null;
                                $response['error'] = false;
                                $response['message'][] =  'Article supprimé avec succès';
                            } else {
                                $response['message'][] =  'Il y une erreur du server, réssayer régulièrement';
                            }
                        }
                    }
                    break;

            case 'add':

                    unset($_POST['id']);
                    unset($_POST['method']);

                    if (count($_POST)) {

                        $new_article = array_merge($_POST, [
                            'post_author'    => $user_id,
                            'post_date'    => date('Y-m-d H:i:s'),
                            'post_type'    => 'article'
                        ]);

                        if (!get_magic_quotes_gpc()){
                            foreach ($new_article as &$val) {
                                if (is_string($val)) {
                                    $val = addslashes($val);
                                }
                            }
                        }

                        $article_repository = new \Application\Models\ArticleRepository();
                        $new_article_id = $article_repository->create($new_article);

                        if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
                            $media_model = new \Application\Models\Media;
                            $upload_image = $media_model->upload_image($_FILES['image']);

                            if (is_string($upload_image)) {

                                $update_media = [
                                    'post_name' => $upload_image,
                                    'post_title' => $new_article['post_title'],
                                    'post_author'    => $user_id,
                                    'post_status'    => 'publish',
                                    'post_date'    => date('Y-m-d H:i:s'),
                                    'post_type'    => 'file'
                                ];

                                $media_repository = new \Application\Models\MediaRepository();
                                $is_media_added = $media_repository->create($new_article_id, $update_media);

                                if (false !== $new_article_id && false !== $is_media_added) {
                                    $method = 'edit';
                                    $response['error'] = false;
                                    $response['message'][] =  'Article ajouté avec succès';
                                } else {
                                    $response['message'][] =  'Il y une erreur du server, réssayer régulièrement';
                                }

                            } else if ($upload_image['error']) {
                                $response['error'] = true;
                                $response['message'][] =  $upload_image['message'];
                            }

                        } else {
                            if (false !== $new_article_id) {
                                $method = 'edit';
                                $response['error'] = false;
                                $response['message'][] =  'Article ajouté avec succès';
                            } else {
                                $response['message'][] =  'Il y une erreur du server, réssayer régulièrement';
                            }
                        }
                    }

                    if ('edit' == $method) {
                        $article_repository = new \Application\Models\ArticleRepository();
                        $article_donnees = $article_repository->read($id);
                        $posts = new \Application\Models\Article($article_donnees);
                        $this->view->setVar('posts', $posts);
                    }
                break;

                case 'edit':

                    if (!$id) {
                        $response['message'][] =  'Vous devez sélectionner au moins un article à modifier';
                    } else {

                        if (count($_POST)) {
                            unset($_POST['id']);
                            unset($_POST['method']);

                            $update_article = $_POST;

                            $article_repository = new \Application\Models\ArticleRepository();
                            $is_article_updated = $article_repository->update($id, $update_article);

                            if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
                                $media_model = new \Application\Models\Media;
                                $upload_image = $media_model->upload_image($_FILES['image']);

                                if (is_string($upload_image)) {

                                    $update_media = [
                                        'post_name' => $upload_image,
                                        'post_title' => $update_article['post_title'],
                                        'post_author'    => $user_id,
                                        'post_status'    => 'publish',
                                        'post_date'    => date('Y-m-d H:i:s'),
                                        'post_type'    => 'file'
                                    ];

                                    $media_repository = new \Application\Models\MediaRepository();
                                    $media_donnee = $media_repository->read($id);

                                    if ($media_donnee) {
                                        $is_media_updated = $media_repository->update($media_donnee['id'], $update_media);
                                    } else {
                                        $is_media_updated = $media_repository->create($id, $update_media);
                                    }

                                    if (false !== $is_article_updated && false !== $is_media_updated) {
                                            $media_model->delete_image($media_donnee['post_name']);

                                            $response['error'] = false;
                                            $response['message'][] =  'Article modifié avec succès';
                                        } else {
                                            $response['message'][] =  'Il y une erreur du server, réssayer régulièrement';
                                        }

                                } else if ($upload_image['error']) {
                                    $response['error'] = true;
                                    $response['message'][] =  $upload_image['message'];
                                }

                            } else {
                                if (false !== $is_article_updated) {
                                    $response['error'] = false;
                                    $response['message'][] =  'Article modifié avec succès';
                                } else {
                                    $response['message'][] =  'Il y une erreur du server, réssayer régulièrement';
                                }
                            }
                        }

                        $article_repository = new \Application\Models\ArticleRepository();
                        $article_donnees = $article_repository->read($id);
                        $posts = new \Application\Models\Article($article_donnees);
                        $this->view->setVar('posts', $posts);
                    }
                    break;
            }

        if (!$method) {
            $posts = [];
            $article_repository = new \Application\Models\ArticleRepository();
            $article_donnees = $article_repository->all();

            if ($article_donnees) {
                foreach($article_donnees as $article) {
                    $posts[] =  new \Application\Models\Article($article);
                }
            }
            $this->view->setVar('posts', $posts);
        }

        $this->view->setVar('user_name', $user_name);
        $this->view->setVar('method', $method);
        $this->view->setVar('view', $page_view);
        $this->view->setVar('response', $response);
        echo $this->view->render('template-admin');
    }

}
