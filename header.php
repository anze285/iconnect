<?php
include_once './session.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Instantgram</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet"></link>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

</head>

<body>
            <?php
                if (isset($_SESSION['user_id'])) {
            ?>
          <?php
                if (isAdmin()) {
            ?>
          <?php
                }                
          ?>
          <?php
                }
                else {
          ?>
          
          <?php
                }
          ?>