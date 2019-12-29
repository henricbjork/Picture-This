<?php if (isset($_SESSION['user'])) : ?>

    <div class="settings">
        <a href="/settings.php">Account Settings</a>
        <a href="/../app/users/logout.php">Logout</a>
    </div>

<?php endif; ?>