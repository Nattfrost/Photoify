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
	$statement = $pdo->prepare("SELECT * FROM posts");
	$statement->execute();
	$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
	$cookieData = json_encode($posts);
	$cookieName = "posts";
	setcookie($cookieName, $cookieData);
	return $posts;
}

function getUserPosts($id, $pdo) {
	$statement = $pdo->prepare("SELECT * FROM posts WHERE user_id= :user_id");
	$statement->bindParam(':user_id', $id, PDO::PARAM_STR);
	$statement->execute();
	$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
	$cookieData = json_encode($posts);
	$cookieName = "userPosts";
	setcookie($cookieName, $cookieData);
	return $posts;
}
