<?php

namespace Application\Models;

class Page extends Post
{

    function __construct($values) {
        $this->title = isset($values['post_title']) ? $values['post_title']:null;
        $this->content = isset($values['post_content']) ? $values['post_content']:null;
    }

    //Getter & Setters différent?

}