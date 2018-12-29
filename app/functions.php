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

//
//
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
// $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM users WHERE username=?");
// $stmt->execute(array($username));
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//   $username_count = $row["count"];
// }
// if ($username_count > 0) {
//   $errors[] = "That username is already taken";
// }
//
// $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM users WHERE email=?");
// $stmt->execute(array($email));
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//   $email_count = $row["count"];
// }
// if ($email_count > 0) {
//   $errors[] = "That email address is already in use";
// }
