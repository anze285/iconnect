<?php
include_once('session.php');
$id = $_POST['id'];

if(!empty($id)){
    if ($id == $_SESSION['user_id']) {
        header("Location: profile.php");
    }
    else {
        $_SESSION['profile_id'] = $id;
        header("Location: profile_visit.php");
    }
    
}
else{
    header("Location: index.php");
}
?>