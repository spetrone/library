<?php 
include ('view/header.php');

redirect_no_session();
redirect_not_admin(); //for admins only
?>

<div>
    <!-- Search form for querying books by author or title -->
    <div class="row">
        <div class="col">
            <h5>Add Reader</h5>
            <form  method="POST" action="./?action=add_reader">
                <div>
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
                    <label>Email:</label>
                    <input type="email" name="email" value=<?php echo $email; ?>>
                     <p class="errors"><?php echo $email_err ?></p>
                </div>

                <div>
                    <label>Password:</label>
                    <input type="password" name="password" value=<?php echo $password; ?>>
                     <p class="errors"><?php echo $password_err ?></p>
                </div>

                <div>
                    <input type="submit" name="submit" value="Add">
                </div>
            </form>
        </div>

        <div>
            <p><?php echo $success_message ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col">s
            <a href="./?action=show_readers">Back to Reader list</a>
        </div>
    </div>

</div>

<?php include 'view/footer.php'; ?>