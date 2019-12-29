<?php require __DIR__ . '/views/header.php' ?>

<?php authenticateUser(); ?>

<?php if (isset($_SESSION['errors'][0])) : ?>
    <p><?php displayError(); ?></p>
<?php endif; ?>

<section class="changePasswordContainer">
    <h1>Change Password</h1>
    <form action="app/users/settings.php" method="post">
        <label for="currentPassword">Current Password: </label><br>
        <input type="password" name="currentPassword" id="currentPassword" required><br>
        <label for="newPassword">New Password: </label><br>
        <input type="password" name="newPassword" id="newPassword" required><br>
        <button type="submit">Save</button>
    </form>
</section>

<?php require __DIR__ . '/views/footer.php' ?>