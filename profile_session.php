<?php
include_once('session.php');
$id = $_POST['id'];
if(!empty($id)){
    $_SESSION['profile_id'] = $id;
    header("Location: profile_visit.php");
}
else{
    header("Location: index.php");
}
?>