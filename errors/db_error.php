<?php

include('view/header.php'); 

if (!isset($error_message)) {
    $error_message = '';
} ?>



    <h1>Database Error</h1>
    <p>A database error occurred.</p>
    <p>Error message: <?php echo $error_message; ?></p>



<?php include('view/footer.php');?>