<?php 
include ('view/header.php');

redirect_no_session();
redirect_not_admin(); //for admins only

?>

<div>
    <!-- Search form for querying books by author or title -->
    <div class="row">
        <div class="col">
            <h5>Edit Book</h5>
            <form action="" method="POST">
                <div>
                <label>Title:</label>
                <input type="text" name="book_title" value="<?php echo htmlspecialchars($book->getTitle())?>">
</div>

                <div>
                <label>Author:</label>
                <input type="text" name="author_name" value="<?php echo htmlspecialchars($book->getFullName())?>">
                </div>

                <div>
                <label>Publish Year:</label>
                <input type="text" name="publish_year" value="<?php echo htmlspecialchars($book->getPublishYear())?>">
                </div>

                <div>
                <label>ISBN10:</label>
                <input type="text" name="isbn10" value="<?php echo htmlspecialchars($book->getIsbn10())?>">
                </div>

                <div>
                <label>ISBN13:</label>
                <input type="text" name="isbn13" value="<?php echo htmlspecialchars($book->getIsbn13())?>">
                </div>

                <div>
                <label>file:</label>
                <input type="text" name="file_path" value="<?php echo htmlspecialchars($book->getFilepath())?>">
                </div>

                <div>
                    <input type="submit" name="save_edits" value="Save Edits">
                </div>
            </form>
        </div>
    </div>

</div>

<?php include 'view/footer.php'; ?>