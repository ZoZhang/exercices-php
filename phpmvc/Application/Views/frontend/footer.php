<?php
$response = [];
if (isset($this->data['newslettre_response'])) {
    $response = $this->data['newslettre_response'];
} else if(isset($_GET['newslettre_error']) && isset($_GET['newslettre_message'])){
    $response = [
        'newslettre_error' => $_GET['newslettre_error'],
        'newslettre_message' => $_GET['newslettre_message']
    ];
}
?>
<div class="callout primary">
    <div class="row column text-center">
        <h2 class="subheader">Ici un formulaire pour s'enregistrer à la newsletter ce serait sympa</h2>
        <form method="post" action="<?php echo BASE_URL; ?>?action=newsletter">

            <?php if(count($response)):?>
                <?php foreach($response['newslettre_message'] as $message):?>
                    <div class="callout <?=$response['newslettre_error'] ? 'warning form-error is-visible' : 'success';?>">
                        <?=$message?>
                    </div>
                <?php endforeach;?>
            <?php endif;?>

            <div class="input-group">
                <input class="input-group-field" type="email" name="email" placeholder="Veuillez saisir votre adresse e-mail."/>
                <div class="input-group-button">
                    <input type="submit" class="button" value="Inscription">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="callout">
    <div class="row column text-center">
        <h3>Custom Footer Page Content</h3>
    </div>
</div>