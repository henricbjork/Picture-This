<?php require __DIR__ . '/views/header.php' ?>

<?php authenticateUser(); ?>

<section class="profilePictureHeader">
    <div class="avatarContainer">
        <img class="avatar" src="app/avatar/<?= $_SESSION['user']['avatar']?>">
    </div>
</section>
<section class="bioContainer">
    <p><?= $_SESSION['user']['bio'] ?><p>
</section>

<?php require __DIR__ . '/views/footer.php' ?>