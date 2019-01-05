<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
require __DIR__.'/navbar.php';
require __DIR__.'/views/footer.php';
require __DIR__.'/footer.php';
?>
<?php getPosts($pdo)?>

<div class="posts-container">

</div>
<iframe name="hiddenFrame" width="0" height="0" border="0" style="display: none;"></iframe>
<script type="text/javascript" src="assets/js/profile.js">

</script>
