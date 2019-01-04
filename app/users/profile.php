<?php

declare(strict_types=1);



require __DIR__.'/../autoload.php';
$id = (int) $_SESSION['user']['id'];
$statement = $pdo->prepare('SELECT * FROM users WHERE id = :user_id');
$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
if(isset($_POST['password'])) {
	$firstname = ($_POST['firstname']) ? trim(filter_var($_POST['firstname'], FILTER_SANITIZE_STRING)) : $user['first_name'];
	$lastname = ($_POST['lastname']) ? trim(filter_var($_POST['lastname'], FILTER_SANITIZE_STRING)) : $user['last_name'];
	$username = ($_POST['username']) ? trim(filter_var($_POST['username'] , FILTER_SANITIZE_STRING)) : $user['username'];
	$email = ($_POST['email']) ? trim(filter_var($_POST['email'] , FILTER_SANITIZE_EMAIL)) : $user['email'];
	$image = ($_FILES['image']) ? $_FILES['image'] : $user['avatar'];
	$bio = ($_POST['bio']) ? trim(filter_var($_POST['bio'], FILTER_SANITIZE_STRING)) : $user['bio'];
	$password = $_POST['password'];
	$errors = [];

	if($image['size'] >= 4194304) {
		$errors[] = $image['name'] . ' Is too big, please choose an image that\'s smaller than 4mb';
	}

	if(!password_verify($password, $_SESSION['user']['password'])) {
		$errors[] = 'Wrong Password!';
	}

	if (!file_exists(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/profile_pictures/')) {
		mkdir(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/profile_pictures/', 0777, true);
	}

	if (verifyEmail($email, $pdo)){
		if ($email === $_SESSION['user']['email']) {
			// code...
		} else {
	$errors[] = 'Email is taken';
		}
	};

	if(count($errors) > 0) {
      $_SESSION['errors'] = $errors;
      print_r($errors);
      exit;
    }

	$destination = '/../uploads/' . $_SESSION['user']['id'] . '/profile_pictures/' . time() . '-' . $image['name'];
	move_uploaded_file($image['tmp_name'], __DIR__.$destination);
	$destination = '/app/uploads/' . $_SESSION['user']['id'] . '/profile_pictures/' . time() . '-' . $image['name'];


	$statement = $pdo->prepare('UPDATE users SET first_name = :firstname, last_name = :lastname, username = :username, email = :email, bio = :bio, avatar = :avatar WHERE id = :user_id');
	if(!$statement) {
		die(var_dump($pdo->errorInfo()));
	}
	$statement->bindParam(':user_id', $id, PDO::PARAM_INT);
	$statement->bindParam(':firstname', $firstname, PDO::PARAM_STR);
	$statement->bindParam(':lastname', $lastname, PDO::PARAM_STR);
	$statement->bindParam(':username', $username, PDO::PARAM_STR);
	$statement->bindParam(':email', $email, PDO::PARAM_STR);
	$statement->bindParam(':bio', $bio, PDO::PARAM_STR);
	$statement->bindParam(':avatar', $destination, PDO::PARAM_STR);
	$statement->execute();

	if(!$statement){
		die(var_dump($statement->errorInfo()));
	}
}

redirect('logout.php');
