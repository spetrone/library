<?

function get_book_list($reader_id) {
    global $db;
    $query = '
    SELECT *
    FROM selections JOIN books
    ON selections.bookID=books.bookID
    JOIN authors 
    ON books.authorID=authors.authorID
    WHERE readerID = :reader_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':reader_id', $reader_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_to_list($reader_id, $book_id) {
    global $db;
    $query = 'INSERT into selections
              VALUES (:reader_id, :book_id)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':reader_id', $reader_id);
        $statement->bindValue(':book_id', $book_id);

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



?>