<?php
declare(strict_types=1);
require __DIR__.'/../../views/header.php';
 if (isset($_POST['comment'])) {
             $postId = $_COOKIE['postId'];
             $userId = $_SESSION['user']['id'];
             print_r($_COOKIE['postId']);
             $content = filter_var(trim($_POST['comment']), FILTER_SANITIZE_STRING);
             $created_at = date("Y-m-d");
             $author = $_SESSION['user']['username'];
             $statement = $pdo->prepare('INSERT INTO comments (post_id, user_id, content, created_at, author)
             VALUES (:post_id, :user_id, :content, :created_at, :author)');

             if (!$statement)
             {
                 die(var_dump($pdo->errorInfo()));
             };

             $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
             $statement->bindParam(':author', $author, PDO::PARAM_STR);
             $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
             $statement->bindParam(':content', $content, PDO::PARAM_STR);
             $statement->bindParam(':created_at', $created_at, PDO::PARAM_STR);

             $statement->execute();

             $comments = $statement->fetch(PDO::FETCH_ASSOC);

         };
