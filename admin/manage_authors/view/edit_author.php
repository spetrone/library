<?php 
include ('view/header.php');

redirect_no_session();
redirect_not_admin(); //for admins only
?>

<div>
    <!-- Search form for querying books by author or title -->
    <div class="row">
        <div class="col">
            <h5>Edit author</h5>
            <form  method="POST" action="./?action=edit_author">
                <div>
                    <input type="hidden" name="author_id" value = <?php echo $author_id ?>>
                    <label>First Name:</label>
                    <input type="text" name="first_name" value=<?php echo $fname; ?>>
                     <p class="errors"><?php echo $f_name_err ?></p>
                </div>

                <div>
                    <label>Last Name:</label>
                    <input type="text" name="last_name" value=<?php echo $lname; ?>>
                     <p class="errors"><?php echo $l_name_err ?></p>
                </div>

                <div>
                    <input type="submit" name="submit" value="save">
                </div>
            </form>
        </div>

        <div>
            <p><?php echo $success_message ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <a href="./?action=show_authors">Back to author list</a>
        </div>
    </div>

</div>

<?php include 'view/footer.php'; ?>