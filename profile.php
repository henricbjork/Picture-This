<?php require __DIR__ . '/views/header.php' ?>


<?php
authenticateUser();
$user = getUserById($_SESSION['user']['id'], $pdo);
$posts = getPostsById($_SESSION['user']['id'], $pdo);
?>

<section class="profileContainer">
    <div class="avatarContainer">
        <?php if (!$user['avatar']) : ?>
            <img class="avatar" src="https://t4.ftcdn.net/jpg/00/64/67/27/240_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg">
        <?php endif; ?>
        <img class="avatar" src="app/avatar/<?= $user['avatar'] ?>">
    </div>
    <div class="userName">
        <h1><?= $user['name'] ?></h1>
    </div>
    <section class="bioContainer">
        <p><?= $user['bio'] ?><p>
    </section>
    <section class="editProfile">
        <button><a href="/edit.php">Edit Profile</a></button>
    </section>
</section>

<?php foreach ($posts as $post) : ?>
    <section class="uploadContainer">
        <div class="author">
            <div class="authorImage">
                <img src="app/avatar/<?= $user['avatar'] ?>" alt="user avatar">
            </div>
            <p><?= $user['name'] ?></p>
        </div>
        <div class="upload">
            <img src="/app/uploads/<?= $post['image'] ?>" alt="">
        </div>
        <p><?= $post['description'] ?></p>
    </section>
<?php endforeach; ?>

<?php require __DIR__ . '/views/footer.php' ?>