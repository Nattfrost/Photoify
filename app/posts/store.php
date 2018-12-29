<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';
// In this file we store/insert new posts in the database.

if(isset($_FILES['image'])) {
  $image = $_FILES['image'];
	$desc = trim(filter_var($_POST['description'], FILTER_SANITIZE_STRING)) ?? '';
  	$errors = [];

	if($image['size'] >= 4194304) {
		$errors[] = $image['name'] . ' Is too big, please choose an image that\'s smaller than 4mb';
	}

	if(!password_verify($password, $_SESSION['user']['password'])) {
		$errors[] = 'Wrong Password!';
	}

	if (!file_exists(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/posts/')) {
		mkdir(__DIR__ .'/../uploads/' . $_SESSION['user']['id'] . '/posts/', 0777, true);
	}

	if(count($errors) > 0) {
      $_SESSION['errors'] = $errors;
      print_r($errors);
      exit;
    }

	$destination = '/../uploads/' . $_SESSION['user']['id'] . '/posts/' . time() . '-' . $image['name'];
	move_uploaded_file($image['tmp_name'], __DIR__.$destination);
	$destination = '/app/uploads/' . $_SESSION['user']['id'] . '/posts/' . time() . '-' . $image['name'];

}
// $statement
// redirect('/');
