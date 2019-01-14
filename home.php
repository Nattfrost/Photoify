<?php
declare(strict_types=1);
require __DIR__.'/views/header.php';
require __DIR__.'/navbar.php';
?>
<?php getPosts($pdo)?>

<div class="posts-container">

</div>



<?php require __DIR__.'/footer.php';?>
<script type="text/javascript" src="assets/js/test.js"></script>

<?php require __DIR__.'/views/footer.php';?>
<iframe name="hiddenFrame" width="0" height="0" border="0" style="display: none;"></iframe>