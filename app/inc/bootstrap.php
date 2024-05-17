<?php

declare(strict_types=1);

require_once("config.php");

// redirect to a page
function redirectMe(string $page) : void {
    header("Location: " . $page);
    exit(0);
}

// remove & destroy all sessions
function deleteSessions() {
    // remove all session variables
    session_unset();
    // destroy the session
    session_destroy();
}

// delete all the cookies
function deleteCookies() {
    foreach($_COOKIE as $key => $value) {
        unset($value);
        setcookie($key, '', time() - 86400 * 365);
    }
}

// pretiffy display
function pretiffy($ar) : void {
    echo "<pre>";
    print_r($ar);
    echo "</pre>";
}