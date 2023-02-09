<?

function get_all_readers() {
    global $db;
    $query = '
        SELECT *
        FROM readers';
    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_reader($fname, $lname, $email, $password) {
    global $db;
    $query = '
        INSERT into readers 
        VALUES (NULL, :f_name, :l_name, :email, :password)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':f_name', $fname);
        $statement->bindValue(':l_name', $lname);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}


function is_valid_reader_login($email, $password) {
    global $db;
    $query = 'SELECT * FROM readers
              WHERE email = :email AND password = :password';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
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

function is_used_email($email) {
    global $db;
    $query = 'SELECT * FROM readers
              WHERE email = :email';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $valid = ($statement->rowCount() == 1);
        $statement->closeCursor();
        return $valid;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
} 

function get_reader_by_email($email) {
    global $db;
    $query = '
        SELECT *
        FROM readers
        WHERE email = :email';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_reader_by_id($id) {
    global $db;
    $query = '
        SELECT *
        FROM readers
        WHERE readerID = :reader_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':reader_id', $id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_reader($reader_id, $f_name, $l_name, $email, $password) {
    global $db;
    $query = 'UPDATE readers
              SET readerID = :reader_id, firstName = :f_name, lastName = :l_name, email = :email,
              password = :password
              WHERE readerID = :reader_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':reader_id', $reader_id);
        $statement->bindValue(':f_name', $f_name);
        $statement->bindValue(':l_name', $l_name);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $statement->closeCursor();
        // Get the last product ID that was automatically generated
        $reader_id = $db->lastInsertId();
        return $reader_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}


function delete_reader($reader_id) {
    global $db;
    $query = 'DELETE FROM readers WHERE readerID = :reader_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':reader_id', $reader_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}


?>