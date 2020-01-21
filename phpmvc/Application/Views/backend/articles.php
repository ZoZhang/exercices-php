<?php
$response = $this->data['response'];

?>
<div style="max-width:90%;margin:2em auto;">

    <form method="post" action="<?php echo BASE_URL;?>?action=articles&type=admin" enctype="multipart/form-data">

    <!-- article list page -->
    <?php if (!in_array($this->data['method'], ['add','edit'])):?>

        <div class="callout primary">
            <ul>
                <li class="no-bullet float-left">Bienvenu, <?=$this->data['user_name'];?></li>
                <li class="no-bullet float-right"><a href="<?php echo BASE_URL;?>?action=logout&type=admin" class="button hollow">Déconnexion</a></li>
                <li class="no-bullet float-right"><button onclick="return confirm('Voulez-vous vraiment supprimer tous les articles ?');" value="delete" name="method" class="button hollow alert">Suppression</button></li>
                <li class="no-bullet float-right"><button value="add" name="method" class="button hollow primary">Ajout</button></li>
                <div style="clear: both;"></div>
            </ul>
        </div>

        <?php if(count($response)):?>
            <?php foreach($response['message'] as $message):?>
                <div class="callout <?=$response['error'] ? 'warning form-error is-visible' : 'success';?>">
                    <?=$message?>
                </div>
            <?php endforeach;?>
        <?php endif;?>

        <div class="callout primary" style="">
            <table style="width:100%;">
                <colgroup>
                    <col span="1" style="width: 1%;">
                    <col span="1" style="width: 20%;">
                    <col span="1" style="width: 38%;">
                    <col span="1" style="width: 10%;">
                    <col span="1" style="width: 10%;">
                    <col span="1" style="width: 10%;">
                    <col span="1" style="width: 10%;">
                </colgroup>
                <thead>
                <th>&nbsp;</th>
                <th>Image</th>
                <th>Titre</th>
                <th>Auteur</th>
                <th>Status</th>
                <th>Catégorie</th>
                <th>Operation</th>
                </thead>
                <tbody>
                <?php foreach($this->data['posts'] as $post) :?>
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="<?=$post->id();?>"/></td>
                        <td><img class="thumbnail" src="<?=$post->media()?>" title="<?=$post->alt()?>" style="max-width:100%;"></td>
                        <td><span><?=$post->title()?></span></td>
                        <td><span><?=$post->author()?></span></td>
                        <td><span><?=$post->status()?></span></td>
                        <td><span><?=$post->category()?></span></td>
                        <td>
                            <a href="<?php echo BASE_URL;?>?action=articles&type=admin&method=edit&id=<?=$post->id()?>" class="button hollow primary">Modification</a>
                            <a href="<?php echo BASE_URL;?>?action=articles&type=admin&method=delete&id=<?=$post->id()?>" onclick="return confirm('Voulez-vous vraiment supprimer cet article ? ');" class="button hollow alert">Suppression</a>
                            <a href="<?php echo BASE_URL;?>?action=article&name=<?=$post->name()?>" target="_blank" class="button hollow">Prévisualisation</a>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>

    <?php else:?>

        <input type="hidden" name="id" value="<?=isset($this->data['posts']) ? $this->data['posts']->id() : '';?>"/>
        <div class="callout primary">
            <ul>
                <li class="no-bullet float-right"><button value="<?=isset($this->data['method']) ? $this->data['method'] : 'edit';?>" name="method" class="button hollow success">Sauvegarde</button></li>
                <li class="no-bullet float-right"><a href="<?php echo BASE_URL;?>?action=articles&type=admin" class="button hollow primary">Return</a></li>
                <div style="clear: both;"></div>
            </ul>
        </div>

        <?php if(count($response)):?>
            <?php foreach($response['message'] as $message):?>
                <div class="callout <?=$response['error'] ? 'warning form-error is-visible' : 'success';?>">
                    <?=$message?>
                </div>
            <?php endforeach;?>
        <?php endif;?>

        <div class="callout primary">
            <div class="columns">
                <label for="post_title" class="small-1 columns middle"><strong>Titre</strong></label>
                <div class="small-9 columns float-left">
                    <input type="text" id="post_title" name="post_title" value="<?=isset($this->data['posts']) ? $this->data['posts']->title() : '';?>" placeholder="Veuillez saisir le titre d'article"/>
                </div>
            </div>

            <div class="columns">
                <label for="post_name" class="small-1 columns middle"><strong>Nom</strong></label>
                <div class="small-9 columns float-left">
                    <input type="text" id="post_name" name="post_name" value="<?=isset($this->data['posts']) ? $this->data['posts']->name() : '';?>" placeholder="Veuillez saisir le nom d'article"/>
                </div>
            </div>

            <div class="columns">
                <label for="image" class="small-1 columns middle"><strong>Image</strong></label>
                <div class="small-9 columns float-left">
                    <?php if (isset($this->data['posts']) && $this->data['posts']) :?>
                        <img class="thumbnail" src="<?=$this->data['posts']->media();?>" style="max-width: 50%;">
                    <?php endif;?>
                    <input type="file" id="image" name="image" placeholder="Veuillez sélectionner une image"/>
                </div>
            </div>

            <div class="columns">
                <label for="post_status" class="small-1 columns middle"><strong>Status</strong></label>
                <div class="small-9 columns float-left">
                    <select id="post_status" name="post_status">
                        <option value="publish" <?= isset($this->data['posts']) && 'publish' == $this->data['posts']->status() ? 'selected':''?>>publish</option>
                        <!--  <option value="private" //=isset($this->data['posts']) && 'private' == $this->data['posts']->status() ? 'selected':''private</option>-->
                        <!--  <option value="brouillon" //=isset($this->data['posts']) && 'brouillon' == $this->data['posts']->status() ? 'selected':''brouillon</option>-->
                    </select>
                </div>
            </div>

            <div class="columns">
                <label for="post_status" class="small-1 columns middle"><strong>Catégorie</strong></label>
                <div class="small-9 columns float-left">
                    <select id="post_status" name="post_category">
                        <option value="news" <?=isset($this->data['posts']) && 'news' == $this->data['posts']->category() ? 'selected':''?>>news</option>
                        <option value="blog" <?=isset($this->data['posts']) && 'blog' == $this->data['posts']->category() ? 'selected':''?>>blog</option>
                    </select>
                </div>
            </div>

            <div class="columns">
                <label for="post_content" class="small-1 columns middle"><strong>Content</strong></label>
                <div class="small-9 columns float-left">
                    <textarea id="post_content" style="min-height:250px;" name="post_content" placeholder="Veuillez saisir le content d'article"><?=isset($this->data['posts']) ? $this->data['posts']->content() : '';?></textarea>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>

    <?php endif;?>
    </form>
</div>