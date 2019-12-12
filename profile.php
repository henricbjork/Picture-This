<?php require __DIR__ . '/views/header.php' ?>

<?php authenticateUser(); ?>


<section class="profilePictureHeader">
    <div class="avatarContainer">
        <img class="avatar" src="/app/avatar/avatar.jpeg">
    </div>
</section>

<?php require __DIR__ . '/views/footer.php' ?>