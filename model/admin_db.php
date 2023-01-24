<?php
function is_valid_admin_login($user_name, $password) {
    global $db;
    $query = 'SELECT * FROM administrators
              WHERE username = :user_name AND password = :password';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':user_name', $user_name);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $valid = ($statement->rowCount() == 1);
        $statement->closeCursor();
        return $valid;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
} 

?>