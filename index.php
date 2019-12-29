<?php
require __DIR__ . '/views/header.php';
authenticateUser();
$user = getUserById((int) $_SESSION['user']['id'], $pdo);
$posts = getAllPostsById($_SESSION['user']['id'], $pdo);
require __DIR__ . '/views/navigation.php';
?>

<?php if (isset($_SESSION['errors'][0])) : ?>
    <div class="errorContainer">
        <p class="errorMessage"><?php displayError(); ?></p>
    </div>
<?php endif; ?>

<?php foreach ($posts as $post) : ?>
    <section class="uploadContainer">
        <div class="author">
            <div class="authorImage">
                <img src="app/avatar/<?= $user['avatar'] ?>" alt="user avatar" loading="lazy">
            </div>
            <p><?= $user['name'] ?></p>

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

<section class="startPage">
    <?php if (empty($posts)) : ?>
        <p>There are no posts right now. <a href="/upload.php">Upload a photo!</a></p>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/views/footer.php' ?>