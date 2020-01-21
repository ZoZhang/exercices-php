<?php

namespace Application\Models;

class Comments extends Post
{

    function __construct($data) {
        $this->setData($data);
    }

    function setData($data)
    {
        foreach($data as $key  =>  $val) {
            $this->$key = $val;
        }

        return $this;
    }

    function __call($name, $args)
    {
        return $this->$name;
    }

    //Getter & Setters différent?

}