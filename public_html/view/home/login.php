<?php

use app\core\entity\Form;
use app\core\entity\Message;

$params['nav_item_active'] = "Connexion";

include_once("header.php");

function getMsg() : string {
    if(isset($_GET['msg_id'])) {
        if(Message::SUCCESS_MSG->value != $_GET['msg_id']) {
            return Message::getMessage(Message::get($_GET['msg_id']));
        }
    }
    return "";
}


(new Form)->add('<section class="vh-100 gradient-custom">')
->add('<div class="container py-5 h-100">')
->add('<div class="row justify-content-center align-items-center h-100">')
->add('<div class="col-12 col-lg-9 col-xl-7">')
->add('<div class="card shadow-2-strong card-registration" style="border-radius: 15px;">')
->add('<div class="card-body p-4 p-md-5">')
->add('<h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Formulaire de connexion</h3>')
->add('<form id="loginForm" action="request_login" method="post">')
->add('<div class="row">')
->add('<div class="mb-2 align-items-center">')
->add('<span class="error-msg align-items-center" id="details">')
->add(getMsg())
->add('</span>')
->add('</div>')
->add('</div>')
->add('<div class="row">')
->add('<div class="mb-4">')
->add('<div data-mdb-input-init class="form-outline">')
->add('<input class="form-control form-control-lg" type="text" id="user_name" name="user_name" />')
->add('<label class="form-label" for="user_name">Identifiant</label>')
->add('</div>')
->add('</div>')
->add('</div>')
->add('<div class="row">')
->add('<div class="mb-4">')
->add('<div data-mdb-input-init class="form-outline">')
->add('<input class="form-control form-control-lg" type="password" id="pwd" name="pwd" />')
->add('<label class="form-label" for="pwd">Mot de passe</label>')
->add('</div>')
->add('</div>')
->add('</div>')
->add('<div class="mb-2">')
->add('<input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit" value="Se connecter" />')
->add('</div>')
->add('<div class="row">')
->add('<div class="mb-4">')
->add('<div data-mdb-input-init class="form-outline">')
->add('<span>Pas de compte ? Demandez une <a href="signup">inscription</a> sur le portail de ' . APP_NAME . '!</span>')
->add('</div>')
->add('</div>')
->add('</div>')
->add('</form>')
->add('</div>')
->add('</div>')
->add('</div>')
->add('</div>')
->add('</div>')
->add('</section>')
->add('<script>')
->add('let user_name = document.getElementById("user_name");')
->add('let pwd = document.getElementById("pwd");')
->add('let details = document.getElementById("details");')
->add('const form = document.getElementById("loginForm");')
->add('form.addEventListener("submit", (e) => {')
->add('e.preventDefault();')
->add('details.innerHTML = "";')
->add('if (checkLength(user_name, 3, "L\'identifiant doit contenir au moins trois (3) caractères.", details)) {')
->add('if (checkLength(pwd, 7, "Le mot de passe doit contenir au moins sept (7) caractères.", details)) {')
->add('const formData = new FormData(form);')
->add('sendForm(formData, "request_login", details);')
->add('}}});')
->add('</script>')
->show();

include_once("footer.php");