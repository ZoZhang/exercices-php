<?php

namespace Application\Models;

class User
{
    protected $allow_fields = [
        'id' => 'id',
        'user_login' => 'user_name'
    ];

    function __construct($data=[]) {
        $this->setData($data);
    }

    function setData($data)
    {
        if (!count($data)) {
            return $this;
        }

        foreach($data as $key   =>  $val) {

            if (!array_key_exists($key, $this->allow_fields)) {
                continue;
            }

            $newKey = $this->allow_fields[$key];

            $this->$newKey = $val;
        }
    }

    function login($username, $password)
    {
        $user_repository = new \Application\Models\UserRepository();
        $user_donne = $user_repository->read($username);

        if (!$user_donne) {
            return false;
        }

        if ($username === $user_donne['user_login'] && $password == $user_donne['user_pass']) {
            $_SESSION['user_id'] = $user_donne['id'];
            $_SESSION['user_name'] = $user_donne['user_login'];
        } else {
            return false;
        }

        return true;
    }

    function isLogin()
    {
        if (isset($_SESSION['user_id']) && $_SESSION['user_id']) {
            $this->user_name = $_SESSION['user_name'];
            return $_SESSION['user_id'];
        }
      return false;
    }

    function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
    }

    function __call($name, $args)
    {
        if (!in_array($name, $this->allow_fields)) {
            return;
        }

        return $this->$name;
    }
}