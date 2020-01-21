<?php

namespace Application\Models;

abstract class Post
{
    protected $id;
    protected $author;
    protected $date;
    protected $content;
    protected $title;
    protected $status;
    protected $name;
    protected $category;

    function _construct() {

    }

    //Getter & Setters
    
    function title() {
        return $this->title;
    }

    function content() {
        return $this->content;
    }
}