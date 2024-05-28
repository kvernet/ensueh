<?php
include_once("header.php");
?>

<div class="dashboard-content px-3 pt-4 text-justify">
<div class="jumbotron">
        <h2 class="display-6">Présentation de <?=APP_NAME?></h2>
        <p class="lead">L'Ecole Normale Supérieure (ENS) est une entité de l'Université d'Etat d'Haïti qui a pour vocation de former des universitaires de haut niveau, des enseignants, des chercheurs et des professeurs destinés à l’enseignement secondaire.
            Elle offre des formations de premier et de deuxième cycles dans différents domaines. Elle comprend actuellement les sept (7) <a href='<?= APP_DOMAIN . "home/departments" ?>'>départements</a> qui suivent: Lettres modernes, Philosophie, Sciences Sociales, Langues vivantes, Mathématiques, Physique, Sciences Naturelles.
            Les formations de deuxième cycle sont offertes en partenariat avec des Universités étrangères comme Paris8, l'Université des Antilles, l'Université de Poitiers, l'Université de Lyon, l'Université d'Orléans, l'Université de Liège ou l'Université de Montréal, etc.
        </p>
        <hr class="my-4">
    </div>
</div>

<?php
include_once("footer.php");
?>