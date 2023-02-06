<?php

function get_all_books() {
    global $db;
    $query = '
    SELECT *
    FROM books JOIN authors
    ON books.authorID=authors.authorID';
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

?>