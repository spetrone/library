<?php 
require_once('../../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/reader_db.php');

//redirect anyone who doesn't have a session (not an admin or reader)
redirect_no_session();
//requires admin access
redirect_not_admin();


$action = filter_input(INPUT_POST, 'action');
if (isset($_SESSION['admin'])) {
    if ($action == null) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == null ) {
            $action = 'show_readers';            
        }
    }
} elseif ($action == 'delete_reader') {
    $action = 'delete_reader';
} elseif ($action == 'show_edit_reader') {
    $action = 'show_edit_reader';
} elseif ($action == 'edit_reader') {
    $action = 'edit_reader';
} elseif ($action == 'show_add_reader') {
    $action = 'show_add_reader';
} elseif ($action == 'add_reader') {
    $action = 'add_reader';
}  else {
    $action = 'show_readers';
}

switch ($action) {
    case 'show_readers':
        //select all readers from database
        $reader_list = get_all_readers();
        include "view/show_readers.php";
        break;
    case 'delete_reader':
     
        break;
    case 'show_edit_reader':
        //set strings used in page
        $reader_id = filter_input(INPUT_POST, "reader_id");
        $reader = get_reader_by_id($reader_id);
        $f_name_err = $l_name_err = $email_err = $password_err = $success_message ="";
        $fname = $reader["firstName"];
        $lname = $reader["lastName"];
        $email = $reader["email"];
        $password = $reader["password"];
        include "view/edit_reader.php";
        break;
    case 'edit_reader':
        $f_name_err = $l_name_err = $email_err = $password_err = $success_message =""; //reset error messages
        
        //set vars for reloads if user did not enter anything
        $fname = $lname = $email = $password = ''; //reset/initialize for page reloads

        //get form data
        $reader_id = filter_input(INPUT_POST, "reader_id");
        $fname = filter_input(INPUT_POST, "first_name");
        $lname = filter_input(INPUT_POST, "last_name");
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password");

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
        if (!is_valid_email($email)) {
            $email_err = "invalid email, please enter as form xxxxx@xxxx.xxxx";
            $valid = 0;
        }
        if (!validate_password($password)) {
            $password_err = "Invalid password, please enter at between 8 and 128 characters";
            $valid = 0;
        }

        //add if valid, otherwise show errors
        if($valid) {
            update_reader($reader_id, $fname, $lname, $email, $password);
            $success_message = "succesfully edited user!";
            include "view/edit_reader.php"; //show success message on same page
        } else {
            include "view/edit_reader.php"; //go back to same page, show errors
        }
       
        break;
    case 'show_add_reader':
        //set strings used in page
        $f_name_err = $l_name_err = $email_err = $password_err = $success_message ="";
        $fname = $lname = $email = $password = ''; 
        include "view/add_reader.php";
        break;
    case 'add_reader':
        $f_name_err = $l_name_err = $email_err = $password_err = $success_message =""; //reset error messages
        
        //set vars for reloads if user did not enter anything
        $fname = $lname = $email = $password = ''; //reset/initialize for page reloads

        //get form data
        $fname = filter_input(INPUT_POST, "first_name");
        $lname = filter_input(INPUT_POST, "last_name");
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, "password");

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
        if (!is_valid_email($email)) {
            $email_err = "invalid email, please enter as form xxxxx@xxxx.xxxx";
            $valid = 0;
        }

        if (is_used_email($email)) {
            $email_err .= "duplicate email, please use another email.";
            $valid = 0;
        }
        if (!validate_password($password)) {
            $password_err = "Invalid password, please enter at between 8 and 128 characters";
            $valid = 0;
        }

        //add if valid, otherwise show errors
        if($valid) {
            add_reader($fname, $lname, $email, $password);
            $reader_id = get_reader_by_email($email);
            $success_message = "succesfully added user!";
            include "view/edit_reader.php"; //bring to edit user if they want
        } else {
            include "view/add_reader.php"; //go back to same page, show errors
        }
        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    
    break;
}
?>