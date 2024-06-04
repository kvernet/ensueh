<?php

declare(strict_types=1);

use app\core\entity\Message;

require_once("config.php");

function getUserIP() : string {
    // Check for shared internet/ISP IP address
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    // Check for proxy user
    elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    // Check for remote address
    else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

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
        setcookie($key, '', time() - 86400 * COOKIE_DURATION, "/");
    }
}

// pretiffy display
function pretiffy($ar) : void {
    echo "<pre>";
    print_r($ar);
    echo "</pre>";
}

// move file to uploads folder
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

// get file from uploads folder
function getUploadedFilePath(string $file_name) : string {
    return APP_DOMAIN . "uploads/courses/pdf/" . $file_name;
}

// move file to uploads folder
function uploadProfilePhoto(array $file_data, string $file_name) : Message {
    $max_file_size = 10; // in MB

    if(count($file_data) < 1) return Message::FILE_UPLOAD_FAILED;
    if($file_data['error'] != 0) return Message::FILE_UPLOAD_FAILED;

    $MB = 1000**2;
    $sizeMB = $file_data['size'] / $MB;
    
    if($sizeMB > $max_file_size) {
        return Message::FILE_UPLOAD_TOO_BIG;
    }

    $to = PUBLIC_DIR . "img/researchers/profiles/" . $file_name;
    if(move_uploaded_file($file_data['tmp_name'], $to)) {
        return Message::SUCCESS_MSG;
    }
    return Message::FILE_UPLOAD_FAILED;
}