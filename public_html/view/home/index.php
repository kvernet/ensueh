<?php
include_once("header.php");
?>

<div class="container-fluid ">

    <div class="row bord-t bord-b">

        <div class="col-lg-2 col-md-1 ">
            <div class="row">
                <p class="lead display-6 fw-bolder text-center mt-5 pt-5">Bienvenue !</p>
            </div>
            <div class="d-none d-lg-block ">
                <img class="img-fluid" src="../../img/ima10.jpeg" alt="oups">
            </div>        

        </div>

        <div class="col-lg-8 col-md-10">


            <div class="container pt-5 mt-5 ">
                <div id="coulisse" class="carousel slide " data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item ">
                            <img src="../../img/caroussel-acceuil/ima3.webp" alt="" class="d-block w-100 img-fluid">
                        </div>
                        <div class="carousel-item active">
                            <img src="../../img/caroussel-acceuil/ima2.jpg" alt="" class="d-block w-100 img-fluid">
                        </div>
                        <div class="carousel-item ">
                            <img src="../../img/caroussel-acceuil/ima9.webp" alt="" class="d-block w-100 img-fluid">
                        </div>

                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#coulisse" data-bs-slide="prev"> 
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#coulisse" data-bs-slide="next" > 
                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>

            </div>

        </div>
        <div class="col-lg-2 col-md-1">

        </div>
    </div>

    <div class="row">


            <div class="col-lg-10 col-md-9 dashboard-content px-3 pt-4 border-5  coul-gris-pale5 ">

                <div class="jumbotron coul-gris-pale5">
                    <h2 class="display-6 text-center fw-bolder ">Présentation de l'Ecole Normale Supérieure</h2>
                    <p class="lead ">L'Ecole Normale Supérieure (ENS) est une entité de l'Université d'Etat d'Haïti qui a
                        pour vocation de former des universitaires de haut niveau, des enseignants, des chercheurs et
                        des professeurs destinés à l’enseignement secondaire.
                        Elle offre des formations de premier et de deuxième cycles dans différents domaines. Elle
                        comprend actuellement les sept (7) <a href='<?=APP_DOMAIN . "home/departments"?>'>départements</a> qui suivent:
                        </p>
                        
                        <div class="container p-3">

                        <div class="row border">
                            <div class="col-lg-5 col-md-5">
                                <img class="img-fluid " src="../../img/ima3.webp" alt="oups">
                            </div>
                            <div class="col-lg-4 col-md-4 border py-5 my-5">
                            <h3 class="text-center fw-bolder py-auto">Departements de l'ENS</h3>

                            </div>
                            <div class="col-lg-3 col-md-3 px-5 py-">
                                <ul class="lead">
                                    <li> Lettres modernes </li>
                                    <li> Philosophie </li>
                                    <li> Sciences sociales </li>
                                    <li>langues vivantes </li>
                                    <li> Mathématiques </li>
                                    <li> Physique </li>
                                    <li>Sciences naturelles </li>
                            </ul> 

                            </div>
                         

                        </div>


                        </div>

                        <p class="lead "> 
                        Les formations de deuxième cycle sont offertes en partenariat avec des Universités étrangères
                        comme Paris8, l'Université des Antilles, l'Université de Poitiers, l'Université de Lyon,
                        l'Université d'Orléans, l'Université de Liège ou l'Université de Montréal, etc.
                    </p>
                    <p class="lead ">
                        Les étudiants sont recrutés par un concours, qui a lieu chaque année, en principe, à la rentrée
                        de septembre. La durée des formations du premier cycle est de quatre (4) ans.
                        La première année est l'année préparatoire: elle sert de transition entre l'enseignement
                        secondaire et l'enseignement supérieur. La deuxième, troisième et quatrième années préparent aux
                        différents certificats d'Etudes Supérieures et au diplôme de fin d'études.
                        Ces documents confèrent aux anciens élèves de l'Ecole Normale Supérieure qui les détiennent, le
                        droit d'être nommés dans une chaire de leur spécialité, professeurs titulaires de l'enseignement
                        secondaire.
                        Ils permettent également aux étudiants de poursuivre leur formation en deuxième cycle dans les
                        domaines comme la Philosophie, la Littérature, les Mathématiques, la Physique, la Chimie et en
                        Français Langue Etrangère (FLE).

                        La durée de ces formations de deuxième cycle est de deux (2) ans. Les diplômes de deuxième cycle
                        délivrés permettent aux étudiants de continuer en doctorat ou d'intégrer facilement le marché du
                        travail.
                    </p>
                    <hr class="my-4">
                </div>
                <div class="jumbotron">
                    <h2 class="display-6 text-center fw-bolder ">Historicité de ENS</h2>
                    <p class="lead ">
                        L'Ecole Normale Supérieure, inaugurée le 31 octobre 1947, a été créée par la Loi du 28 Juillet
                        1947 en vue de la formation et du recrutement des professeurs de l'enseignement secondaire et de
                        l'enseignement supérieur des Lettres et des Sciences.
                        Par la loi du 23 janvier 1969, elle était devenue Faculté des Lettres et de Pédagogie qui avait
                        pour but de dispenser un enseignement théorique et pratique. Le 9 octobre 1973, la Faculté des
                        Lettres est redevenue Ecole Normale Supérieure jusqu'aujourd'hui.
                    </p>
                    <hr class="my-4">
                </div>

                <div class="jumbotron coul-gris-pale5">
                    <h2 class="display-6 text-center fw-bolder ">Vision de ENS</h2>
                    <p class="lead ">
                        L'ENS a pour vision de:
                    <ul class="lead ">
                        <li> former des professeurs pour l'enseignement secondaire afin de résoudre le problème de
                            carence de professeurs qualifiés rencontré dans les différentes écoles au niveau national ;
                        <li> former des personnels qualifiés pour aborder les problèmes socio-politiques et économiques
                            d'Haïti ;
                        <li> former des cadres pour l'enseignement supérieur et la recherche afin de proposer des
                            solutions aux problèmes environnementaux et énergétiques que confronte le monde actuel.
                    </ul>
                    </p>
                    <hr class="my-4">
                </div>
            </div>


        <div class="col-lg-2 col-md-3 border-left border-radius-3 px-2 py-2 d-none d-lg-block bg-dark">

            <table class="table table-striped table-dark text-center table-hover">
                <thead>
                    <tr>
                        <th class="display-6 table-success">Actualites</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                ex
                ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat
                nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                mollit
                anim id est laborum.
                        </td>
                    </tr>
                </tbody>
            </table>

            

                <hr class="my-4 text-light">

        </div>


    </div>

    <div class="row">

    </div>


</div>

<?php
include_once("footer.php");
?>