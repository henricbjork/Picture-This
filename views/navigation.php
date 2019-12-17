<!-- This only shows the navigation bar if the user is logged in -->
<?php if (isset($_SESSION['user'])) : ?>

    <nav>
        <?php if ($currentUrl === '/profile.php') : ?>
            <a href="/index.php">Back</a>
        <?php elseif ($currentUrl === '/edit.php') : ?>
            <a href="/profile.php">Back</a>
        <?php elseif ($currentUrl === '/settings.php') : ?>
            <a href="/profile.php">Back</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['user']) && $currentUrl === '/profile.php') : ?>
            <img class="settingsButton" src="/icons/settings.svg">
        <?php endif; ?>
    </nav>

    <div class="settings">
        <a href="/settings.php">Account Settings</a>
        <a href="/../app/users/logout.php">Logout</a>
    </div>

<?php endif; ?>