<?php
include_once("header.php");
function getCard(string $imgPath, string $title, string $content,
        string $page="") : string {
    return '<div class="col">'
    . '<div class="card h-100">'
    . '<img src="'. $imgPath .'" class="card-img-top" alt="...">'
    . '<div class="card-body">'
    . '<h5 class="display-6">'. $title .'</h5>'
    . '<p class="lead">'. $content .'</p>'
    . '<a class="btn btn-primary stretched-link" href="'.$page.'">Voir plus...</a>'
    . '</div>'
    . '</div>'
    . '</div>';
}

echo '<div class="dashboard-content px-3 pt-4 text-justify">'
. '<div class="row row-cols-1 row-cols-md-3 g-4">'
. getCard("../../img/ueh.jpg", "Présentation", "L'Ecole Normale Supérieure (ENS) est une entité de l'Université d'Etat d'Haïti qui a pour vocation de former des universitaires de haut niveau, des enseignants, des chercheurs et des professeurs destinés à l'enseignement secondaire. Elle offre des formations de premier et de deuxième cycles dans différents domaines.",
"ens_presention")
. getCard("../../img/ueh.jpg", "Admission", "Les étudiants sont recrutés par un concours, qui a lieu chaque année, en principe, à la rentrée de septembre. La durée des formations du premier cycle est de quatre (4) ans. La première année est l'année préparatoire: elle sert de transition entre l'enseignement secondaire et l'enseignement supérieur.",
"ens_admission")
. getCard("../../img/ueh.jpg", "Historicité", "L'Ecole Normale Supérieure, inaugurée le 31 octobre 1947, a été créée par la Loi du 28 Juillet 1947 en vue de la formation et du recrutement des professeurs de l'enseignement secondaire et de l'enseignement supérieur des Lettres et des Sciences. Par la loi du 23 janvier 1969, elle était devenue ...",
"ens_history")
. getCard("../../img/ueh.jpg", "Vision", "L'ENS a pour vision de former des professeurs pour l'enseignement secondaire afin de résoudre le problème de carence de professeurs qualifiés rencontré dans les différentes écoles au niveau national, de former des personnels qualifiés pour aborder les problèmes socio-politiques et économiques d'Haïti ...",
"ens_vision")
. '</div></div>'
. '<hr class="my-4">';

include_once("footer.php");