<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
if (!isset($_SESSION['user'])){
	redirect('/login.php');
};
require __DIR__.'/navbar.php';
?>

<form action="/app/users/profile.php" method="POST" enctype="multipart/form-data" class="update-form">
	<img class="avatar" src="<?= $_SESSION['user']['avatar']; ?>" alt="">
	<div class="">
		<input type="text" name="firstname" id="firstname" value="<?= $_SESSION['user']['firstname']?>" >
		<input type="text" name="lastname" id="lastname" value="<?= $_SESSION['user']['lastname']?>">
		<input type="text" name="username" id="username" value="<?= $_SESSION['user']['username']?>">
		<input type="email" name="email" id="email" value="<?= $_SESSION['user']['email']?>">
		<input type="file" name="image" id="image">
		<textarea name="description" id="description" placeholder="<?= $_SESSION['user']['description']?>"></textarea>
		<input type="password" name="password" id="password" placeholder="enter password">
		<button type="submit" class="">Update profile</button>
	</div>
</form>

<?php
require __DIR__.'/views/footer.php';
require __DIR__.'/footer.php';
?>
<iframe name="hiddenFrame" width="0" height="0" border="0" style="display: none;"></iframe>
<div class="posts-container">
</div>
<script type="text/javascript" src="assets/js/test.js"></script>
