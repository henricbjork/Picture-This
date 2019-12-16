<?php require __DIR__ . '/views/header.php' ?>

<?php authenticateUser(); ?>

<section class="profileContainer">
    <div class="avatarContainer">
        <?php if (!isset($_SESSION['user']['avatar'])) : ?>
            <img class="avatar" src="https://t4.ftcdn.net/jpg/00/64/67/27/240_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg">
        <?php endif; ?>
        <img class="avatar" src="app/avatar/<?= $_SESSION['user']['avatar'] ?>">
    </div>
    <div class="userName">
        <h1><?= $_SESSION['user']['name'] ?></h1>
    </div>
    <section class="bioContainer">
        <p><?= $_SESSION['user']['bio'] ?><p>
    </section>
    <section class="editProfile">
        <button><a href="/edit.php">Edit Profile</a></button>
    </section>
</section>


<?php require __DIR__ . '/views/footer.php' ?>