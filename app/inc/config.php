<?php

declare(strict_types=1);

define("APP_DIR", __DIR__ . "/../../");
define("PUBLIC_DIR", APP_DIR . "public_html/");
define("APP_DOMAIN", "http://127.0.0.1:8080/");

/* Boostrap links */
define("BOOTSTRAP_CSS", '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">');
define("BOOSTRAP_JS", '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>');

define("APP_NAME", "ENS UEH");
define("ACTIVE_DURATION", 3000);  // in seconds
define("ONLINE_DURATION", 60);  // in seconds and must be less than ACTIVE_DURATION


define("DB_HOST", "127.0.0.1");
define("DB_NAME", "ens_db_2024");
define("DB_USER", "ens");
define("DB_PWD", "Test_xyz1");