<?php 
include ('view/header.php');

redirect_no_session();
redirect_not_admin();

?>

<div>
   
    <div class="row">

        
        <div class="col">
            <h5>Authors</h5>
            <div>
            <!-- button to add auth -->
            <div>
            <form  action="./?action=show_add_author" method="POST">
                <input type="submit" name="add_button" value="Add author">
            </form>
            </div>

            <div>
                <p class="errors" ><?php if(isset($err_message)) { echo $err_message; } ?></p>
            </div>

            <!-- list all autho$authos returned from request to server
                on initial page load, this is all author$authors in the db-->
            <table class="table">
                <tr>
                    <td>ID</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Action</td>  
                </tr>

                <?php foreach ($author_list as $author) : ?>
                <tr>
                    <td><?php echo $author["authorID"]?></td>
                    <td><?php echo htmlspecialchars($author["firstName"])?></td>
                    <td><?php echo htmlspecialchars($author["lastName"])?></td>
                    <td>
                        <form style="display:inline-block;" action="./?action=show_edit_author" method="POST">
                            <input type="hidden" name="author_id" 
                                value = <?php echo htmlspecialchars($author["authorID"])?>>
                            <input type="submit" name="edit_button" value="edit">
                        </form>
                        <form style="display:inline-block;" action="./?action=delete_author" method="POST">
                            <input type="hidden" name="author_id" 
                                value = <?php echo htmlspecialchars($author["authorID"])?>>
                            <input type="submit" name="delete_button" value="delete">
                        </form>
                    </td>

                </tr>
                <?php endforeach; ?>

            </table>
        </div>

    </div>


</div>

<?php include 'view/footer.php'; ?>