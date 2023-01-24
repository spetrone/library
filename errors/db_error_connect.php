<?php if (!isset($error_message)) {
    $error_message = '';
} ?>
<main>
    <h1>Database Error</h1>
    <p>An error occurred connecting to the database.</p>
    <p>Error message: <?php echo $error_message; ?></p>
</main>
