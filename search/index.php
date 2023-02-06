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
    case 'show_edit_book':

        //set page type for view
        $page_type = 2;
        $upload_msg = ""; //initialize/reset upload message

        //create an empty book
        $success_message = ""; //reset message to empty string
        if (!isset($author_list)) {$author_list = [];}
        $book = new Book(); //all parameters initialized to empty strings

        #put selected book into session if the book id came from a post, otherwise it 
        #is a blank form for adding a book

        $book_id = filter_input(INPUT_POST, 'selected_book');
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

        $book = new Book();
        $book->setBookID($_POST["book_id"]);
        $book->setTitle($_POST["book_title"]);
        $book->setAuthorID($_POST["author_selector"]);
        $book->setIsbn10($_POST["isbn10"]);
        $book->setIsbn13($_POST["isbn13"]);
        $book->setPublishYear($_POST["publish_year"]);

        //get filepath
        include "upload_file.php";
        //use uploadOK flag from upload_file.php
        if ($uploadOk) {
            $book->setFilepath($target_file);
        } else {
            //set it to nothing
            $book->setFilepath("");
        }
        


        //if valid, submit to db, show success message
        update_book($book);
            
            $success_message = "Successfully added book with ID " . $book->getBookID() . "!";
        
        #get author list for edit book form
        $author_list = get_all_authors();
        

        //if not valid, show errors

        include "view/edit_book.php";
        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    
    break;
}
?>