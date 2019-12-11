<?php require __DIR__ . '/views/header.php' ?>

<?php if (isset($_SESSION['errors'][0])) : ?>
    <?php displayError(); ?>
<?php endif; ?>

<section class="editAvatar">
    <div class="avatarContainer">
        <img class="avatar" src="/app/avatar/avatar.jpeg">
    </div>
    <form action="/app/users/edit.php" method="post" enctype="multipart/form-data">
        <label for="avatar">Change profile picture</label>
        <input style="visibility:hidden;" type="file" name="avatar" id="avatar" required accept="image/jpeg, image/jpg">
        <button type=submit>Confirm</button>