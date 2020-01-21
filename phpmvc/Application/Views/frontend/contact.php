<?php
$infos = isset($this->data['contact_info']) ? $this->data['contact_info']: [];
$response = isset($this->data['contact_response']) ? $this->data['contact_response']: [];
?>

<div class="callout primary">
    <div class="row column text-center">
        <form method="post" action="<?php echo BASE_URL; ?>?action=contact">

            <?php if(count($response)):?>
                <?php foreach($response['message'] as $message):?>
                    <div class="callout <?=$response['error'] ? 'warning form-error is-visible' : 'success';?>">
                        <?=$message?>
                    </div>
                <?php endforeach;?>
            <?php endif;?>

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
                    <label for="message" class="text-right middle"><strong>Message</strong></label>
                </div>
                <div class="small-9 columns">
                    <textarea id="message" style="min-height: 150px" name="message"><?=isset($infos['message']) ? $infos['message'] : ''?></textarea>
                </div>
            </div>

            <div class="input-group-button">
                <input type="submit" class="button" value="Envoie">
            </div>
        </form>
    </div>
</div>
