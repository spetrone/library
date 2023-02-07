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
            <div>
            <form  action="./?action=add_book" method="POST">
                <input type="submit" name="add_button" value="Add Book">
            </form>
            </div>
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

                    <!-- show pdf link if there is one for the book -->
                    <?php if($book["filePath"] != "") : ?>
                        <td><a href=<?php echo htmlspecialchars($book["filePath"]); ?>>PDF</a></td>
                    <?php else : ?>
                        <td><!-- no pdf, leave empty --></td>
                    <?php endif; ?>

                    <!-- Column for editing and deleting books - admin only -->
                    <?php if (isset($_SESSION['admin'])) : ?>
                    <td>
                        <form style="display:inline-block;" action="./?action=show_edit_book" method="POST">
                            <input type="hidden" name="selected_book" 
                                value = <?php echo htmlspecialchars($book["bookID"])?>>
                            <input type="submit" name="edit_button" value="edit">
                        </form>
                        <form style="display:inline-block;" action="./?action=delete_book" method="POST">
                            <input type="hidden" name="selected_book" 
                                value = <?php echo htmlspecialchars($book["bookID"])?>>
                            <input type="submit" name="delete_button" value="delete">
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