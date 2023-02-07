<?php
require_once('../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/book_db.php');
require_once('model/author_db.php');
require_once('model/BookClass.php');



//redirect anyone who doesn't have a session (not an admin or reader)
redirect_no_session();


$action = filter_input(INPUT_POST, 'action');
if (isset($_SESSION['admin']) || isset($SESSION['reader'])) {
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
} elseif ($action == 'show_edit_book') {
    $action = 'show_edit_book';
} elseif ($action == 'edit_book') {
    $action = 'edit_book';
}else {
    $action = 'load_books';
}

switch ($action) {
    case 'load_books':

        //Get books
        $all_books = get_all_books();
        //unset selected book incase it was set, reset if back at this page
        unset($_SESSION["selected_book"]);
 
        include 'view/search_books.php';
        break;
    case 'query_title':
       
        include 'view/admin_menu.php';
        break;
    case 'query_author':
        // View admin menu
        include '';
        break;
    case 'add_book':
        #go to admin section
        header("Location: " . $app_root . "admin/manage_books/?action=show_edit_book");
        break;
    case 'show_edit_book':
        #go to admin view to manage books
        $_SESSION['selected_book'] = filter_input(INPUT_POST, 'selected_book');
        header("Location: " . $app_root . "admin/manage_books/?action=show_edit_book");
        break;
    
    default:
    $error_message = 'Unknown account action: ' . $action;
    
    break;
}
?>