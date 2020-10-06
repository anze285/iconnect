<?php
include_once('session.php');
include_once('database.php');
$id = $_POST['id'];
if (!empty($id)) {
    $query = "DELETE FROM likes WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $query = "DELETE FROM comments WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $query = "DELETE FROM saved_posts WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $query = "SELECT id FROM posts WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    while($posts= $stmt->fetch()){
        $query = "DELETE FROM images WHERE post_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$posts['id']]);
        $query = "DELETE FROM comments WHERE post_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$posts['id']]);
        $query = "DELETE FROM likes WHERE post_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$posts['id']]);
        $query = "DELETE FROM saved_posts WHERE post_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$posts['id']]);
    }
    $query = "DELETE FROM posts WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $query = "DELETE FROM followers WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $query = "DELETE FROM followers WHERE follower_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

} else {
}
header("Location: index.php");
