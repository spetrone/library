<?php
// Get the document root
$doc_root = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT', FILTER_SANITIZE_STRING);


// Get the application path
$uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_STRING);
$dirs = explode('/', $uri);
$app_path = '/' . $dirs[1] . '/' . $dirs[2] . '/';
$doc_main_dir = $doc_root . '/library/';
$home_path = "/library"; //default to A3, changed below

if (!isset($error_message)) {
    $error_message = '';
}

// Set the include path
set_include_path($doc_root . $app_path . PATH_SEPARATOR . $doc_main_dir );

// Get common code
require_once('tags.php');
require_once('model/database.php');

// Define some common functions
function display_db_error($error_message) {
    global $app_path;
    include 'errors/db_error.php';
    exit;
}

function display_error($error_message) {
    global $app_path;
    include 'errors/error.php';
    exit;
}

function redirect($url) {
    session_write_close();
    header("Location: " . $url);
    exit;
}

//shows home based on who is logged in (type of user)
function get_home_path() : string {
    if(isset($_SESSION['admin'])) {
        $home_path = "/library/admin";
    } else if (isset($_SESSION['reader'])) {
        $home_path = "/library/reader";
    } else {
        $home_path = "/library";
    }
    return $home_path;
}


//user access control
//for customer pages

// function redirect_not_customer() {
//     global $home_path;
//     if(isset($_SESSION['admin']) || isset($_SESSION['technician'])) {
//         header("Location: " . get_home_path());
//     }
// }

//user access control for admin pages
function redirect_not_admin() {
    global $home_path;
    if(isset($_SESSION['customer']) || isset($_SESSION['technician'])) {
        header("Location: " . get_home_path());
    }
}

// //access control for all pages requiring any kind of session
// function redirect_no_session() {
//     if(!isset($_SESSION['customer']) && !isset($_SESSION['admin']) 
//     && !isset($_SESSION['technician'])) {
//         header("Location: /A3");
//     }
// }

session_start();
?>
