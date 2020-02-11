<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const CREATED_AT = 'post_date';
    const UPDATED_AT = 'update_date';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'post_id';

    /**
     * The post Author for the model.
     *
     * @var string
     */
    protected $post_author = 'post_author';

    /**
     * The post Author for the model.
     *
     * @var string
     */
    protected $post_name = 'post_name';

    /**
     * The post Author for the model.
     *
     * @var string
     */
    protected $post_type = 'post_type';

    /**
     * The post Author for the model.
     *
     * @var string
     */
    protected $post_title = 'post_title';

    /**
     * The post Author for the model.
     *
     * @var string
     */
    protected $post_content = 'post_content';

}
