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

?>