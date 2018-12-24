<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// checks if the user data is posted
if (isset($_POST['username'], $_POST['password'])) {

    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    // fetches user information from db if username exists
    $statement = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $dbPassword = $user['password'];

    // checks if given password is equal to password in db
    if (password_verify($password, $dbPassword))
    {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['first_name'],
            'username' => $user['username'],
			'email' => $user['email'],
			'password' => $user['password'],
			'avatar' => $user['avatar'],
			'description' => $user['description']
        ];
        redirect('/index.php');

    }	else {
			//not working??
        $_SESSION['error'] = "wrong password!";
}
redirect('/../login.php');
}
