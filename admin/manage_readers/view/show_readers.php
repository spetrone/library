<?php 
include ('view/header.php');

redirect_no_session();
redirect_not_admin();

?>

<div>
   
    <div class="row">

        
        <div class="col">
            <h5>Readers</h5>
            <div>
            <!-- button to add reader -->
            <div>
            <form  action="./?action=show_add_reader" method="POST">
                <input type="submit" name="add_button" value="Add Reader">
            </form>
            </div>

            <!-- list all reader$readers returned from request to server
                on initial page load, this is all reader$readers in the db-->
            <table class="table">
                <tr>
                    <td>ID</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Email</td>
                    <td>Action</td>  
                </tr>

                <?php foreach ($reader_list as $reader) : ?>
                <tr>
                    <td><?php echo $reader["readerID"]?></td>
                    <td><?php echo htmlspecialchars($reader["firstName"])?></td>
                    <td><?php echo htmlspecialchars($reader["lastName"])?></td>
                    <td><?php echo htmlspecialchars($reader["email"]) . "" ?></td>
                    <td>
                        <form style="display:inline-block;" action="./?action=show_edit_reader" method="POST">
                            <input type="hidden" name="reader_id" 
                                value = <?php echo htmlspecialchars($reader["readerID"])?>>
                            <input type="submit" name="edit_button" value="edit">
                        </form>
                        <form style="display:inline-block;" action="./?action=delete_reader" method="POST">
                            <input type="hidden" name="reader_id" 
                                value = <?php echo htmlspecialchars($reader["readerID"])?>>
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