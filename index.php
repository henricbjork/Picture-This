<?php require __DIR__ . '/views/header.php' ?>

<h1>Welcome</h1>

<?php if (isset($_SESSION['user'])) : ?>
    <p>Welcome, <?php echo $_SESSION['user']['name']; ?>!</p>

    <?php else: ?>

    <p>Welcome to the home page.</p>
    
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php' ?>