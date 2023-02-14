<?php
require_once('util/main.php');
$css_path = $app_root . "main.css";
    //ensure each user type is directed to correct home page
if (isset($_SESSION['admin'])) {
  //     $home_path = "/A3/admin";
  $logout_url = $app_root . "admin?action=logout";
} else if (isset($_SESSION['reader'])) {
  $logout_url = $app_root . "reader?action=logout";
} 

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

<nav class="navbar navbar-expand-lg ">
  <div id="nav-div" class="container-fluid">
    <a class="navbar-brand" href=<?php echo get_home_path() ?>>Fabula</a>
    
    <!-- toggle button -->
    <button class="navbar-toggler navbar-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon navbar-dark"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
    
      <ul class="navbar-nav me-auto">

      <?php if (isset($_SESSION["admin"]) || isset($_SESSION["reader"])) : ?>

        <?php if (isset($_SESSION['admin'])) : ?>
        <li class="nav-item">
        <a class="nav-link" href=<?php echo get_home_path() ?>>home</a>
        </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['reader'])) : ?>
          <li class="nav-item">
            <a class="nav-link active"  href=<?php echo get_home_path() ?>>account</a>
          </li>
        <?php endif; ?>

        <li class="nav-item">
          <a class="nav-link" href=<?php echo $app_root . "search" ?>>library search</a>
        </li>

        <?php endif; ?>
      </ul>

      <!-- logout button -->
      <?php if (isset($_SESSION["admin"]) || isset($_SESSION["reader"])) : ?>
      <ul class="navbar-nav ms-auto">
               <!-- Show logout button if there is a session -->
               <li class="nav-item">
          <a class="nav-link" href=<?php echo $logout_url ?>>logout</a>
        </li>
      </ul>
      <?php endif; ?>
    </div>
    
  </div>
</nav>
</header>

<body>

<div id="wrap">
<main>
