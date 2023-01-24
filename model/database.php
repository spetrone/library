<?php
// Set up the database connection
$dsn = 'mysql:host=localhost;dbname=library_db';
$username = 'lib_user';
$pass = 'pa55word';
$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $db = new PDO($dsn, $username, $pass, $options);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    include('errors/db_error_connect.php');
    exit();
}
?>