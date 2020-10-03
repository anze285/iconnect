<?php
include_once('session.php');
include_once('database.php');

$id = $_POST['post_id'];
$redirect = $_POST['redirect'];
if(!empty($id) AND !empty($redirect)){
    $query = "SELECT user_id, post_id FROM saved_posts WHERE user_id = ? AND post_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id'], $id]);
    if($stmt->rowCount() == 0){
        $query = "INSERT INTO saved_posts(date, user_id, post_id) VALUES (CURRENT_TIMESTAMP(), ?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user_id'], $id]);
    }
    else{
        $query = "DELETE FROM saved_posts WHERE user_id = ? AND post_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user_id'], $id]);
    }
    header("Location: index.php#".$redirect);
}
else{
    header("Location: index.php");
}
