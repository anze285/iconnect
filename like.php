<?php
include_once('session.php');
include_once('database.php');

$id = $_POST['post_id'];
if(!empty($id)){
    $query = "SELECT user_id, post_id FROM likes WHERE user_id = ? AND post_id=?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['user_id'], $id]);
    if($stmt->rowCount() == 0){
        $query = "INSERT INTO likes(date, user_id, post_id) VALUES (CURRENT_TIMESTAMP(), ?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user_id'], $id]);
        echo "done";
    }
    else{
        $query = "DELETE FROM likes WHERE user_id = ? AND post_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user_id'], $id]);
        echo "done1";
    }
}
else{
}
?>