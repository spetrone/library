<?php 
require_once('../../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/author_db.php');

//redirect anyone who doesn't have a session (not an admin or author)
redirect_no_session();
//requires admin access
redirect_not_admin();


$action = filter_input(INPUT_POST, 'action');
if (isset($_SESSION['admin'])) {
    if ($action == null) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == null ) {
            $action = 'show_authors';            
        }
    }
} elseif ($action == 'delete_author') {
    $action = 'delete_author';
} elseif ($action == 'show_edit_author') {
    $action = 'show_edit_author';
} elseif ($action == 'edit_author') {
    $action = 'edit_author';
} elseif ($action == 'show_add_author') {
    $action = 'show_add_author';
} elseif ($action == 'add_author') {
    $action = 'add_author';
}  else {
    $action = 'show_authors';
}

switch ($action) {
    case 'show_authors':

        //unset session variable for editing author if set
        if(isset($_SESSION["edit_author"])) { unset($_SESSION["edit_author"]);}
        
        //select all authors from database
        $author_list = get_all_authors();
        include "view/show_authors.php";
        break;
    case 'delete_author':
        $author_id = filter_input(INPUT_POST, "author_id");
        delete_author($author_id);

        //reload page
        header("Location: " . "./?action=show_authors");
        break;
    case 'show_edit_author':

       //set flag to make sure that a author is selected
       $is_selected = false;

       //set strings used in page, set session var for reloads

       //if set from post, use that value, otherwise get it from the session value
       if(isset($_POST["author_id"])) {
           $_SESSION["edit_author"] = $author_id = filter_input(INPUT_POST, "author_id");
           $is_selected = true;
       } else if (isset($_SESSION["edit_author"])) {
           $author_id = $_SESSION["edit_author"];
           $is_selected = true;
       }
       if ($is_selected) { //if selected show on page
           $author = get_author_by_id($author_id); //do db call
           $f_name_err = $l_name_err = $success_message ="";
           $fname = $author["firstName"];
           $lname = $author["lastName"];

           include "view/edit_author.php";
       } else { //no author is selected, redirect
           header("Location: " . "./?action=show_authors");
       }

        break;
    case 'edit_author':
        $f_name_err = $l_name_err = $success_message =""; //reset error messages
        
        //set vars for reloads if user did not enter anything
        $fname = $lname =  ''; //reset/initialize for page reloads

        //get form data
        $author_id = filter_input(INPUT_POST, "author_id");
        $fname = filter_input(INPUT_POST, "first_name");
        $lname = filter_input(INPUT_POST, "last_name");

        $valid = 1; //set flag to true

        //validate input

        if (!validate_name($fname)) {
            $f_name_err = "invalid firstname, please enter a name < 255 chars";
            $valid = 0;
        }
        if (!validate_name($lname)) {
            $l_name_err = "invalid firstname, please enter a name < 255 chars";
            $valid = 0;
        }


        //add if valid, otherwise show errors
        if($valid) {

            update_author($author_id, $fname, $lname);
            $success_message = "succesfully edited user!";
            include "view/edit_author.php"; //show success message on same page
        } else {
            include "view/edit_author.php"; //go back to same page, show errors
        }
       
        break;
    case 'show_add_author':
        //set strings used in page
        $f_name_err = $l_name_err = $success_message ="";
        $fname = $lname = ''; 
        include "view/add_author.php";
        break;
    case 'add_author':
        $f_name_err = $l_name_err =  $success_message =""; //reset error messages
        
        //set vars for reloads if user did not enter anything
        $fname = $lname = ''; //reset/initialize for page reloads

        //get form data
        $fname = filter_input(INPUT_POST, "first_name");
        $lname = filter_input(INPUT_POST, "last_name");


        $valid = 1; //set flag to true

        //validate input

        if (!validate_name($fname)) {
            $f_name_err = "invalid firstname, please enter a name < 255 chars";
            $valid = 0;
        }
        if (!validate_name($lname)) {
            $l_name_err = "invalid firstname, please enter a name < 255 chars";
            $valid = 0;
        }

        if (author_exists($fname, $lname)) {
            $l_name_err = "Author already exists!";
            $valid = 0;
        }

        //add if valid, otherwise show errors
        if($valid) {

            add_author($fname, $lname);

            $success_message = "succesfully added author!";
            include "view/add_author.php"; //stay on page
        } else {
            include "view/add_author.php"; //go back to same page, show errors
        }
        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    
    break;
}
?>