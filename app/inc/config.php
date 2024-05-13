<?php

define("APP_DIR", __DIR__ . "/../../");
define("PUBLIC_DIR", APP_DIR . "public_html/");
define("APP_DOMAIN", "http://127.0.0.1:8080/");

/* Boostrap links */
define("BOOTSTRAP_CSS", '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">');
define("BOOSTRAP_JS", '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>');

define("APP_NAME", "ENS UEH");
define("ACTIVE_DURATION", 3600);  // in seconds
define("ONLINE_DURATION", 300);  // in seconds and must be less than ACTIVE_DURATION


define("DB_HOST", "127.0.0.1");
define("DB_NAME", "ens_db_2024");
define("DB_USER", "ens");
define("DB_PWD", "Test_xyz1");

define("ACCESS_DENIED_MSG", "Désolé mais vous n'avez pas accès à la page démandée.");
define("PAGE_NOT_EXISTS_MSG", "La page que vous demandez n'existe pas.");

define("EMAIL_EXIST_MESSAGE", "Cet email a déjà été utilisé.");
define("PHONE_EXIST_MESSAGE", "Ce numéro de téléphone a déjà été utilisé.");
define("USERNAME_EXIST_MESSAGE", "Cet identifiant a déjà été utilisé.");


/* ADM messages */
define("ADM_STATUS_REQUESTED_MSG", "Votre compte n'est pas encore actif. Veuillez contacter les responsables.");
define("ADM_STATUS_CONNECTED_MSG", "Vous êtes déjà connecté(e) sur un autre appareil/navigateur. Veuillez d'abord vous déconnecter.");
define("ADM_STATUS_INACTIVE_MSG", "Vous êtes inatif(ve) trop lontemps. Veuillez d'abord vous reconnecter.");
define("ADM_STATUS_SUSPENDED_MSG", "Vous avez été suspendu(e). Veuillez contacter les responsables.");
define("ADM_NOT_EXISTS_MSG", "Vos informations (identifiant/mot de passe) n'existent pas dans le système.");