<?php
require_once('../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/reader_db.php');

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
} elseif ($action == 'login') {
    $action = 'login';
} elseif ($action == 'logout') {
    $action = 'logout';
}  else {
    $action = 'view_login';
}

//unset($_SESSION['customer']);
switch ($action) {
    case 'view_login':
        // Clear login data
        $email = '';
        $password = '';
        $login_err = '';
        $email_err = '';
        $password_err = '';
        
        //got back to login
        include 'view/reader_login.php';
        break;
    case 'login':
        // Get email/password
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        if(!isset($login_err)) {$login_err = '';} 
        if(!isset($password_err)) {$password_err = '';} 
        if(!isset($email_err)) {$email_err = '';} 
        $validData = 1; //initialize to valid
        
        // Validate user data       
        if(!is_valid_email($email)) {
            $email_err = "Invalid email: $email";
            $validData = 0; //set flag to false
        }
        if(!is_valid_password($password)) {
            $password_err = "Invalid password. Please use a password between 6 and 
            20 characters";
            $validData = 0; //set flag to false
        }     

        // If validation errors, redisplay Login page and exit controller
        if (!$validData) {
            include 'view/reader_login.php';
            break;
        }
        
        // Check database - if valid email/password, log in
        if($pas_err = is_invalid_reader_login($email, $password)) {
            if ($pas_err == 1) { //error code 1 - invalid password
                $login_err = 'Login failed! Invalid password.';
            } else if ($pas_err == 2) { //error code 2 - invalid email
                $login_err = 'Login failed! Invalid email.';
            }
            include 'view/reader_login.php';
            break;

        } else {
            //set user data in session
            $_SESSION['reader'] = $email;
        }

        // Go to next page
        header('Location: ./display_account');
        break;
    case 'display_account':
         // Go to next page
         header('Location: ./display_account');
        break;

    case 'logout':
        unset($_SESSION['technician']);
        session_destroy();
        redirect('/library');
        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    redirect('/library/');
    break;
}
?>