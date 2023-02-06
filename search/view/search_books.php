<?php 
include ('view/header.php');

redirect_no_session();

?>

<div>
    <!-- Search form for querying books by author or title -->
    <div class="row">
        <div class="col">
            <form action="" method="POST">
                <label>Enter Query:</label>
                <input name="query" type=text>
                <input type="submit" name="search_button" value="search">
            </form>
        </div>
    </div>
   
    <div class="row">

        
        <div class="col">
            <h5>Books </h5>
            <!-- list all books returned from request to server
                on initial page load, this is all books in the db-->
            <table class="table">
                <tr>
                    <td>Book Title</td>
                    <td>Author</td>
                    <td>PDF</td>
                    <?php if (isset($_SESSION['admin'])) : ?>
                        <td>Action</td>
                    <?php endif; ?>
                </tr>

                <?php foreach ($all_books as $book) : ?>
                <tr>
                    <td><?php echo $book["title"]?></td>
                    <td><?php echo htmlspecialchars($book["firstName"]) . " " . htmlspecialchars($book["lastName"])?></td>
                    <td><a href="/library/book_files/test.pdf">PDF</a></td>

                    <!-- Column for editing and deleting books - admin only -->
                    <?php if (isset($_SESSION['admin'])) : ?>
                    <td>
                        <form action="" method="POST">
                            <input type="hidden" name="selected_book" 
                                value = <?php echo htmlspecialchars($book["bookID"])?>>
                            <input type="submit" name="delete_button" value="delete">
                            <input type="submit" name="edit_button" value="edit">
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>

            </table>
        </div>
    </div>


</div>

<?php include 'view/footer.php'; ?>