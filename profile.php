<?php
require __DIR__ . '/views/header.php';

authenticateUser();
$user = getUserById((int) $_GET['id'], $pdo);
$posts = getPostsById((int) $_GET['id'], $pdo);
// IF NO ID IS GIVEN IN URL, REDIRECTS TO LOGGED IN USERS
if (!$_GET['id']) {
    redirect('/profile.php?id=' . $_SESSION['user']['id']);
}
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
    <?php if ($_GET['id'] === $_SESSION['user']['id']) : ?>
        <section class="editProfile">
            <button><a href="/edit.php">Edit Profile</a></button>
        </section>
    <?php else : ?>
        <button type="submit"><a href="app/users/follow.php?id=<?= $_GET['id']?>">Follow</a></button>
    <?php endif; ?>
</section>

<?php if ($_SESSION['user']['id'] === $_GET['id']) : ?>
    <img class="settingsButton" src="/icons/settings.svg">
<?php endif; ?>

<?php foreach ($posts as $post) : ?>
    <section class="uploadContainer">
        <div class="author">
            <div class="authorImage">
                <img src="app/avatar/<?= $user['avatar'] ?>" alt="user avatar" loading="lazy">
            </div>
            <p><?= $user['name'] ?></p>
            <?php if ($_GET['id'] === $_SESSION['user']['id']) : ?>
                <a href="editPost.php?id=<?= $post['id'] ?>">Edit Post</a>
            <?php endif; ?>
        </div>
        <div class="upload">
            <img src="/app/uploads/<?= $post['image'] ?>" alt="post image" loading="lazy">
        </div>
        <div class="like">
            <!-- <a href="app/posts/like.php?post_id=<?= $post['id'] ?>&id=<?= $user['id'] ?>">Like</a> -->
            <form action="app/posts/like.php?post_id=<?= $post['id'] ?>&id=<?= $user['id'] ?>" method="get">
                <input type="hidden" name="post_id" id="post_id" value="<?= $post['id'] ?>">
                <input type="hidden" name="user_id" id="user_id" value="<?= $user['id'] ?>">
                <button type="submit">Like</button>
            </form>
            <p><?= $post['likes'] ?> people like this</p>
        </div>
        <div class="description">
            <p><?= $post['description'] ?></p>
        </div>
    </section>
<?php endforeach; ?>

<?php require __DIR__ . '/views/footer.php' ?>