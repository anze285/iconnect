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

      <title>iConnect</title>

      <!--Chose file-->
      <link href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/wtf-forms.css" rel="stylesheet">

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

      <!-- Search -->
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

      <!-- Icon -->
      <script src="https://kit.fontawesome.com/43b4b9f81c.js" crossorigin="anonymous"></script>

</head>

<body>
      <script>
            $(document).ready(function(e) {
                  $("#search").keyup(function() {
                        var text = $(this).val();
                        $.ajax({
                              type: 'GET',
                              url: 'search.php',
                              data: 'txt=' + text,
                              success: function(data) {
                                    if (text != '' && data != '') {
                                          $("#show_up").show();
                                          $("#show_up").html(data);
                                    } else {
                                          $("#show_up").hide();
                                    }
                              }
                        });
                  })
            });
            $(document).ready(function() {
                  $(".like").on('click', function() {
                        var post_id = $(this).data('content_id');
                        var likes = parseInt($("#likes_p" + post_id).html());
                        $.ajax({
                              url: 'like.php',
                              type: 'POST',
                              data: {
                                    post_id: post_id
                              },
                              success: function(data) {
                                    if (data == 'done') {
                                          likes = likes + 1;
                                          $("#likes" + post_id).html(likes);
                                          $("#likes_p" + post_id).html(likes);
                                          $("#like" + post_id).html('<span class="flaticon-heart1"></span>');
                                          $("#like1" + post_id).html('<span class="flaticon-heart1"></span>');
                                    } else if (data == 'done1') {
                                          likes = likes - 1;
                                          $("#likes_p" + post_id).html(likes);
                                          $("#likes" + post_id).html(likes);
                                          $("#like" + post_id).html('<span class="flaticon-heart"></span>');
                                          $("#like1" + post_id).html('<span class="flaticon-heart"></span>');
                                    }
                              }
                        })
                  });
            });
            $(document).ready(function() {
                  $(".save").on('click', function() {
                        var post_id = $(this).data('content_id');
                        $.ajax({
                              url: 'save.php',
                              type: 'POST',
                              data: {
                                    post_id: post_id
                              },
                              success: function(data) {
                                    if (data == 'done') {
                                          $("#save" + post_id).html('Saved');
                                          $("#save1" + post_id).html('Saved');
                                    } else if (data == 'done1') {
                                          $("#save" + post_id).html('Save');
                                          $("#save1" + post_id).html('Save');

                                    }
                              }
                        })
                  });
            });
            $(document).ready(function() {
                  $(".commenttext").on('click', function() {
                        var post_id = $(this).data('content_id');
                        var comment = $("#comment" + post_id).val();
                        var user = $("#username1").val();
                        var profile_pic = $("#profile_pic1").val();
                        $.ajax({
                              url: 'comment.php',
                              type: 'POST',
                              data: {
                                    post_id: post_id,
                                    comment: comment
                              },
                              success: function(data) {
                                    if (data == 'done') {
                                          //$('#commentstext' + post_id).html($('#commentstext' + post_id).html() + '<div class="mx-2"><img class="mb-1 custom-img1 mr-3" src="' + profile_pic + '" alt="profile-pic"><span class="font-weight-bolder fs-2 mt-1 fs-custom">' + user + '</span><p class="ml-3 fs-custom">' + comment + '</p></div>');
                                          $('#commentstext' + post_id).html('<div class="mx-2"><img class="mb-1 custom-img1 mr-3" src="' + profile_pic + '" alt="profile-pic"><span class="font-weight-bolder fs-2 mt-1 fs-custom">' + user + '</span><p class="ml-3 fs-custom">' + comment + '</p></div>' + $('#commentstext' + post_id).html());
                                    }
                              }
                        })
                  });
            });
      </script>
      <?php
      if (isset($_SESSION['user_id'])) {
      ?>
            <div class="bg-white navbar-custom fixed-top">
                  <nav class="navbar navbar-expand-sm navbar-light bg-light bg-white py-0">
                        <div class="ml-6">
                              <a class="navbar-brand instantgram fs-3" href="index.php">iConnect</a>
                        </div>
                        <div class="d-none d-md-block mx-auto">
                              <div class="form-inline my-2">
                                    <input class="form-control dropdown-toggle" type="text" placeholder="Search" name="names" id="search" aria-haspopup="true" aria-expanded="false">
                                    <span type="button" class="flaticon-search"></span>
                                    <div id="show_up" class="dropdown-menu left-auto dropdown-menu-right"></div>
                              </div>

                        </div>
                        <div class="navbar-customized ml-md-0 ml-auto mr-6" id="navbarSupportedContent">
                              <ul class="navbar-nav">
                                    <li class="nav-item">
                                          <a class="nav-link" href="index.php"><span class="flaticon-home"></span></a>
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