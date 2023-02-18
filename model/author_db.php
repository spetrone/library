<?php

function get_all_authors() {
    global $db;
    $query = '
    SELECT * FROM authors';
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


function add_author($fname, $lname) {
    global $db;
    $query = '
        INSERT into authors 
        VALUES (NULL, :f_name, :l_name)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':f_name', $fname);
        $statement->bindValue(':l_name', $lname);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}




function get_author_by_id($id) {
    global $db;
    $query = '
        SELECT *
        FROM authors
        WHERE authorID = :author_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':author_id', $id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_author($author_id, $f_name, $l_name) {
    global $db;
    $query = 'UPDATE authors
              SET authorID = :author_id, firstName = :f_name, lastName = :l_name
              WHERE authorID = :author_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':author_id', $author_id);
        $statement->bindValue(':f_name', $f_name);
        $statement->bindValue(':l_name', $l_name);
        $statement->execute();
        $statement->closeCursor();
        // Get the last product ID that was automatically generated
        $author_id = $db->lastInsertId();
        return $author_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}


function delete_author($author_id) {
    global $db;
    $query = 'DELETE FROM authors WHERE authorID = :author_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':author_id', $author_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}


function author_exists($fname, $lname) {
    global $db;
    $query = 'SELECT * FROM authors
              WHERE firstName = :f_name
              AND lastName = :l_name';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':f_name', $fname);
        $statement->bindValue(':l_name', $lname);
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