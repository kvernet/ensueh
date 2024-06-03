<?php

use app\core\model\SingleModel;

$params['nav_item_active'] = "Accueil";

include_once("header.php");
function getCard(
    string $imgPath,
    string $title,
    string $content,
    string $page = ""
): string {
    return '<div class="col">'
        . '<div class="card h-100">'
        //. '<img src="' . $imgPath . '" class="card-img-top" alt="...">'
        . '<div class="card-body">'
        . '<h5 class="display-6">' . $title . '</h5>'
        . '<p class="lead">' . $content . '</p>'
        . '<a class="" href="' . APP_DOMAIN . 'home/' . $page . '">Voir plus...</a>'
        . '</div>'
        . '</div>'
        . '</div>';
}

function getForumLists() : string {
    $result = '';
    $data = (new SingleModel)->setTable("forum_terms")->getAll();
    $size = count($data);

    if($size <= 0) return "";

    $result .= $data[0]->getContent();

    for($i=1; $i < $size; $i++) {
        $result .= ', ' . $data[$i]->getContent();
    }
    return $result;
}
?>

<div class="pt-1 align-items-center">
    <div class="row">
        <div class="col-lg-5">
            <div class="jumbotron">
                <h1 class="display-4"><?=APP_FULL_NAME?></h1>
                <p class="lead display-6"><?=APP_SLOGAN?></p>
                <p>Etes-vous étudiant, professeur de l'<?=APP_FULL_NAME?>? Connectez-vous ou faites une demande d'accès au portail !</p>
                <p class="lead">
                    <a class="btn btn-primary" href="<?=APP_DOMAIN?>home/login" role="button">Se connecter au portail</a>
                </p>
            </div>
        </div>
        <div class="col-lg-7">
            <?php include_once("carousel.php"); ?>
        </div>
    </div>
</div>


<div class="lead text-justify">
    <p>L'Ecole Normale Supérieure (ENS) est une entité de l'Université d'Etat d'Haïti qui a pour vocation de former des universitaires de haut niveau, des enseignants, des chercheurs et des professeurs destinés à l'enseignement secondaire.
        Elle offre des formations de premier et de deuxième cycles dans différents domaines. Elle comprend actuellement les sept (7) départements qui suivent: Lettres modernes, Philosophie, Sciences Sociales, Langues vivantes, Mathématiques, Physique, Sciences Naturelles.
        Les formations de deuxième cycle sont offertes en partenariat avec des Universités étrangères comme Paris8, l'Université des Antilles, l'Université de Poitiers, l'Université de Lyon, l'Université d'Orléans, l'Université de Liège ou l'Université de Montréal, etc.
        <a class="" href="<?=APP_DOMAIN?>home/presentation">Voir plus...</a>
    </p>
</div>
<hr class="my-4">


<?php
echo '<div class="dashboard-content px-3 pt-4 text-justify">'
    . '<div class="row row-cols-1 row-cols-md-3 g-4">'
    . getCard(
        "../../uploads/features/admission.webp",
        "Formation",
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque et est tenetur. Hic illo repudiandae cupiditate voluptatibus sed! Quibusdam omnis odio dolores modi veritatis quasi labore magnam animi, quaerat numquam. Doloremque molestiae rem esse, voluptatibus ut officiis facere, consectetur repellat...",
        "formations"
    )
    . getCard(
        "../../uploads/features/admission.webp",
        "Admission",
        "Les étudiants sont recrutés par un concours, qui a lieu chaque année, en principe, à la rentrée de septembre. La durée des formations du premier cycle est de quatre (4) ans. La première année est l'année préparatoire: elle sert de transition entre l'enseignement secondaire et l'enseignement supérieur.",
        "admission"
    )
    . getCard(
        "../../uploads/features/admission.webp",
        "Orientation",
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque et est tenetur. Hic illo repudiandae cupiditate voluptatibus sed! Quibusdam omnis odio dolores modi veritatis quasi labore magnam animi, quaerat numquam. Doloremque molestiae rem esse, voluptatibus ut officiis facere, consectetur repellat...",
        "coaching"
    )
    . getCard(
        "../../uploads/features/admission.webp",
        "Stages & emplois",
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque et est tenetur. Hic illo repudiandae cupiditate voluptatibus sed! Quibusdam omnis odio dolores modi veritatis quasi labore magnam animi, quaerat numquam. Doloremque molestiae rem esse, voluptatibus ut officiis facere, consectetur repellat...",
        "jobs"
    )
    . getCard(
        "../../uploads/features/admission.webp",
        "Partenariats",
        "La coopération internationale est un facteur clé dans le processus de développement de toute université. L'Ecole Normale Supérieure de l'Université d'Etat d'Haïti (ENS) collabore au niveau académique avec plusieurs universités européennes et nord-américaines qui nous envoient des enseignants.es et reçoivent comme boursiers.ères ...",
        "partnerships"
    )
    . getCard(
        "../../uploads/features/admission.webp",
        "Forums",
        "Le forum de l'ENS est l'endroit idéal pour partager ses opinions et échanger avec d'autres personnes sur différents sujets. Sur ce forum, vous pouvez trouver des sujets sur les termes suivants : " . getForumLists(),
        "forums"
    )
    . '</div></div>'
    . '<hr class="my-4">';

include_once("footer.php");
