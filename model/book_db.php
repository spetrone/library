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


function get_book_by_id($book_id) {
    global $db;
    $query = '
        SELECT *
        FROM books JOIN authors
        ON books.authorID=authors.authorID
        WHERE bookID = :book_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':book_id', $book_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>