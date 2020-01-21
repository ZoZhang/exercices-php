<?php
$response = [];
$page = isset($_GET['action']) ? $_GET['action'] : 'index';
$infos = isset($this->data['contact_info']) ? $this->data['contact_info']: [];

$infos = [
    'nom'   => isset($_GET['nom']) ? $_GET['nom'] : '',
    'email'   => isset($_GET['email']) ? $_GET['email'] : '',
    'content'   => isset($_GET['content']) ? $_GET['content'] : '',
];

if(isset($_GET['error']) && isset($_GET['comment_message'])){
    $response = [
        'error' => $_GET['error'],
        'comment_message' => $_GET['comment_message']
    ];
}
?>
<div class="blog-post">
    <h3><a href="?action=article&name=<?=$post->name()?>"><?=$post->title()?></a> <small><?=$post->date()?></small></h3>
    <a href="?action=article&name=<?=$post->name()?>"><img class="thumbnail" src="<?=$post->media()?>" title="<?=$post->alt()?>" style="width: 100%;"></a>
    <p><?=$post->content()?></p>
    <div class="callout">
        <ul class="menu simple">
            <li class="float-left">
                <a  href="<?php echo BASE_URL."?action=author&name=mike" ?>">Auteur: <?=$post->author()?></a>
            </li>
            <li class="float-right">
                <a href="?action=article&name=<?=$post->name()?>#comments">Comments: <?=count($post->comments())?></a>
            </li>
            <li>&nbsp;</li>
        </ul>
    </div>

    <?php if('article' == $page):?>

        <?php if(count($post->comments())):?>
            <div class="callout">
                <div id="comments">
                    <ul>
                    <?php foreach($post->comments() as $comment):?>
                        <div class="callout warning">
                            <li class="no-bullet"><strong>Nom: </strong><?=$comment->comment_name();?></li>
                            <li class="no-bullet">Date: <?=$comment->comment_date();?></li>
                            <li class="no-bullet">Email: <?=$comment->comment_email();?></li>
                            <li class="no-bullet">Content: <?=$comment->comment_content();?></li>
                        </div>
                    <?php endforeach;?>
                    </ul>
                </div>
            </div>
        <?php endif;?>

        <div class="callout primary">
            <div class="row column text-center">
                <form method="post" action="<?php echo BASE_URL; ?>?action=comments">

                    <?php if(count($response)):?>
                        <?php foreach($response['comment_message'] as $message):?>
                            <div class="callout <?=$response['error'] ? 'warning form-error is-visible' : 'success';?>">
                                <?=$message?>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>

                    <input type="hidden" name="post_id" value="<?=$post->id()?>"/>

                    <div class="columns">
                        <div class="small-3 columns">
                            <label for="nom" class="text-right middle"><strong>Nom</strong></label>
                        </div>
                        <div class="small-9 columns">
                            <input type="text" id="nom" name="nom" value="<?=isset($infos['nom']) ? $infos['nom'] : ''?>" placeholder="Veuillez saisir votre adresse nom">
                        </div>
                    </div>

                    <div class="columns">
                        <div class="small-3 columns">
                            <label for="email" class="text-right middle"><strong>Email</strong></label>
                        </div>
                        <div class="small-9 columns">
                            <input type="email" id="email" name="email" value="<?=isset($infos['email']) ? $infos['email'] : ''?>" placeholder="Veuillez saisir votre adresse e-mail">
                        </div>
                    </div>

                    <div class="columns">
                        <div class="small-3 columns">
                            <label for="content" class="text-right middle"><strong>Commentaire</strong></label>
                        </div>
                        <div class="small-9 columns">
                            <textarea id="content" style="min-height: 150px" name="content" placeholder="Veuillez saisir votre commentaire"><?=isset($infos['content']) ? $infos['content'] : ''?></textarea>
                        </div>
                    </div>

                    <div class="input-group-button">
                        <input type="submit" class="button" value="Envoie">
                    </div>
                </form>
            </div>
        </div>
    <?php endif;?>
</div>


