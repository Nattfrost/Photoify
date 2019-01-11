<?php

declare(strict_types=1);

require __DIR__.'/../../views/header.php';

if (isset($_POST['deletePost'])) {
    
    $postId = $_COOKIE['delete'];

    $statement = $pdo->prepare('DELETE FROM posts WHERE post_id = :post_id');

    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);

    $statement->execute();

    if (!$statement)
    {
        die(var_dump($pdo->errorInfo()));
    };

    redirect('/');
};
