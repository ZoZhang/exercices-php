<?php

namespace Application\Models;

define('ROOT_DIR', dirname(dirname(dirname(__FILE__))));

class Media extends Post
{
    const IMAGE_DIR = '/public/images/';
    const ALLOW_TYPE = ['jpeg', 'jpg', 'png', 'gif'];

    protected $allow_fields = [
        'post_title' => 'alt',
        'post_name' => 'media'
    ];

    function __construct($data = [])
    {
        if (count($data)) {
            $this->setData($data);
        }
    }

    function setData($data)
    {
        foreach($data as $key   =>  $val) {

            if (!array_key_exists($key, $this->allow_fields)) {
                continue;
            }

            $newKey = $this->allow_fields[$key];

            if ('media' == $newKey) {
                $val  =  self::IMAGE_DIR . $val;
            }

            $this->$newKey =  $val;
        }
    }

    function __call($name, $args)
    {
        if (!in_array($name, $this->allow_fields)) {
            return;
        }

        return $this->$name;
    }

    function upload_image($file)
    {
        $response = ['error' => true, 'message' => ''];
        $target_dir =  ROOT_DIR . self::IMAGE_DIR ;
        $target_name = basename($file["name"]);
        $target_file = $target_dir . $target_name;

        if (!is_writeable($target_dir)) {
            $response['message'] = 'Veuillez définir correctement les autorisations d\'écriture de répertoire ' . $target_dir;
            return $response;
        }

        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if (!in_array($imageFileType, self::ALLOW_TYPE)) {
            $response['message'] = 'Veuillez sélectionner le type d\'image correct, seuls jpeg, jpg, git, png';
            return $response;
        }

        if (file_exists($target_file)) {
            $target_name =  time() . '-' . basename($file["name"]);
            $target_file = $target_dir . $target_name;
        }

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $response['error'] = false;
            return $target_name;
        }

        return false;
    }

    function delete_image($file)
    {
        $response = ['error' => true, 'message' => ''];
        $target_dir =  ROOT_DIR . self::IMAGE_DIR ;
        $target_name = basename($file);
        $target_file = $target_dir . $target_name;

        if (file_exists($target_file)) {
            unlink($target_file);
        }
        return $response;
    }

}