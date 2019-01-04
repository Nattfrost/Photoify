<?php
declare(strict_types=1);
require __DIR__.'/../../views/header.php';

 if (isset($_POST['like'])) {
	 $current_id = $_COOKIE['like'];
	 $statement = $pdo->prepare('SELECT no_likes FROM posts WHERE post_id = :current_id');
	 $statement->bindParam(':current_id', $current_id, PDO::PARAM_INT);
	 $statement->execute();
	 $likes = $statement->fetch(PDO::FETCH_ASSOC);

	 $statement = $pdo->prepare('UPDATE posts SET no_likes = :no_likes WHERE post_id = :current_id');
	 $no_likes = $likes['no_likes'] + 1;
	 $statement->bindParam(':current_id', $current_id, PDO::PARAM_INT);
	 $statement->bindParam(':no_likes', $no_likes, PDO::PARAM_INT);
	 $statement->execute();

	 $current_id = $_COOKIE['like'];
	 $statement = $pdo->prepare('SELECT no_likes FROM posts WHERE post_id = :current_id');
	 $statement->bindParam(':current_id', $current_id, PDO::PARAM_INT);
	 $statement->execute();
	 $updated_likes = $statement->fetch(PDO::FETCH_ASSOC);
	 var_dump($updated_likes);

 }
?>
