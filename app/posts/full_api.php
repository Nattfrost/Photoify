<?php
declare(strict_types=1);
require __DIR__.'/../autoload.php';

$all = [];
$posts = json_decode(getPosts($pdo));
$comments = json_decode(getComments($pdo));

array_push($posts, $comments);


echo json_encode($posts);
