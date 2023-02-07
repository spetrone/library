<?php 
require_once('../../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/book_db.php');
require_once('model/author_db.php');
require_once('model/BookClass.php');



//redirect anyone who doesn't have a session (not an admin or reader)
redirect_no_session();
//requires admin access
redirect_not_admin();


$action = filter_input(INPUT_POST, 'action');
if (isset($_SESSION['admin'])) {
    if ($action == null) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == null ) {
            $action = 'load_books';            
        }
    }
} elseif ($action == 'delete_book') {
    $action = 'delete_book';
} elseif ($action == 'show_edit_book') {
    $action = 'show_edit_book';
} elseif ($action == 'edit_book') {
    $action = 'edit_book';
} elseif ($action == 'add_book') {
    $action = 'add_book';
} else {
    $action = 'load_books';
}

switch ($action) {
    case 'load_books':
        //go to main search area
        header("Location: " . $app_root . "search");
        break;
    case 'delete_book':
        $book_id = $_SESSION["selected_book"];
        break;
    case 'show_edit_book':

        //set page type for view
        $page_type = 2;
        $upload_msg = ""; //initialize/reset upload message
        $err_arr = []; //error array will be empty for initial form load

        //create an empty book
        $success_message = ""; //reset message to empty string
        if (!isset($author_list)) {$author_list = [];}
        $book = new Book(); //all parameters initialized to empty strings

        #put selected book into session if the book id came from a post, otherwise it 
        #is a blank form for adding a book

        $book_id = $_SESSION["selected_book"];
        if ($edit_book = (get_book_by_id($book_id))) {
            $book->setBookID($edit_book["bookID"]);
            $book->setTitle($edit_book["title"]);
            $book->setAuthorID($edit_book["authorID"]);
            $book->setFirstName($edit_book["firstName"]);
            $book->setLastName($edit_book["lastName"]);
            $book->setIsbn10($edit_book["isbn10"]);
            $book->setIsbn13($edit_book["isbn13"]);
            $book->setPublishYear($edit_book["publishYear"]);
            $book->setFilepath($edit_book["filePath"]);
        }
        
        #get author list for edit book form
        $author_list = get_all_authors();
        
        include "view/edit_book.php";
        break;
    case 'edit_book':
        $page_type = 2;
        $success_message = ""; //initialize/reset success message
        $upload_msg = ""; //initialize/reset upload message
        $target_file = null; //initialize target file path to null
        $err_arr = []; //initizlize/reset error array
        $isValid = 1; //flag for valid form data

        //update book, doing form validation
        $book = new Book();

        $book->setBookID($_POST["book_id"]);
        
        if (validate_book_title(filter_input(INPUT_POST, 'book_title')) && $isValid) {
            $book->setTitle(filter_input(INPUT_POST, 'book_title'));
        } else {
            $err_arr["title"] = "invalid book title, please enter title < 255 chars.";
            $isValid = 0;
        }
        
        //author is selected, no validation needed in this form
        if ($isValid) {
            $book->setAuthorID($_POST["author_selector"]);
        }
        
        if (validate_isbn10(filter_input(INPUT_POST, 'isbn10')) && $isValid) {
            $book->setIsbn10(filter_input(INPUT_POST, 'isbn10'));
        } else {
            $err_arr["isbn10"] = "Invalid ISBN 10, please use the form  x-xxx-xxxxx-x. ";
            $isValid = 0;
        }
        
        if (validate_isbn13(filter_input(INPUT_POST, 'isbn13')) && $isValid){
            $book->setIsbn13(filter_input(INPUT_POST, 'isbn13'));
        } else {
            $err_arr["isbn13"] = "Invalid ISBN 13, please use the form xxx-x-xx-xxxxxx-x";
            $isValid = 0;
        }

        if (validate_year(filter_input(INPUT_POST, 'publish_year')) && $isValid ) {
            $book->setPublishYear(filter_input(INPUT_POST, 'publish_year'));
        } else {
            $err_arr["year"] = "invalid year, please enter a 4-digit year YYYY.";
            $isValid = 0;
        }
        

        //get filepath
        include "upload_file.php";
        //use uploadOK flag from upload_file.php
        if ($uploadOk) {
            $book->setFilepath($filepath);
        } 
        
        //show message of success or errors
        if ($isValid) {
            //if valid, submit to db, show success message
            update_book($book);
            $success_message = "Successfully added book with ID " . $book->getBookID() . "!";
            include "view/success_edit_book.php";
        } else {
            $success_message = "Could not edit book.";
            include "view/edit_book.php";
        }
        

        
        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    
    break;
}
?>