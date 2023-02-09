<?php 
include ('view/header.php');
redirect_not_reader();
redirect_no_session();

?>

    <div>
   

    <div class="row">
        <div class="col">
        <h5>Account Details</h5>
            <table class="table">
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Name: </td>
                    <td><?php echo htmlspecialchars($reader["firstName"]) . " " . htmlspecialchars($reader["lastName"]); ?></td>
                </tr>
                <tr>
                    <td>ID: </td>
                    <td><?php echo htmlspecialchars($reader["readerID"]) ?></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td><?php echo htmlspecialchars($reader["email"]); ?></td>
                </tr>
            </table>
        </div>
        <div class="col">
            <h5>Your Book List </h5>
            <table class="table">
                <tr>
                    <td>Book Title</td>
                    <td>Author</td>
                    <td>PDF</td>
                    <td>Action</td>
                </tr>
                <?php foreach ($selection as $book) : ?>
                <tr>
                <td><?php echo htmlspecialchars($book["title"])?></td>
                    <td><?php echo htmlspecialchars($book["firstName"]) . " " . htmlspecialchars($book["lastName"])?></td>
                    <td><a href="/library/book_files/test.pdf">PDF</a></td>
                    <td>
                        <form  action="./?action=remove_book" method="POST">
                                <input type="hidden" name="selected_book" 
                                    value = <?php echo htmlspecialchars($book["bookID"])?>>
                                <input type="submit" name="remove_button" value="remove">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>


    <div id="user-logout">
        <form action="." method="post" id="admin_logout_form">
            <input type="hidden" name="action" value="logout">
            <input type="submit" value="Logout">
        </form>
    </div>


</div>

<?php include 'view/footer.php'; ?>