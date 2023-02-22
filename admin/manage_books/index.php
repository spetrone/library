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
        #post comes from /search/index.php
        $book_id = $_POST["selected_book"];
        delete_book($book_id);
        #go back to book search
        header("Location: " . $app_root . "search");
        break;
    case 'show_edit_book':

        //set page type for view
        $page_type = 1; //by default it is 1 = add book 
        $upload_msg = ""; //initialize/reset upload message
        $year_error = ""; //reset/initialize error for year
        $title_error = ""; //reset/initialize error for title

        //create an empty book
        $success_message = ""; //reset message to empty string
        if (!isset($author_list)) {$author_list = [];}
        $book = new Book(); //all parameters initialized to empty strings

        #put selected book into session if the book id came from a post, otherwise it 
        #is a blank form for adding a book

        if (isset($_SESSION["selected_book"])) {
            $book_id = $_SESSION["selected_book"];
            $page_type = 2;

            $edit_book = (get_book_by_id($book_id)); 
            $book->setBookID($edit_book["bookID"]);
            $book->setTitle($edit_book["title"]);
            $book->setAuthorID($edit_book["authorID"]);
            $book->setFirstName($edit_book["firstName"]);
            $book->setLastName($edit_book["lastName"]);
            $book->setPublishYear($edit_book["publishYear"]);
            $book->setFilepath($edit_book["filePath"]);
        
        }

        
        #get author list for edit book form
        $author_list = get_all_authors();
        
        include "view/edit_book.php";
        break;
    case 'edit_book':
        if(isset($_POST["page_type"]) ){ //if posted
            $page_type = $_POST["page_type"]; //get information about type of form
            //1 is add, 2 is edit
            $success_message = ""; //initialize/reset success message
            $upload_msg = ""; //initialize/reset upload message
            $target_file = null; //initialize target file path to null
            $year_error = ""; //reset/initialize error for year
            $title_error = ""; //reset/initialize error for title
            $isValid = 1; //flag for valid form data

            //update book, doing form validation
            $book = new Book();

            if ($page_type == 2) { //if editing
                $book->setBookID($_POST["book_id"]);
            }
            
            //adding or editing, calidatoe title and year
            if (validate_book_title(filter_input(INPUT_POST, 'book_title')) && $isValid) {
                $book->setTitle(filter_input(INPUT_POST, 'book_title'));
            } else {
                $title_error = "invalid book title, please enter title < 255 chars.";
                $isValid = 0;
            }
            
            //author is selected, no validation needed in this form
            if ($isValid) {
                $book->setAuthorID($_POST["author_selector"]);
            }

            if (validate_year(filter_input(INPUT_POST, 'publish_year'))) {
                $book->setPublishYear(filter_input(INPUT_POST, 'publish_year'));
            } else {
                $year_error = "invalid year, please enter a 4-digit year YYYY.";
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
                $db_id = 0; //initialize to 0
                //if valid, submit to db, show success message
                if((int)$_POST["page_type"] == 2)
                    if($book->getFilepath() != "") { //if file path set, update with filepath
                        $db_id = update_book($book); 
                    } else { //update without file path
                        $db_id = update_book_no_fp($book); 
                    }
                    
                else
                    $db_id = add_book($book);
                
                $success_message = "Successfully updated book!";
                unset($_SESSION["selected_book"]);
                
                include "view/success_edit_book.php";
            } else {
                $success_message = "Could not edit book.";
                #get author list for edit book form
                $author_list = get_all_authors();
                include "view/edit_book.php";
            }
        } else { //page refreshed after error message 
            //refresh page to default (add book)
            header("Location: " . "./?action=show_edit_book");
        }
        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    
    break;
}
?>