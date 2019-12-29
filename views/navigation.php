<!-- This only shows the navigation bar if the user is logged in -->
<?php if (isset($_SESSION['user'])) : ?>

    <nav>
        <a href="search.php">Search</a>
    </nav>

    <div class="settings">
        <a href="/settings.php">Account Settings</a>
        <a href="/../app/users/logout.php">Logout</a>
    </div>
    
<?php endif; ?>