<?php

use app\core\entity\Footer;
use app\core\entity\Form;
use app\core\entity\Header;

$header = new Header(APP_NAME . " - ADM", [
    '<link rel="stylesheet" href="../../css/adm.login.css">'
]);
$header->show();

$form = new Form;
$form->add('<div class="form-container">')
    ->add('<form action="'. APP_DOMAIN .'adm/login" method="post">')
    ->add('<h1>Connexion - ADM</h1>')
    ->add('<table>')
    ->add('<tr>')
    ->add('<td><label for="user_name">Identifiant</label></td>')
    ->add('</tr>')
    ->add('<tr>')
    ->add('<td><input type="text" name="user_name"></td>')
    ->add('</tr>')

    ->add('<tr>')
    ->add('<td><label for="pwd">Mot de passe</label></td>')
    ->add('</tr>')
    ->add('<tr>')
    ->add('<td><input type="password" name="pwd"></td>')
    ->add('</tr>')

    ->add('<tr>')
    ->add('<td><input type="submit" value="Se connecter"></td>')
    ->add('</tr>')

    ->add('</table>')
    ->add("</form>")
    ->add("</div>")
    ->show();

$footer = new Footer;
$footer->show();