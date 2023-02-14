<?php 
include ('view/header.php');
redirect_not_admin();
redirect_no_session();

?>



    <div>
    <h2>Admin Menu</h2>

    <ul>
        <!-- <li><a href="../manage_readers">Manage Readers</a></li> -->
        <div>
            <button type="button" class="btn btn-primary" style="margin:10px"><a href="manage_books/?action=load_books"
         style="color: #FFFFFF;text-decoration: none;">Manage Books</a></button>
        </div>
        <div>
        <button type="button" class="btn btn-primary" style="margin:10px"><a href="./manage_readers/"
        style="color: #FFFFFF;text-decoration: none;">Manage Readers</a></button>
        </div>

       
    </ul>


</div>

<?php include 'view/footer.php'; ?>