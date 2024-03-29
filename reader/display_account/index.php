<?php
require_once('../../util/main.php');
require_once('util/validation.php');
require_once('util/secure_conn.php');
require_once('model/reader_db.php');
require_once('model/selection_db.php');

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
} elseif ($action == 'logout') {
    $action = 'logout';
} elseif ($action == 'display_account') {
    $action = 'display_account';
} elseif ($action == 'remove_book') {
    $action = 'remove_book';
} else {
    $action = 'view_login';
}

//unset($_SESSION['customer']);
switch ($action) {
    case 'view_login':
        // go back to other controller, back to login pag
        //show view
        header('Location: ../?action=view_login');
        break;

    case 'display_account':

        //get user information
        $reader = get_reader_by_email($_SESSION["reader"]);
        //get book list/selections
        $selection = get_book_list($reader["readerID"]);

        ?><script> console.log("<?php echo password_hash("remember", PASSWORD_DEFAULT); ?>");</script><?

        // View incident update module
        include("view/reader_account.php");
        break;
    case 'remove_book':
        //get user information
        $reader= get_reader_by_email($_SESSION["reader"]);
        $reader_id = $reader["readerID"];

        //remove the book, then get db information to show page again
        $book_id = filter_input(INPUT_POST,"selected_book");
        remove_book_selection($reader_id, $book_id);

        //get book list/selections
        $selection = get_book_list($reader_id);

        // reload reader page
        header("Location: " . "./?action=display_account");
        break;
    case 'logout':
        unset($_SESSION['reader']);
        session_destroy();
        redirect('/library');
        break;
    default:
    $error_message = 'Unknown account action: ' . $action;
    redirect('/library/');
    break;
}
?>