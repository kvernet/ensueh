<?php

use app\core\entity\Footer;
use app\core\entity\Header;

$params['nav_item_active'] = "Bienvenue";

(new Header)->setTitle($params["title"] ?? APP_NAME)->show();
?>

<div class="container">
    <div class="jumbotron">
        <p class="display-6">Votre inscription sur le portail de l'<?= APP_FULL_NAME ?> a été enregistrée avec succès.</p>
        <p class="lead red">Vous pouvez dorénavant accéder au portail avec vos identifiants de connexion sur le lien <a href="../home/login" target="_blank"><?= APP_DOMAIN . 'home/login' ?></a> et profiter pleinement des services disponibles.</p>
        <hr>
        <p class="lead display-10 blue">Nous vous souhaitons déjà bonne utilisation !!!</p>
    </div>
</div>


<?php
(new Footer)->show();
?>