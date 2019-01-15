<?php
declare(strict_types=1);


require __DIR__.'/../autoload.php';

$posts = getPosts($pdo);

echo json_encode($posts);