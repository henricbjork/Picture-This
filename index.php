<?php require __DIR__ . '/views/header.php' ?>

<section class="startPage">

    <?php if (isset($_SESSION['user'])) : ?>

        <p>This is the feed.</p>

    <?php else : ?>

        <p>You need to <a href="/login.php">log in<a> to see this.</p>

    <?php endif; ?>

</section>

<?php require __DIR__ . '/views/footer.php' ?>