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
            <button type=submit>Save</button>
        </form>
    </section>

    <section class="editBio">
        <form action="/app/users/edit.php" method="post">
            <label for="bio">Edit your bio: </label>
            <textarea name="bio" id="bio" cols="30" rows="5"></textarea>
            <button type="submit">Save</button>
        </form>
    </section>
