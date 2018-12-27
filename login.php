<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
require __DIR__.'/navbar.php';
require __DIR__.'/views/footer.php';

?>
<form class="login-form" action="app/users/login.php" method="post">
	<input type="text" name="username" placeholder="username">
	<input type="password" name="password" placeholder="password">
	<button type="submit" name="button">login</button>
</form>


<!-- add register here redirect -->

<form class="" action="register.php" method="post">
	<button type="submit" >Register</button>
</form>
