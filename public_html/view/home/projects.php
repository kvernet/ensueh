<?php

$params['nav_item_active'] = "Recherche";

include_once("header.php");

function addProject(string $title, string $funding, string $parterships, string $status="En cours") {
    echo '<span class="lead"><b>Titre</b>: </span><b>' . $title . '</b>'
    . '<br><span class="lead"><b>Financement</b>: </span><b>' . $funding . '</b>'
    . '<br><span class="lead"><b>Partenariat</b>: </span><b>' . $parterships . '</b>'
    . '<br><span class="lead"><b>Statut</b>: </span><b>' . $status . '</b>'
    . '<hr class="lead">';
}
?>

<div class="jumbotron">
    <h2 class="display-5">Nos projets</h2>
    <div id="projects">
        <?php
        addProject(
            "Caractérisation de la pollution atmosphérique dans la ville de Port-au-Prince",
            "BRH",
            "Université des Antilles"
        );

        addProject(
            "Formation de 500 jeunes Haïtiens dans les 10 départements de pays en dimensionnement, installation, maintenance, sécurité et récyclage des systèmes photovoltaïques",
            "Banque mondiale à travers MTPTC",
            "Université d'Orléans, Paris Saclay, Université de Liège"
        );

        addProject(
            "Développement d'un labo en énergie verte",
            "ARES",
            "Université d'Orléans, Paris Saclay, Université de Liège"
        );
        ?>
    </div>
</div>

<?php
include_once("footer.php");
?>