<?php

$params['nav_item_active'] = "Présentation";

include_once("header.php");
?>

<div class="jumbotron">
    <h2 class="display-5">Présentation de l'<?= APP_FULL_NAME ?></h2>
</div>

<hr class="my-4">

<div class="lead text-justify">
    <p>L'Ecole Normale Supérieure (ENS) est une entité de l'Université d'Etat d'Haïti qui a pour vocation de former des universitaires de haut niveau, des enseignants, des chercheurs et des professeurs destinés à l’enseignement secondaire.
        Elle offre des formations de premier et de deuxième cycles dans différents domaines. Elle comprend actuellement les sept (7) <a href='<?= APP_DOMAIN . "home/departments" ?>'>départements</a> qui suivent: Lettres modernes, Philosophie, Sciences Sociales, Langues vivantes, Mathématiques, Physique, Sciences Naturelles.
        Les formations de deuxième cycle sont offertes en partenariat avec des Universités étrangères comme Paris8, l'Université des Antilles, l'Université de Poitiers, l'Université de Lyon, l'Université d'Orléans, l'Université de Liège ou l'Université de Montréal, etc.
    </p>
    <p>
        L'Ecole Normale Supérieure, inaugurée le 31 octobre 1947, a été créée par la Loi du 28 Juillet 1947 en vue de la formation et du recrutement des professeurs de l'enseignement secondaire et de l'enseignement supérieur des Lettres et des Sciences.
        Par la loi du 23 janvier 1969, elle était devenue Faculté des Lettres et de Pédagogie qui avait pour but de dispenser un enseignement théorique et pratique. Le 9 octobre 1973, la Faculté des Lettres est redevenue Ecole Normale Supérieure jusqu'aujourd'hui.
    </p>
    <p>
        L'ENS a pour mission de:
    <ul>
        <li> former des professeurs pour l'enseignement secondaire afin de résoudre le problème de carence de professeurs qualifiés rencontré dans les différentes écoles au niveau national ;
        <li> former des personnels qualifiés pour aborder les problèmes socio-politiques et économiques d'Haïti ;
        <li> former des cadres pour l'enseignement supérieur et la recherche afin de proposer des solutions aux problèmes environnementaux et énergétiques que confronte le monde actuel.
    </ul>
    </p>
</div>
<hr class="my-4">

<?php
include_once("footer.php");
?>