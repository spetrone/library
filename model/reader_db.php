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


//returns 0 on success, returns 1 for incorrect password, and 2 for 
//incorrect email
function is_invalid_reader_login($email, $password) {
    global $db;
    $query = 'SELECT * FROM readers
              WHERE email = :email';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
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

function update_reader_no_pass($reader_id, $f_name, $l_name, $email) {
    global $db;
    $query = 'UPDATE readers
              SET readerID = :reader_id, firstName = :f_name, lastName = :l_name, email = :email
              WHERE readerID = :reader_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':reader_id', $reader_id);
        $statement->bindValue(':f_name', $f_name);
        $statement->bindValue(':l_name', $l_name);
        $statement->bindValue(':email', $email);
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