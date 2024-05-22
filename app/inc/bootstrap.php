<?php

declare(strict_types=1);

use app\core\entity\Message;

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

//
function uploadFile(array $file_data, string $file_name) : Message {
    if(count($file_data) < 1) return Message::FILE_UPLOAD_FAILED;
    if($file_data['error'] != 0) return Message::FILE_UPLOAD_FAILED;

    $MB = 1000**2;
    $sizeMB = $file_data['size'] / $MB;
    
    if($sizeMB > MAX_UPLOAD_FILE_SIZE) {
        return Message::FILE_UPLOAD_TOO_BIG;
    }

    $to = PUBLIC_DIR . "uploads/courses/pdf/" . $file_name;
    if(move_uploaded_file($file_data['tmp_name'], $to)) {
        return Message::SUCCESS_MSG;
    }
    return Message::FILE_UPLOAD_FAILED;
}

function getUploadedFilePath(string $file_name) : string {
    return APP_DOMAIN . "uploads/courses/pdf/" . $file_name;
}