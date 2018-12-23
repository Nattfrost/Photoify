<?php declare(strict_types=1);
$current_page = 'Register'
?>

<div class="form-container">


<form class="register-form" action="app/users/register.php" method="post">
	<input type="text" name="firstname"  placeholder="firstname" required>
	<input type="text" name="lastname"  placeholder="lastname" required>
	<input type="text" name="username"  placeholder="username" required>
	<input type="email" name="email"  placeholder="email" required>
	<input type="password" name="password"  placeholder="password" required>
	<input type="password" name="confirmpassword"  placeholder="confirmpassword" required>
	<button type="submit" name="button">sign up!</button>
</form>
</div>
