<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
require __DIR__.'/navbar.php';
?>

<h1>post</h1>

<form action="/app/posts/store.php" method="POST" enctype="multipart/form-data" class="post-form">
<input class="file-input" type="file"  onchange="previewFile()" name="image" id="image" type="file" multiple="">
        <br>
        <img class="previewimage" src="" height="150" alt="Image preview...">
	<textarea name="description" id="description" placeholder="description"></textarea>
	<textarea name="tags" id="tags" placeholder="add tags"></textarea>
	<button type="submit" class="">Submit Toast</button>
</form>


<?php
require __DIR__.'/views/footer.php';
require __DIR__.'/footer.php';
?>
