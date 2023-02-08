<?php
require_once('model/BookClass.php');

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

function search_by_title($title) {
    global $db;
    $query = '
    SELECT *
    FROM books JOIN authors
    ON books.authorID=authors.authorID
    WHERE title LIKE :title';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':title', '%'. $title . '%');
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function search_by_lastname($lastname) {
    global $db;
    $query = '
    SELECT *
    FROM books JOIN authors
    ON books.authorID=authors.authorID
    WHERE lastName LIKE :lastname';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':lastname', '%'. $lastname . '%');
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


function update_book(Book $edt_book) {
    global $db;
    $query = 'UPDATE books
              SET authorID = :author_id, title = :title, publishYear = :publish_year, filepath = :filepath
              WHERE bookID = :book_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':book_id', $edt_book->getBookID());
        $statement->bindValue(':author_id', $edt_book->getAuthorID());
        $statement->bindValue(':title', $edt_book->getTitle());
        $statement->bindValue(':publish_year', $edt_book->getPublishYear());
        $statement->bindValue(':filepath', $edt_book->getFilepath());
        $statement->execute();
        $statement->closeCursor();
        // Get the last product ID that was automatically generated
        $book_id = $db->lastInsertId();
        return $book_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}


function add_book(Book $edt_book) {
    global $db;
    $query = 'INSERT into books
              VALUES (NULL, :author_id, :title, :publish_year, :filepath)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':author_id', $edt_book->getAuthorID());
        $statement->bindValue(':title', $edt_book->getTitle());
        $statement->bindValue(':publish_year', $edt_book->getPublishYear());
        $statement->bindValue(':filepath', $edt_book->getFilepath());
        $statement->execute();
        $statement->closeCursor();
        // Get the last product ID that was automatically generated
        $book_id = $db->lastInsertId();
        return $book_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_book($book_id) {
    global $db;
    $query = 'DELETE FROM books WHERE bookID = :book_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':book_id', $book_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>