<?php
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
        . '<a class="btn btn-primary" href="' . APP_DOMAIN . 'home/' . $page . '">Voir plus...</a>'
        . '</div>'
        . '</div>'
        . '</div>';
}
?>

<div class="pt-1 align-items-center">
    <div class="row">
        <div class="col-lg-5">
            <div class="jumbotron">
                <h1 class="display-4"><?=APP_FULL_NAME?></h1>
                <p class="lead display-6"><?=APP_SLOGAN?></p>
                <p>Etes-vous étudiant, professeur ? Connectez-vous ou faites une demande d'accès au portail !</p>
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
        <a class="btn btn-primary" href="<?=APP_DOMAIN?>home/presentation">Voir plus...</a>
    </p>
</div>
<hr class="my-4">


<?php
echo '<div class="dashboard-content px-3 pt-4 text-justify">'
    . '<div class="row row-cols-1 row-cols-md-3 g-4">'
    . getCard(
        "../../img/ueh.jpg",
        "Formation",
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque et est tenetur. Hic illo repudiandae cupiditate voluptatibus sed! Quibusdam omnis odio dolores modi veritatis quasi labore magnam animi, quaerat numquam. Doloremque molestiae rem esse, voluptatibus ut officiis facere, consectetur repellat...",
        "formations"
    )
    . getCard(
        "../../img/ueh.jpg",
        "Admission",
        "Les étudiants sont recrutés par un concours, qui a lieu chaque année, en principe, à la rentrée de septembre. La durée des formations du premier cycle est de quatre (4) ans. La première année est l'année préparatoire: elle sert de transition entre l'enseignement secondaire et l'enseignement supérieur.",
        "admission"
    )
    . getCard(
        "../../img/ueh.jpg",
        "Orientation",
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque et est tenetur. Hic illo repudiandae cupiditate voluptatibus sed! Quibusdam omnis odio dolores modi veritatis quasi labore magnam animi, quaerat numquam. Doloremque molestiae rem esse, voluptatibus ut officiis facere, consectetur repellat...",
        "coaching"
    )
    . getCard(
        "../../img/ueh.jpg",
        "Stages & emplois",
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque et est tenetur. Hic illo repudiandae cupiditate voluptatibus sed! Quibusdam omnis odio dolores modi veritatis quasi labore magnam animi, quaerat numquam. Doloremque molestiae rem esse, voluptatibus ut officiis facere, consectetur repellat...",
        "jobs"
    )
    . getCard(
        "../../img/ueh.jpg",
        "Partenariats",
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque et est tenetur. Hic illo repudiandae cupiditate voluptatibus sed! Quibusdam omnis odio dolores modi veritatis quasi labore magnam animi, quaerat numquam. Doloremque molestiae rem esse, voluptatibus ut officiis facere, consectetur repellat...",
        "partnerships"
    )
    . getCard(
        "../../img/ueh.jpg",
        "Forums",
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque et est tenetur. Hic illo repudiandae cupiditate voluptatibus sed! Quibusdam omnis odio dolores modi veritatis quasi labore magnam animi, quaerat numquam. Doloremque molestiae rem esse, voluptatibus ut officiis facere, consectetur repellat...",
        "forums"
    )
    . '</div></div>'
    . '<hr class="my-4">';

include_once("footer.php");
