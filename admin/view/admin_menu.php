<?php 
include ('view/header.php');
redirect_not_admin();
redirect_no_session();

?>



    <div>
    <h2>Admin Menu</h2>

    <ul>
     
        <div> 
            <a href="manage_books/?action=load_books"
            class="btn btn-primary" role="button" style="color: #FFFFFF;text-decoration: none; margin:10px;">Manage Books</a>
        </div>

        <div> 
            <a href="./manage_readers/"
            class="btn btn-primary" role="button" style="color: #FFFFFF;text-decoration: none; margin:10px;">Manage Readers</a>
        </div>

        <div> 
            <a href="./manage_authors/"
            class="btn btn-primary" role="button" style="color: #FFFFFF;text-decoration: none; margin:10px;">Manage Authors</a>
        </div>
     
    </ul>


</div>

<?php include 'view/footer.php'; ?>