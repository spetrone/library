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

        //create an empty book

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
    default:
    $error_message = 'Unknown account action: ' . $action;
    include "/library/";
    break;
}
?>