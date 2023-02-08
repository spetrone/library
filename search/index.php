<?php
require_once('../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/book_db.php');
require_once('model/author_db.php');
require_once('model/reader_db.php');
require_once('model/selection_db.php');
require_once('model/BookClass.php');



//redirect anyone who doesn't have a session (not an admin or reader)
redirect_no_session();


$action = filter_input(INPUT_POST, 'action');
if (isset($_SESSION['admin']) || isset($_SESSION['reader'])) {
    if ($action == null) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == null ) {
            $action = 'load_books';            
        }
    }
} elseif ($action == 'query_books') {
    $action = 'query_books';
} elseif ($action == 'delete_book') {
    $action = 'delete_book';
} elseif ($action == 'show_edit_book') {
    $action = 'show_edit_book';
} elseif ($action == 'edit_book') {
    $action = 'edit_book';
} elseif ($action == 'add_to_list') {
    $action = 'add_to_list';
} else {
    $action = 'load_books';
}

switch ($action) {
    case 'load_books':

        //Get books (all for admin, only those not in list for reader)
        if (isset($_SESSION["admin"])) {
            $all_books = get_all_books();
        } elseif (isset($_SESSION["reader"])) {
            $reader_id = (get_reader_by_email($_SESSION["reader"]))["readerID"];
            $all_books = get_reader_books($reader_id);
        }
        
        //unset selected book incase it was set, reset if back at this page
        unset($_SESSION["selected_book"]);
 
        include 'view/search_books.php';
        break;
    case 'query_books':
        
        $type = filter_input(INPUT_POST, "type_selector");
        $query = filter_input(INPUT_POST, "query");
        $result_list = [];
        if ($type == "lastname") {
            if(isset($_SESSION["admin"])) {
                $result_list = search_by_lastname($query);
            } elseif (isset($_SESSION["reader"])) {
                $reader_id = (get_reader_by_email($_SESSION["reader"]))["readerID"];
                $result_list = search_by_lastname_reader($query, $reader_id);
            }
           
        } elseif ($type == "title") {
            if(isset($_SESSION["admin"])) {
                $result_list = search_by_title($query);
            } elseif (isset($_SESSION["reader"])) {
                $reader_id = (get_reader_by_email($_SESSION["reader"]))["readerID"];
                $result_list = search_by_title_reader($query, $reader_id);
            }
           
        }
        //convert to json and echo for response
        echo (json_encode($result_list));

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

    case 'add_to_list':
        if(isset($_SESSION["reader"])) {
            $reader_id = (get_reader_by_email($_SESSION["reader"]))["readerID"];
                #add book to list, then go back to search
            $book_id = filter_input(INPUT_POST, "selected_book");
            add_to_list($reader_id, $book_id);
        }

        #refresh page to load books
        header("Location: " . "./?action=load_books");
        break;
    
    default:
    $error_message = 'Unknown account action: ' . $action;
    
    break;
}
?>