<?php
require_once('../../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/reader_db.php');
require_once('model/selection_db.php');

//redirect any non-reader users with active session
redirect_not_reader();


$action = filter_input(INPUT_POST, 'action');
if (isset($_SESSION['reader'])) {
    if ($action == null) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == null ) {
            $action = 'display_account';            
        }
    }
} elseif ($action == 'logout') {
    $action = 'logout';
} elseif ($action == 'display_account') {
    $action = 'display_account';
} elseif ($action == 'remove_book') {
    $action = 'remove_book';
} else {
    $action = 'view_login';
}

//unset($_SESSION['customer']);
switch ($action) {
    case 'view_login':
        // go back to other controller, back to login pag
        
        //show view
        header('Location: ./reader?action=view_login');
        break;

    case 'display_account':
        // View incident update module
        include("view/reader_account.php");
        break;
    case 'logout':
        unset($_SESSION['reader']);
        session_destroy();
        redirect('/library');
        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    redirect('/library/');
    break;
}
?>