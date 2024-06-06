<?php

$params['nav_item_active'] = "Bienvenue";

include_once("header.php");
?>

<div class="jumbotron">
    <p class="display-6">Votre inscription sur le portail de l'<?=APP_FULL_NAME?> a été enregistrée avec succès.</p>
    <p class="lead red">Vous pouvez dorénavant accéder au portail avec vos identifiants de connexion sur le lien <a href="../home/login" target="_blank"><?=APP_DOMAIN . 'home/login'?></a> et profiter pleinement des services disponibles.</p>
    <hr>
    <p class="lead display-10 blue">Nous vous souhaitons déjà bonne utilisation !!!</p>
</div>

<?php
include_once("footer.php");
?>