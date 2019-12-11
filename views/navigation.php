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

    <div class="bottomNav">
        <a href="index.php">Feed</a>
        <a href="#">New Photo</a>
        <a href="/profile.php">Profile</a>
    </div>

<?php endif; ?>