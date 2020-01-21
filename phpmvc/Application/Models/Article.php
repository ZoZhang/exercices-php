<?php

namespace Application\Models;

class Article extends Post
{
    protected $allow_fields = [
        'id' => 'id',
        'post_author' => 'author',
        'post_date' => 'date',
        'post_content' => 'content',
        'post_title' => 'title',
        'post_alt' => 'alt',
        'post_status' => 'status',
        'post_name' => 'name',
        'post_media' => 'media',
        'post_comments' => 'comments',
        'post_category' => 'category'
    ];

    function __construct($data) {
        $this->setData($data);
    }

    function setData($data)
    {
        foreach($data as $key  =>  $val) {

            if (!array_key_exists($key, $this->allow_fields)) {
                continue;
            }

            $newKey = $this->allow_fields[$key];

            // mettre user information
            if ('author' == $newKey) {
                $user_repository = new \Application\Models\UserRepository();
                $donnee_user = $user_repository->read($val);

                if ($donnee_user) {
                    $user_model = new \Application\Models\User($donnee_user);
                    $val = $user_model->user_name();
                }
            }

            // mettre media information
            if ('id' == $key) {
                $media_repository = new \Application\Models\MediaRepository();
                $donnee_media = $media_repository->read($val);

                if ($donnee_media) {
                    $media_model = new \Application\Models\Media($donnee_media);
                    $this->alt = $media_model->alt();
                    $this->media = $media_model->media();
                }
            }

            $this->$newKey = $val;
        }

        // commentaires
        $this->comments = [];
        $comments_repository = new \Application\Models\CommentsRepository();
        $donnee_comment = $comments_repository->all($this->id());

        if($donnee_comment) {
            foreach($donnee_comment as $donnee) {
                $comments_model = new \Application\Models\Comments($donnee);
                $this->comments[] = $comments_model;
            }
        }

        return $this;
    }

    function __call($name, $args)
    {
        if (!in_array($name, $this->allow_fields)) {
            return;
        }

        return $this->$name;
    }

    //Getter & Setters différent?

}