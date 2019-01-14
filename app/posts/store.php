<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we store/insert new posts in the database.

if(isset($_FILES['image'])) {
	$image = $_FILES['image'];
	$created_at = date("Y-m-d");
	$desc = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)) ?? '';
	$errors = [];
	
	$timestamp = date("Y-m-d");
	if($image['size'] >= 4194304) {
		$errors[] = $image['name'] . ' Is too big, please choose an image that\'s smaller than 4mb';
	}

	if (!file_exists(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/posts/')) {
		mkdir(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/posts/', 0777, true);
	}

	if(count($errors) > 0) {
		$_SESSION['errors'] = $errors;
		print_r($errors);
		exit;
	}

	if (!file_exists(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/posts/')) {
		mkdir(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/posts/', 0777, true);
	}

	$destination = '/../uploads/' . $_SESSION['user']['id']  . '/posts/' . time() . '-' . $image['name'];
	move_uploaded_file($image['tmp_name'], __DIR__.$destination);
	$destination = '/app/uploads/' . $_SESSION['user']['id'] . '/posts/' . time() . '-' . $image['name'];

	$statement = $pdo->prepare('INSERT INTO posts (user_id, description, tags, image, created_at, timestamp)
	VALUES (:user_id, :description, :tags, :image, :created_at, :timestamp)');
	$statement->bindParam(':user_id', $_SESSION['user']['id'], PDO::PARAM_INT);
	$statement->bindParam(':description', $desc, PDO::PARAM_STR);
	$statement->bindParam(':tags', $tags, PDO::PARAM_STR);
	$statement->bindParam(':image', $destination, PDO::PARAM_STR);
	$statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);
	$statement->bindParam(':timestamp', $timestamp, PDO::PARAM_STR);
	$statement->execute();

	if(!$statement){
		die(var_dump($statement->errorInfo()));
	}
redirect('/home.php');
}
