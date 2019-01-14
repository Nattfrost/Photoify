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
	$statement = $pdo->prepare("SELECT posts.*, users.username, users.id, users.avatar, users.created_at, likes.has_liked FROM posts 
	LEFT JOIN likes ON posts.post_id = likes.post_id AND likes.user_id = :user_id
	INNER JOIN users ON posts.user_id = users.id
	WHERE users.id = posts.user_id
	ORDER BY timestamp DESC");
	$statement->bindParam(':user_id', $_SESSION['user']['id']);
    $statement->execute();
	$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare("SELECT * FROM posts, comments WHERE comments.post_id = posts.post_id");
    $statement->execute();
	$comments = $statement->fetchAll(PDO::FETCH_ASSOC);
	

	foreach ($posts as &$post) {
		$post['comments'] = array_filter($comments, function ($comment) use ($post) {

			return $comment['post_id'] === $post['post_id'];

		});
		$post['comments'] = array_values($post['comments']);
	}

	return $posts;
};



// function getComments($pdo) {
//     $statement = $pdo->prepare("SELECT * FROM comments, posts WHERE comments.post_id = posts.post_id");
//     $statement->execute();
//     $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
//     return $comments;
// }

// TODO
// merge getComments with getPosts
// rewrite sql within get Posts to flter data
// only get the data we want to display ie onlhy 10 posts for frontpage and only user data for profile.
// rewrite JS to work with whatever data it recieves (assume data from server is correct)
// dont filter in js.


