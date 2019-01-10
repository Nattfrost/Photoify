<?php
declare(strict_types=1);
require __DIR__.'/../../views/header.php';

 if (isset($_POST['like']) || isset($_POST['dislike'])) {
     $current_id = $_COOKIE['like'];
     $userId = $_SESSION['user']['id'];
	 $statement = $pdo->prepare('SELECT no_likes FROM posts WHERE post_id = :current_id');
	 $statement->bindParam(':current_id', $current_id, PDO::PARAM_INT);
	 $statement->execute();
	 $likes = $statement->fetch(PDO::FETCH_ASSOC);
     
	 $statement = $pdo->prepare('UPDATE posts SET no_likes = :no_likes WHERE post_id = :current_id');
     
     $no_likes = $likes['no_likes']+1;
     $hasLiked = 1;
     
     if (isset($_POST['dislike'])) {

         $no_likes = $likes['no_likes']-1;

     }
     
     $statement->bindParam(':current_id', $current_id, PDO::PARAM_INT);
	 $statement->bindParam(':no_likes', $no_likes, PDO::PARAM_INT);
	 $statement->execute();
     
     $likes = $statement->fetch(PDO::FETCH_ASSOC);
     
     $statement = $pdo->prepare('SELECT no_likes FROM posts WHERE post_id = :current_id');
     $statement->bindParam(':current_id', $current_id, PDO::PARAM_INT);
     $statement->execute();
     $updated_likes = $statement->fetch(PDO::FETCH_ASSOC);
     

     $statement = $pdo->prepare('INSERT INTO likes (has_liked, post_id, user_id) VALUES (:has_liked, :post_id, :user_id)');
     
     $statement->bindParam(':has_liked', $hasLiked, PDO::PARAM_INT);
     $statement->bindParam(':post_id', $current_id, PDO::PARAM_INT);
     $statement->bindParam(':user_id', $userId, PDO::PARAM_STR);
     $statement->execute();

     if (isset($_POST['dislike'])) {
        $current_id = $_COOKIE['like'];

        $statement = $pdo->prepare('DELETE FROM likes WHERE post_id = :current_id');
        $statement->bindParam(':current_id', $current_id, PDO::PARAM_INT);
        $statement->execute();
    }
     
 }

?>