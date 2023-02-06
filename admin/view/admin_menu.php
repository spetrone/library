<?php 
include ('view/header.php');
redirect_not_admin();
redirect_no_session();

?>



    <div>
    <h2>Admin Menu</h2>

    <ul>
        <!-- <li><a href="../manage_readers">Manage Readers</a></li> -->
        <li><a href="../manage_books/?action=search_books">Edit Books</a></li>
        <li><a href="../manage_books/?action=display_book_form">Add Book</a></li>
       
    </ul>

    <div id="user-logout">
        <p><?php echo "You are logged in as " .  $_SESSION['admin']?></p>
        <form action="." method="post" id="admin_logout_form">
            <input type="hidden" name="action" value="logout">
            <input type="submit" value="Logout">
        </form>
    </div>


</div>

<?php include 'view/footer.php'; ?>