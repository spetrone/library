<?php
require_once('../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/book_db.php');

//redirect anyone who doesn't have a session (not an admin or reader)
redirect_no_session();


$action = filter_input(INPUT_POST, 'action');
if (isset($_SESSION['admin'])) {
    if ($action == null) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == null ) {
            $action = 'load_books';            
        }
    }
} elseif ($action == 'query_title') {
    $action = 'query_title';
} elseif ($action == 'query_author') {
    $action = 'query_author';
} elseif ($action == 'delete_book') {
    $action = 'delete_book';
} elseif ($action == 'edit_book') {
    $action = 'edit_book';
} else {
    $action = 'load_books';
}

switch ($action) {
    case 'load_books':

        //Get books
        $all_books = get_all_books();
 
        include 'view/search_books.php';
        break;
    case 'query_title':
       
        include 'view/admin_menu.php';
        break;
    case 'query_author':
        // View admin menu
        include '';
        break;
    case 'delete_book':

        break;
    case 'edit_book':

        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    include "/library/";
    break;
}
?>