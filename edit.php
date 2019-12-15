<?php require __DIR__ . '/views/header.php' ?>


<?php if (isset($_SESSION['errors'][0])) : ?>
    <?php displayError(); ?>
<?php endif; ?>

<section class="editContainer">
    <section class="editAvatar">
        <div class="avatarContainer">
            <img class="avatar" src="app/avatar/<?= $_SESSION['user']['avatar'] ?>">
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
            <textarea name="bio" id="bio" cols="30" rows="5"><?= $_SESSION['user']['bio'] ?></textarea>
            <button type="submit">Save</button>
        </form>
    </section>
</section>

<section class="profileInformation">
    <h1>Profile Information</h1>
    <form action="/app/users/edit.php" method="post">

        <label for="changeName">Name: </label>
        <input type="text" name="changeName" id="changeName" placeholder="<?= $_SESSION['user']['name'] ?>" required>

        <button type="submit">Save</button>

    </form>

    <form action="/app/users/edit.php" method="post">

        <label for="changeEmail">Email: </label>
        <input type="text" name="changeEmail" id="changeEmail" placeholder="<?= $_SESSION['user']['email'] ?>">

        <button type="submit">Save</button>

    </form>
</section>