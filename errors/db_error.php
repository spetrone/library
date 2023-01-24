<?php
include '../util.main.php';
include 'view/header.php'; 

if (!isset($error_message)) {
    $error_message = '';
} ?>

<!DOCTYPE html>
<html>
<head>
    <title>Unassigned Incidents</title>
    <link rel="stylesheet" type="text/css" href="/A3/main.css">
</head>
<body>
<main>
    <h1>Database Error</h1>
    <p>A database error occurred.</p>
    <p>Error message: <?php echo $error_message; ?></p>
</main>
</body>
</html>

<?php include 'view/footer.php';?>