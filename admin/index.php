<?php
require_once('../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/admin_db.php');

//redirect any non-admin users with active session
redirect_not_admin();


$action = filter_input(INPUT_POST, 'action');
if (isset($_SESSION['admin'])) {
    if ($action == null) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == null ) {
            $action = 'view_menu';            
        }
    }
} elseif ($action == 'login') {
    $action = 'login';
} elseif ($action == 'logout') {
    $action = 'logout';
} else {
    $action = 'view_login';
}

switch ($action) {
    case 'view_login':
        // Clear login data
        $user_name = '';
        $password = '';
        $login_err = '';
        $user_err = '';
        $password_err = '';
        
        
        include 'view/admin_login.php';
        break;
    case 'login':
        // Get username/password
        $user_name = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        if(!isset($login_err)) {$login_err = '';} 
        if(!isset($password_err)) {$password_err = '';} 
        if(!isset($user_err)) {$user_err = '';} 
        $validData = 1; //initialize to valid
        
        // Validate user data       
        if(!is_valid_username($user_name)) {
            $user_err = "Invalid username: $user_name";
            $validData = 0; //set flag to false
        }
        if(!is_valid_password($password)) {
            $password_err = "Invalid password. Please use a password between 6 and 
            20 characters";
            $validData = 0; //set flag to false
        }     

        // If validation errors, redisplay Login page and exit controller
        if (!$validData) {
            include 'view/admin_login.php';
            break;
        }
        
        // Check database - if valid username/password, log in
        if ($login_err = is_invalid_admin_login($user_name, $password)) {

            if($login_err == 1) { //invalid password
                $login_err = 'Login failed! Invalid password.';
            } else if ($login_err == 2) { //invalid username
                $login_err = 'Login failed! Invalid username.';
            }
            //same page, show errors
            include 'view/admin_login.php';
            break;
            
        } else {//success, set session
            $_SESSION['admin'] = $user_name;
        }

        // Display Admin Menu page
        include 'view/admin_menu.php';
        break;
    case 'view_menu':
        // View admin menu
        include 'view/admin_menu.php';
        break;
    case 'logout':
        unset($_SESSION['admin']);
        session_destroy();
        redirect('/library');
        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    include "/library/";
    break;
}
?>