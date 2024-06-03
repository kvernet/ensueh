<?php

$params['nav_item_active'] = "Recherche";

include_once("header.php");

function addActu(string $title) {
    echo '<span class="lead"><b>Titre</b>: </span><b>' . $title . '</b>'
    . '<hr class="lead">';
}
?>

<div class="jumbotron">
    <h2 class="display-5">Actualités locales</h2>
    <div id="projects">
        <?php
        addActu(
            "Installation d'une centrale d'eau traitée par osmose inverse"
        );

        addActu(
            "Distribution de tablettes aux professeurs de l'ENS"
        );

        addActu(
            "Deux systèmes Starlink installés à l'ENS afin d'améliorer la connectivité de l'administration"
        );
        ?>
    </div>
</div>

<?php
include_once("footer.php");
?>