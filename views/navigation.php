<!-- This only shows the navigation bar if the user is logged in -->
<?php if (isset($_SESSION['user'])) : ?>

    <nav>
        <h1>Kindagram</h1>
        <a href="/search.php"><img class="searchIcon" src="/icons/search.svg" alt="search icon"></a>
    </nav>

    <div class="settings">
        <a href="/settings.php">Account Settings</a>
        <a href="/../app/users/logout.php">Logout</a>
    </div>

<?php endif; ?>