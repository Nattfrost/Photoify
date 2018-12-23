<?php

declare(strict_types=1);
require __DIR__.'/../autoload.php';
die(var_dump($_SESSION['user']));

$id = (int) $_SESSION['user']['id'];
$statement = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

// POST ROUTE TO PROFILE
if(isset($_POST['password'])) {
	$name = ($_POST['name']) ? trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)) : $user['name'];
	$username = ($_POST['username']) ? trim(filter_var($_POST['username'] , FILTER_SANITIZE_STRING)) : $user['username'];
	$image = ($_FILES['image']) ? $_FILES['image'] : $user['avatar'];
	$desc = ($_POST['description']) ? trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)) : $user['description'];
	$password = $_POST['password'];
	$errors = [];
	if($image['size'] >= 3145728) {
		$errors[] = 'The uploaded file '. $image['name'] . ' exceeded the filsize limit';
	}

	if(!password_verify($password, $_SESSION['user']['password'])) {
		$errors[] = 'Wrong Password!';

	}
	if(count($errors) > 0) {
		$_SESSION['errors'] = $errors;
		print_r($errors);
		exit;
	}

	// Create a new folder if the user doesnt have one.
	if (!file_exists(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/profile_pictures/')) {
		mkdir(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/profile_pictures/', 0777, true);
	}

	$destination = '/../uploads/' . $_SESSION['user']['id'] . '/profile_pictures/' . time() . '-' . $image['name'];
	move_uploaded_file($image['tmp_name'], __DIR__.$destination);

	// Set the $destination variable to be stored in the DB.
	$destination = '/app/uploads/' . $_SESSION['user']['id'] . '/profile_pictures/' . time() . '-' . $image['name'];

	$statement = $pdo->prepare('UPDATE users SET name = :name, username = :username, description = :description, avatar = :avatar WHERE id = :user_id');
	if(!$statement) {
		die(var_dump($pdo->errorInfo()));
	}
	$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
	$statement->bindParam(':name', $name, PDO::PARAM_STR);
	$statement->bindParam(':username', $username, PDO::PARAM_STR);
	$statement->bindParam(':description', $desc, PDO::PARAM_STR);
	$statement->bindParam(':avatar', $destination, PDO::PARAM_STR);
	$statement->execute();

	if(!$statement){
		die(var_dump($statement->errorInfo()));
	}
}


//route
redirect('/profile.php');
