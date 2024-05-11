<?php

declare(strict_types = 1);

require_once("config.php");

// redirect to a page
function redirectMe(string $page) : void {
    header("Location: " . $page);
    exit(0);
}

// check if inactivity duration is higher than given parameter $duration
function isOffline(int $duration) : bool {
    return ACTIVE_DURATION < $duration;
}

// pretiffy display
function pretiffy($ar) : void {
    echo "<pre>";
    print_r($ar);
    echo "</pre>";
}