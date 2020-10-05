<?php
include_once('session.php');
include_once('database.php');

$id = $_POST['post_id'];
$comment = $_POST['comment'];
$comment = str_replace("<", "", $comment);
$comment = str_replace(">", "", $comment);
if(!empty($id) && !empty($comment)){
        $query = "INSERT INTO comments(date, user_id, post_id, message) VALUES (CURRENT_TIMESTAMP(), ?,?,?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$_SESSION['user_id'], $id, $comment]);
        echo "done";
}
else{
}
