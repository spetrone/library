<?php
function is_invalid_admin_login($user_name, $password) {
    global $db;
    $query = 'SELECT * FROM administrators
              WHERE username = :user_name';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_name', $user_name);
        $statement->execute();
        $result = $statement->fetch();
        $valid = ($statement->rowCount() == 1);
        $statement->closeCursor();
        //if there is an email match, verify password
        if($valid) {
            $db_password = $result["password"];
            if (password_verify($password, $db_password)) {
                return 0; //success
            } else
                return 1; //incorrect password
        } else {
            return 2; //error code for invalid email
        }
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
} 

?>

