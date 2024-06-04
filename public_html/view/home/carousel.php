<?php
function getCarouselItem(string $imgPath, string $title, string $content, string $link = "", string $linkText = "Voir plus..."): string {
    return '<div class="carousel-item active">'
        . '<img src="' . $imgPath . '" class="d-block w-100" alt="...">'
        . '<div class="carousel-caption d-sm-block">'
        . '<h5 class="blue">' . $title . '</h5>'
        . '<p class="red">' . $content . '</p>'
        . '<a class="btn btn-primary" href="' . $link . '">' . $linkText . '</a>'
        . '</div>'
        . '</div>';
}
?>


<div id="carousel-news" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carousel-news" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carousel-news" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carousel-news" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <?php echo getCarouselItem("../../uploads/news/local_pacot.jpeg", "Bourses Eiffel", "Bourses Eiffel.", APP_DOMAIN . "home/news?id=1"); ?>
        <?php echo getCarouselItem("../../uploads/news/local_pacot.jpeg", "Installation d'une centrale d'eau", "Installation d'une centrale d'eau traitée par osmose inverse.", APP_DOMAIN . "home/news?id=2"); ?>
        <?php echo getCarouselItem("../../uploads/news/local_pacot.jpeg", "Deux systèmes Starlink installés à l'ENS", "Deux systèmes Starlink installés à l'ENS afin d'améliorer la connectivité de l'administration.", APP_DOMAIN . "home/news?id=3"); ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-news" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carousel-news" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
    </button>
</div>