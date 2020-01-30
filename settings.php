<?php require __DIR__ . '/views/header.php' ?>

<?php authenticateUser(); ?>

<?php if (isset($_SESSION['errors'][0])) : ?>
    <div class="errorContainer">
        <p class="errorMessage"><?php displayError(); ?></p>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['messages'][0])) : ?>
    <div class="messageContainer">
        <p class="message"><?php displayMessage(); ?></p>
    </div>
<?php endif; ?>

<section class="changePasswordContainer">
    <h1>Change Password</h1>
    <form action="app/users/settings.php" method="post">
        <label for="currentPassword">Current Password: </label><br>
        <input type="password" name="currentPassword" id="currentPassword" required><br>
        <label for="newPassword">New Password: </label><br>
        <input type="password" name="newPassword" id="newPassword" required><br>
        <button class="passwordChangeButton" type="submit">Save</button>
    </form>
</section>

<section class="changePasswordContainer">
    <h1>Delete Account</h1>
    <form action="app/users/deleteAccount.php" method="post">
        <input type="hidden" name="id" value="<?php echo $_SESSION['user']['id']; ?>">
        <button class="passwordChangeButton" type="submit">Delete Account</button>
    </form>
</section>

<?php require __DIR__ . '/views/footer.php' ?>
