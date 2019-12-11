<!-- This only shows the navigation bar if the user is logged in -->
<?php if (isset($_SESSION['user'])) : ?>
    <nav>
        <a href="index.php">Home</a>

        <?php if (isset($_SESSION['user'])) : ?>
            <a href="app/users/logout.php">Logout</a>
        <?php else : ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>

<?php endif; ?>