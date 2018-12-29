<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
require __DIR__.'/navbar.php';
?>

<h1>post</h1>

<form action="/app/posts/store.php" method="POST" enctype="multipart/form-data" class="post-form">
	<input type="file" name="image" id="image">
	<textarea name="description" id="description" placeholder="description"></textarea>
	<textarea name="tags" id="tags" placeholder="add tags"></textarea>
	<button type="submit" class="">submit post</button>
</form>


<?php
require __DIR__.'/views/footer.php';
require __DIR__.'/footer.php';
?>
