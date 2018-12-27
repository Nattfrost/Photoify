<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
if (!isset($_SESSION['user'])){
	redirect('/login.php');
};
require __DIR__.'/navbar.php';
?>


<form action="/app/users/profile.php" method="POST" enctype="multipart/form-data" class="">
	<img class="avatar" src="<?= $_SESSION['user']['avatar'];?>" alt="">
	<div class="">
		<input type="text" name="firstname" id="firstname" class="" placeholder="Your first name..">
		<input type="text" name="lastname" id="lastname" class="" placeholder="Your last name..">
		<input type="text" name="username" id="username" class="" placeholder="Your username..">
		<input type="file" name="image" id="image" class="">
		<textarea name="description" id="description" class="" placeholder="Write something about yourself"></textarea>
		<input type="password" name="password" id="password" class="" placeholder="Enter your password..">
		<button type="submit" class="">Update profile</button>
	</div>
</form>

<?php
require __DIR__.'/views/footer.php';
require __DIR__.'/footer.php';
?>
