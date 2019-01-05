<?php
declare(strict_types=1);
if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}
//change email to dynamic value param so we can check any key
function verifyEmail(string $email, $pdo) {
	$statement = $pdo->prepare("SELECT * FROM users WHERE email= :email");
	$statement->bindParam(':email', $email, PDO::PARAM_STR);
	$statement->execute();
	$user = $statement->fetch(PDO::FETCH_ASSOC);
	return $user;
};

function getPosts($pdo) {
	$statement = $pdo->prepare("SELECT * FROM posts, users WHERE users.id = posts.user_id ORDER BY timestamp DESC");
	$statement->execute();
	$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
	$posts = json_encode($posts);
	return $posts;
}

function getComments($pdo) {
	$statement = $pdo->prepare("SELECT * FROM comments");
	$statement->execute();
	$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
	$posts = json_encode($posts);
	return $posts;
}

function getUserPosts($id, $pdo) {
	$statement = $pdo->prepare("SELECT * FROM posts WHERE user_id= :user_id ORDER BY timestamp DESC");
	$statement->bindParam(':user_id', $id, PDO::PARAM_STR);
	$statement->execute();
	$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
	$posts = json_encode($posts);
	return $posts;
}
