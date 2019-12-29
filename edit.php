<?php require __DIR__ . '/views/header.php' ?>
<?php $user = getUserById($_SESSION['user']['id'], $pdo); ?>


<?php if (isset($_SESSION['errors'][0])) : ?>
    <?php displayError(); ?>
<?php endif; ?>

<section class="editContainer">
    <section class="editAvatar">
        <div class="avatarContainer">
            <?php if (isset($user['avatar'])) : ?>
                <img class="avatar" src="app/avatar/<?= $user['avatar'] ?>">
            <?php else : ?>
                <img class="avatar" alt="user avatar" src="https://t4.ftcdn.net/jpg/00/64/67/27/240_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg" loading="lazy">
            <?php endif; ?>
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
            <?php if (isset($user['bio'])) : ?>
                <textarea name="bio" id="bio" cols="30" rows="5" maxlength="180"><?= $user['bio'] ?></textarea>
            <?php else : ?>
                <textarea name="bio" id="bio" cols="30" rows="5" maxlength="180"></textarea>
            <?php endif; ?>
            <button type="submit">Save</button>
        </form>
    </section>
</section>

<section class="profileInformation">
    <h1>Profile Information</h1>
    <form action="/app/users/edit.php" method="post">

        <label for="changeName">Name: </label>
        <input type="text" name="changeName" id="changeName" placeholder="<?= $user['name'] ?>" required>

        <button type="submit">Save</button>

    </form>

    <form action="/app/users/edit.php" method="post">

        <label for="changeEmail">Email: </label>
        <input type="text" name="changeEmail" id="changeEmail" placeholder="<?= $user['email'] ?>" required>

        <button type="submit">Save</button>

    </form>
</section>