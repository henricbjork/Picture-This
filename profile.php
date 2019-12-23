<?php require __DIR__ . '/views/header.php' ?>


<?php
authenticateUser();
$user = getUserById($_SESSION['user']['id'], $pdo);
$posts = getPostsById($_SESSION['user']['id'], $pdo);
$likes = getLikes($_SESSION['user']['id'], $pdo);

?>

<?php if (isset($_SESSION['errors'][0])) : ?>
    <?php displayError(); ?>
<?php endif; ?>

<section class="profileContainer">
    <div class="avatarContainer">
        <?php if (!$user['avatar']) : ?>
            <img class="avatar" alt="user avatar" src="https://t4.ftcdn.net/jpg/00/64/67/27/240_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg" loading="lazy">
        <?php endif; ?>
        <img class="avatar" src="app/avatar/<?= $user['avatar'] ?>" loading="lazy">
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
                <img src="app/avatar/<?= $user['avatar'] ?>" alt="user avatar" loading="lazy">
            </div>
            <p><?= $user['name'] ?></p>
            <a href="editPost.php?id=<?= $post['id'] ?>">Edit Post</a>
        </div>
        <div class="upload">
            <img src="/app/uploads/<?= $post['image'] ?>" alt="post image" loading="lazy">
        </div>
        <div class="like">
            <a href="app/posts/like.php?id=<?= $post['id'] ?>">Like</a>
            <p><?= $post['likes'] ?> people like this</p>
        </div>
        <div class="description">
            <p><?= $post['description'] ?></p>
        </div>
    </section>
<?php endforeach; ?>

<?php require __DIR__ . '/views/footer.php' ?>