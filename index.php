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
                            <img src="app/default_image/default-profile.jpg" alt="user avatar">
                        <?php else : ?>
                            <img src="app/avatar/<?= $post['avatar'] ?>" alt="user avatar">
                        <?php endif; ?>
                    </div>
                    <p class="authorName"><a href="/profile.php?id=<?= $post['author_id'] ?>"><?= $post['name'] ?></a></p>
                </div>
                <?php if ($post['author_id'] === $_SESSION['user']['id']) : ?>
                    <a href="editPost.php?id=<?= $post['post_id'] ?>&user=<?= $user['id'] ?>"><img class="editIcon" src="icons/edit.svg" alt="edit button"></a>
                <?php endif; ?>
            </div>
            <div class="upload">
                <img src="/app/uploads/<?= $post['image'] ?>" alt="post image">
            </div>
            <div class="like">
                <form method="post" class="likeForm">
                    <input type="hidden" name="likedPostId" value="<?php echo $post['post_id']; ?>">
                    <button type="submit" class="likeButton <?php echo (isLiked($pdo, $user['id'], $post['id'])) ? 'likeButton--liked' : 'likeButton--unliked'; ?>"><img class="heartIcon" src="icons/heart.svg" alt="heart icon"></button>
                    <p>
                        <?php

                        $likes = getAmountLikes($pdo, $post['post_id']);
                        if ($likes[0] != 0) {
                            echo ($likes[0] . ' likes this');
                        }

                        ?>
                    </p>
                </form>
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
        <div class="noPostMessageContainer">
            <p class="noPostsMessage">There are no posts right now. <a class="noPostMessageLink" href="/upload.php">Upload a photo!</a></p>
        </div>
    <?php endif; ?>
</section>

<?php require __DIR__ . '/views/footer.php' ?>