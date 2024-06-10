<?php

use app\core\entity\Footer;
use app\core\entity\Form;
use app\core\entity\Header;
use app\core\entity\Message;
use app\core\entity\WhoAmI;
use app\core\model\SingleModel;

$params['nav_item_active'] = "Inscription";

(new Header)->setTitle($params["title"] ?? APP_NAME)->show();

function getMsg(): string {
    if (isset($_GET['msg_id'])) {
        if (Message::SUCCESS_MSG->value != $_GET['msg_id']) {
            return Message::getMessage(Message::get($_GET['msg_id']));
        } else {
            return "Votre demande d'inscription a été envoyée aves succès.<br>";
        }
    }
    return "";
}

$singleModel = new SingleModel;

(new Form)->add('<section class="vh-100 gradient-custom">')
    ->add('<div class="container py-5 h-100">')
    ->add('<div class="row justify-content-center align-items-center h-100">')
    ->add('<div class="col-12 col-lg-9 col-xl-7">')
    ->add('<div class="card shadow-2-strong card-registration" style="border-radius: 15px;">')
    ->add('<div class="card-body p-4 p-md-5">')
    ->add('<h3 class="mb-2 pb-2 pb-md-0 mb-md-3">Formulaire d\'inscription sur le portail de ' . APP_NAME . '</h3>')
    ->add('<form id="signupForm" action="request_signup" method="post">')
    ->add('<div class="row">')
    ->add('<div class="mb-2 text-center">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<span>Déjà inscrit ? <a href="../home/login" target="_blank">Se connecter</a> sur le portail de ' . APP_NAME . ' !</span>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="row">')
    ->add('<div class="mb-2 align-items-center">')
    ->add('<span class="error-msg align-items-center" id="details">')
    ->add(getMsg())
    ->add('</span>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="row">')
    ->add('<div class="col-md-6 mb-4">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<input class="form-control form-control-lg" type="text" id="first_name" name="first_name" />')
    ->add('<label class="form-label" for="first_name">Prénom</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="col-md-6 mb-4">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<input class="form-control form-control-lg" type="text" id="last_name" name="last_name" />')
    ->add('<label class="form-label" for="last_name">Nom</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="row">')
    ->add('<div class="col-md-6 mb-4">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<select class="select form-control form-control-lg" id="gender" name="gender">')
    ->add($singleModel->setTable("genders")->getAllAsOptions())
    ->add('</select>')
    ->add('<label class="form-label" for="gender">Sexe</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="col-md-6 mb-4">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<select class="select form-control form-control-lg" id="department" name="department">')
    ->add($singleModel->setTable("departments")->getAllAsOptions())
    ->add('</select>')
    ->add('<label class="form-label" for="department">Département</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="row">')
    ->add('<div class="col-md-6 mb-4 pb-2">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<input class="form-control form-control-lg" type="email" id="email" name="email" />')
    ->add('<label class="form-label" for="email">Email</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="col-md-6 mb-4 pb-2">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<input class="form-control form-control-lg" type="tel" id="phone" name="phone" />')
    ->add('<label class="form-label" for="phone">Téléphone</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="row">')
    ->add('<div class="col-md-6 mb-4">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<select class="select form-control form-control-lg" id="whoami" name="whoami">')
    ->add($singleModel->setTable("whoami")->getAllAsOptions(
        1,
        [WhoAmI::ADM->value]
    ))
    ->add('</select>')
    ->add('<label class="form-label" for="whoami">Statut</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="col-md-6 mb-4">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<select class="select form-control form-control-lg" id="section" name="section">')
    ->add($singleModel->setTable("sections")->getAllAsOptions())
    ->add('</select>')
    ->add('<label class="form-label" for="section">Section</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="col-md-6 mb-4">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<select class="select form-control form-control-lg" id="grade" name="grade">')
    ->add($singleModel->setTable("grades")->getAllAsOptions())
    ->add('</select>')
    ->add('<label class="form-label" for="grade">Niveau d\'étude</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="row">')
    ->add('<div class="mb-4 pb-2">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<input class="form-control form-control-lg" type="text" id="user_name" name="user_name" />')
    ->add('<label class="form-label" for="user_name">Identifiant</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="row">')
    ->add('<div class="col-md-6 mb-4 pb-2">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<input class="form-control form-control-lg" type="password" id="pwd" name="pwd" />')
    ->add('<label class="form-label" for="pwd">Mot de passe</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('<div class="col-md-6 mb-2 pb-2">')
    ->add('<div data-mdb-input-init class="form-outline">')
    ->add('<input class="form-control form-control-lg" type="password" id="conf_pwd" name="conf_pwd" />')
    ->add('<label class="form-label" for="conf_pwd">Confirmer mot de passe</label>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')

    ->add('<div class="">')
    ->add('En cliquant sur <b>S\'inscrire sur le portail</b>, vous acceptez nos <a href="../home/terms" target="_blank">conditions</a>.')
    ->add('</div>')

    ->add('<div class="mt-1 pt-2">')
    ->add('<input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit" value="S\'inscrire sur le portail" />')
    ->add('</div>')

    ->add('</form>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')
    ->add('</div>')
    ->add('</section>')
    ->show();
?>

<script>
    let first_name = document.getElementById("first_name");
    let last_name = document.getElementById("last_name");
    let gender = document.getElementById("gender");
    let department = document.getElementById("department");
    let email = document.getElementById("email");
    let phone = document.getElementById("phone");
    let whoami = document.getElementById("whoami");
    let section = document.getElementById("section");
    let grade = document.getElementById("grade");
    let user_name = document.getElementById("user_name");
    let pwd = document.getElementById("pwd");
    let conf_pwd = document.getElementById("conf_pwd");
    let details = document.getElementById("details");

    const form = document.getElementById("signupForm");
    form.addEventListener("submit", (e) => {
        e.preventDefault();
        details.innerHTML = "";

        if(checkLength(first_name, 2, "Le prénom doit contenir au moins deux (2) caractères.", details)) {
            if(checkLength(last_name, 2, "Le nom doit contenir au moins deux (2) caractères.", details)) {
                if(emailValid(email.value)) {
                    if(phoneNumberValid(phone.value)) {
                        if(checkLength(user_name, 5, "L'identifiant doit contenir au moins cing  (5) caractères.", details)) {
                            if(passwordValid(pwd.value)) {
                                if(pwd.value == conf_pwd.value) {
                                    const formData = new FormData(form);
                                    sendForm(formData, "request_signup", details);
                                }
                                else {
                                    details.textContent = "Les mots de passe ne se correspondent pas.";
                                }
                            }
                            else {
                                details.innerHTML = "Le mot de passe n'est pas correct. Il doit contenir :" +
                                    "<ul>" +
                                    "<li>au moins huit (8) caractères</li>" +
                                    "<li>au moins une lettre majuscule</li>" +
                                    "<li>au moins une lettre minuscule</li>" +
                                    "<li>au moins un chiffre</li>" +
                                    "<li>au moins un caractères spécial : (e.g., @, $, !, %, *, ?, &)</li>" +
                                    "</ul>";
                            }
                        }
                    }
                    else {
                        details.textContent = "Le numéro de téléphone est incorrecte.";
                    }
                }
                else {
                    details.textContent = "L'email " + email.value + " est incorrecte.";
                }
            }
        }
    });
</script>

<?php
(new Footer)->show();
?>