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
                    <a href="editPost.php?id=<?= $post['post_id'] ?>&user=<?= $user['id'] ?>"><img class="editIcon" src="icons/edit.svg" alt="edit button"></a>
                <?php endif; ?>
            </div>
            <div class="upload">
                <img src="/app/uploads/<?= $post['image'] ?>" alt="post image">
            </div>
            <div class="like">
                <form method="post" class="like__form">
                    <input type="hidden" name="liked-post-id" value="<?php echo $post['post_id']; ?>">
                    <button style="width: 30px; height: 30px;" type="submit" class="like__button <?php echo (isLiked($pdo, $user['id'], $post['id'])) ? 'like__button--liked' : 'like__button--unliked'; ?>"><img src="icons/heart.svg"></button>
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