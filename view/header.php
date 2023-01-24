<?php
require_once('util/main.php');
$css_path = $app_root . "main.css";
    // //ensure each user type is directed to correct home page
    // if(isset($_SESSION['admin'])) {
    //     $home_path = "/A3/admin";
    // } else if (isset($_SESSION['technician'])) {
    //     $home_path = "/A3/technician";
    // } else if (isset($_SESSION['customer'])) {
    //     $home_path = "/A3/customer";
    // } else {
    //     $home_path = "/A3";
    // }


?>

<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Fabula Digital Library</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href=<?php echo $css_path ?>>
  </head>

<!-- the body section -->
<header>
  <!-- show nav bar, showing different buttons for different users-->

<nav class="navbar navbar-expand-lg navbar-light ">
  <div id="nav-div" class="container-fluid">
    <a class="navbar-brand" href="#">Fabula</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <?php if (isset($_SESSION['admin'])) : ?>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active"  href="#">account</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">library search</a>
        </li>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</nav>
</header>

<body>

<div id="wrap">
<main>
