<?php
require __DIR__ . '/views/header.php';
require __DIR__ . '/views/settings.php';
authenticateUser();

$user = getUserById((int) $_GET['id'], $pdo);
$posts = getPostsById((int) $_GET['id'], $pdo);

?>
<div class="container-andreas">
    <?php foreach ($posts as $post) : ?>
        <section class="uploadContainer">
            <div class="authorContainer">
                <div class="author">

                    <p class="authorName"><?= $user['name'] ?></p>
                </div>
                <?php if ($_GET['id'] === $_SESSION['user']['id']) : ?>
                    <a href="editPost.php?id=<?= $post['id'] ?>&user=<?= $_GET['id'] ?>"><img class="editIcon" src="icons/edit.svg" alt="edit button"></a>
                <?php endif; ?>
            </div>
            <div class="upload">
                <img src="/app/uploads/<?= $post['image'] ?>" alt="post image">
            </div>
            <div class="like">
                <form method="post" class="likeForm">
                    <input type="hidden" name="likedPostId" value="<?php echo $post['id']; ?>">
                    <button type="submit" class="likeButton" <?php echo (isLiked($pdo, $user['id'], $post['id'])) ? 'likeButton--liked' : 'likeButton--unliked'; ?>"><img class="heartIcon" src="icons/heart.svg" alt="heart icon"></button>
                    <p>
                        <?php

                        $likes = getAmountLikes($pdo, $post['id']);
                        if ($likes[0] != 0) {
                            echo ($likes[0] . ' likes this');
                        }

                        ?>
                    </p>
                </form>
            </div>
            <div class="description">
                <span>
                    <strong>
                        <p class="descName"><?= $user['name'] ?>
                    </strong>
                </span> <?= $post['description'] ?></p>
            </div>
        </section>
        <div class="container-comments">
            <?php foreach (getComment($post['id'], $pdo) as $comment) : ?>
                <div class="container-comment-user">
                    <a class="hyperlink-username" href="profile.php?id=<?php echo $comment['users_id']; ?>"><?php echo getUsersUsername($comment['users_id'], $pdo); ?></a>
                    <p><?php echo $comment['comment']; ?></p>
                    <?php if ($_SESSION['user']['id'] === $post['user_id'] ||  $_SESSION['user']['id'] === $comment['users_id']) : ?>
                        <form class="form-delete-comment" action="#">
                            <input type="hidden" name="id" value="<?php echo $comment['id'] ?>">
                            <button class="andreas-button" type="submit">Delete comment</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>



    <?php foreach ($posts as $post) : ?>
        <form class="form-comment" action="#" method="post" enctype="multipart/form-data">

            <div class="container-inside-form">
                <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                <textarea type="text" name="comment" maxlength="100" placeholder="add a comment" name="comment"></textarea>
            </div>
            <button class="andreas-button" type="submit">Post comment</button>
        </form>

    <?php endforeach; ?>
</div>

<?php require __DIR__ . '/views/footer.php' ?>
