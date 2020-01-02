<?php
require __DIR__ . '/views/header.php';
authenticateUser();
$user = getUserById((int) $_SESSION['user']['id'], $pdo);
$posts = getAllPostsById($_SESSION['user']['id'], $pdo);
// die(var_dump($posts));

require __DIR__ . '/views/navigation.php';
?>
<section class="startPage">

    <?php if (isset($_SESSION['errors'][0])) : ?>
        <div class="errorContainer">
            <p class="errorMessage"><?php displayError(); ?></p>
        </div>
    <?php endif; ?>

    <?php foreach ($posts as $post) : ?>
        <section class="uploadContainer">
            <div class="authorContainer">
                <div class="author">
                    <div class="authorImage">
                        <?php if (!isset($post['avatar'])) : ?>
                            <img src="app/avatar/default-profile.jpg" alt="user avatar">
                        <?php else : ?>
                            <img src="app/avatar/<?= $post['avatar'] ?>" alt="user avatar">
                        <?php endif; ?>
                    </div>
                    <p class="authorName"><a href="/profile.php?id=<?= $post['author_id'] ?>"><?= $post['name'] ?></a></p>
                </div>
                <?php if ($post['author_id'] === $_SESSION['user']['id']) : ?>
                    <a class="editButton" href="editPost.php?id=<?= $post['post_id'] ?>&user=<?= $user['id'] ?>"><img class="editIcon" src="icons/edit.svg" alt="edit button"></a>
                <?php endif; ?>
            </div>
            <div class="upload">
                <img src="/app/uploads/<?= $post['image'] ?>" alt="post image">
            </div>
            <div class="like">
                <a href="app/posts/like.php?post_id=<?= $post['post_id'] ?>&user_id=<?= $user['id'] ?>&author=<?= $post['author_id'] ?>"><img class="heartIcon" src="/icons/heart.svg" alt="heart icon"></a>
                <!-- <form action="app/posts/like.php?post_id=<?= $post['id'] ?>&id=<?= $user['id'] ?>" method="get">
                    <input type="hidden" name="post_id" id="post_id" value="<?= $post['id'] ?>">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user['id'] ?>">
                    <button type="submit">Like</button>
                </form> -->
                <?php if ($post['likes'] != 0) : ?>
                    <p><?= $post['likes'] ?> likes this</p>
                <?php endif; ?>
            </div>
            <div class="description">
                <strong>
                    <a href="/profile.php?id=<?= $post['author_id'] ?>">
                        <p class="descName"><?= $post['name'] ?>
                </strong></a><?= $post['description'] ?></p>
            </div>
        </section>
    <?php endforeach; ?>


    <?php if (empty($posts)) : ?>
        <p>There are no posts right now. <a href="/upload.php">Upload a photo!</a></p>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/views/footer.php' ?>