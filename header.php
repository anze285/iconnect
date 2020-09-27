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

      <!-- Flaticon -->
      <link rel="stylesheet" type="text/css" href="css/flaticon.css">

      <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

      <!-- Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Yellowtail&display=swap" rel="stylesheet">

      <!-- core CSS -->
      <link href="css/style.css" rel="stylesheet">
</head>

<body>
      <?php
      if (isset($_SESSION['user_id'])) {
      ?>
            <div class="bg-white navbar-custom fixed-top">
                  <nav class="navbar navbar-expand-sm navbar-light bg-light bg-white py-0">
                        <div class="ml-6">
                              <a class="navbar-brand instantgram fs-3" href="index.php">Instantgram</a>
                        </div>
                        <div class="d-none d-md-block mx-auto">
                              <form class="form-inline my-2">
                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                                    <span class="flaticon-search"></span>
                                    <!--<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>-->
                              </form>
                        </div>
                        <div class="navbar-customized ml-md-0 ml-auto mr-6" id="navbarSupportedContent">
                              <ul class="navbar-nav">
                                    <li class="nav-item">
                                          <a class="nav-link" href="index.php"><span class="flaticon-home"></span></a>
                                    </li>
                                    <li class="nav-item">
                                          <a class="nav-link" href="#"><span class="flaticon-compass"></span></a>
                                    </li>
                                    <li class="nav-item">
                                          <a class="nav-link" href="#"><span class="flaticon-compass-1"></span></a>
                                    </li>
                                    <li class="nav-item">
                                          <a class="nav-link" href="#"><span class="flaticon-heart"></span></a>
                                    </li>
                                    <li class="nav-item">
                                          <div class="dropdown">
                                                <a class="mt-4" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                      <span class="flaticon-user profile-pic"></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                                      <a class="dropdown-item" href="profile.php">Profile</a>
                                                      <a class="dropdown-item" href="saved.php">Saved</a>
                                                      <a class="dropdown-item" href="edit_profile.php">Edit profile</a>
                                                      <div class="dropdown-divider"></div>
                                                      <a class="dropdown-item" href="sign_out.php">Log Out</a>
                                                </div>
                                          </div>
                                    </li>
                                    <!--<li class="nav-item dropdown">
                                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Dropdown
                                          </a>
                                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                          </div>
                                    </li>-->
                              </ul>
                        </div>
                  </nav>
            </div>
            <?php
            if (isAdmin()) {
            ?>
            <?php
            }
            ?>
      <?php
      } else {
      ?>

      <?php
      }
      ?>