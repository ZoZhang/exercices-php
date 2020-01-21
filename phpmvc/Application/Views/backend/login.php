<?php
$infos = isset($this->data['infos']) ? $this->data['infos']: [];
$response = isset($this->data['response']) ? $this->data['response']: [];
?>

<div class="callout primary" style="max-width:50%;margin:10% auto;">
    <div class="row column text-center">
        <form method="post" action="<?php echo BASE_URL; ?>?action=login&type=admin">

            <?php if(count($response)):?>
                <?php foreach($response['message'] as $message):?>
                    <div class="callout <?=$response['error'] ? 'warning form-error is-visible' : 'success';?>">
                        <?=$message?>
                    </div>
                <?php endforeach;?>
            <?php endif;?>

            <div class="columns">
                <div class="small-3 columns">
                    <label for="username" class="text-right middle"><strong>Username</strong></label>
                </div>
                <div class="small-9 columns">
                    <input type="text" id="username" name="username" value="<?=isset($infos['username']) ? $infos['username'] : ''?>" placeholder="Veuillez saisir votre username">
                </div>
            </div>

            <div class="columns">
                <div class="small-3 columns">
                    <label for="password" class="text-right middle"><strong>Mot de passe</strong></label>
                </div>
                <div class="small-9 columns">
                    <input type="password" id="password" name="password" value="<?=isset($infos['password']) ? $infos['password'] : ''?>" placeholder="Veuillez saisir votre mot de passe">
                </div>
            </div>

            <div class="input-group-button">
                <input type="submit" class="button" value="Identifie">
            </div>
        </form>
    </div>
</div>

