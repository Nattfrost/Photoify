<?php $current_page = 'Photoify'; require __DIR__.'/views/header.php'; ?>
<?php require __DIR__.'/navbar.php'; ?>
<!--  TODO implement if statement for checking if USER session is active and require-->
<?php if (!isset($_SESSION['user'])): ?>
<?php redirect('/login.php'); ?>

<?php endif; ?>
<?php if (isset($_SESSION['user'])): ?>
	<p>Welcome, <?php echo $_SESSION['user']['name']?>!</p>
<?php endif; ?>
<?php require __DIR__.'/views/footer.php'; ?>
<?php require __DIR__.'/footer.php'; ?>
