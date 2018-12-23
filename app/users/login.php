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

    $users = $statement->fetch(PDO::FETCH_ASSOC);

    $dbPassword = $users['password'];

    // checks if given password is equal to password in db
    if (password_verify($password, $dbPassword))
    {
        $_SESSION['user'] = [
            'id' => $users['id'],
            'name' => $users['first_name'],
            'username' => $users['username']
        ];
        redirect('/');

    }

        $_SESSION['error'] = "wrong password!";

redirect('/../login.php');
}
