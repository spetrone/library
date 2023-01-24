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
                    <td><?php echo $reader["firstName"] . " " . $reader["lastName"]; ?></td>
                </tr>
                <tr>
                    <td>ID: </td>
                    <td><?php echo $reader["readerID"] ?></td>
                </tr>
                <tr>
                    <td>Email: </td>
                    <td><?php echo $reader["email"]; ?></td>
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
                <td><?php echo $book["title"]?></td>
                    <td><?php echo $book["firstName"] . " " . $book["lastName"]?></td>
                    <td><a href="/library/book_files/test.pdf">PDF</a></td>
                    <td>Delete</td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>


    <ul>
        <!-- <li><a href="../manage_readers">Manage Readers</a></li> -->
        <li><a href="../manage_books/?action=search_books">Edit Books</a></li>
        <li><a href="../manage_books/?action=display_book_form">Add Book</a></li>
       
    </ul>

    <div id="user-logout">
        <p><?php echo "You are logged in as " .  $_SESSION['reader']?></p>
        <form action="." method="post" id="admin_logout_form">
            <input type="hidden" name="action" value="logout">
            <input type="submit" value="Logout">
        </form>
    </div>


</div>

<?php include 'view/footer.php'; ?>