<?php
require __DIR__ . '/views/header.php';
require __DIR__ . '/views/settings.php';
authenticateUser();

$user = getUserById((int) $_GET['id'], $pdo);
$posts = getPostsById((int) $_GET['id'], $pdo);

// IF NO ID IS GIVEN IN URL, REDIRECTS TO LOGGED IN USERS PROFILE
if (!$_GET['id']) {
    redirect('/profile.php?id=' . $_SESSION['user']['id']);
}
if (!isset($user['avatar'])) {
    $user['avatar'] = '../default_image/default-profile.jpg';
}

?>

<section class="profilePageContainer">

    <?php if (isset($_SESSION['errors'][0])) : ?>
        <div class="errorContainer">
            <p class="errorMessage"><?php displayError(); ?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['messages'][0])) : ?>
        <div class="messageContainer">
            <p class="message"><?php displayMessage(); ?></p>
        </div>
    <?php endif; ?>

    <?php if (isset($user['id'])) : ?>
        <?php if ($_SESSION['user']['id'] === $_GET['id']) : ?>
            <img class="settingsButton" src="/icons/settings.svg">
        <?php endif; ?>
        <section class="profileContainer">
            <div class="avatarContainer">
                <img class="avatar" src="app/avatar/<?= $user['avatar'] ?>">
            </div>
            <div class="userName">
                <h1><?= $user['name'] ?></h1>
            </div>
            <section class="bioContainer">
                <?php if (isset($user['bio'])) : ?>
                    <p><?= $user['bio'] ?><p>
                        <?php endif; ?>
            </section>
            <?php if ($_GET['id'] === $_SESSION['user']['id']) : ?>
                <section class="editProfile">
                    <a href="/edit.php"><button>Edit Profile</button></a>
                </section>
            <?php else : ?>
                <a href="app/users/follow.php?id=<?= $_GET['id'] ?>"><button class="followButton" type="submit">Follow</button></a>
            <?php endif; ?>
        </section>

        <?php foreach ($posts as $post) : ?>
            <section class="uploadContainer">
                <div class="authorContainer">
                    <div class="author">
                        <div class="authorImage">
                            <img src="app/avatar/<?= $user['avatar'] ?>" alt="user avatar">
                        </div>
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
            <div class="commentContainer">
                <div class="commentInnerContainer">
                    <?php foreach (getComment($post['id'], $pdo) as $comment) : ?>
                        <div class="avatarCommentEditDeleteContainer">

                            <?php if ($_SESSION['user']['id'] === $comment['users_id']) : ?>
                                <div class="avatarCommentEditDeleteInnerContainer">
                                    <div>
                                        <a href="profile.php?id=<?php echo $comment['users_id']; ?>"><?php echo getUsersUsername($comment['users_id'], $pdo); ?></a>
                                        <p class="commentString"><?php echo $comment['comment']; ?></p>
                                    </div>

                                    <form class="commentFormEdit" action="#">
                                        <input type="hidden" name="id" value="<?php echo $comment['id'] ?>">
                                    </form>
                                    <button class="commentButtonEdit">Edit</button>
                                </div>

                            <?php else : ?>
                                <div>
                                    <a href="profile.php?id=<?php echo $comment['users_id']; ?>"><?php echo getUsersUsername($comment['users_id'], $pdo); ?></a>
                                    <p><?php echo $comment['comment']; ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if ($_SESSION['user']['id'] === $post['user_id'] ||  $_SESSION['user']['id'] === $comment['users_id']) : ?>

                                <form class="commentFormDelete" action="#">
                                    <input type="hidden" name="id" value="<?php echo $comment['id'] ?>">
                                    <button class="commentButton" type="submit">Delete</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <form class="commentFormComment" action="#" method="post" enctype="multipart/form-data">

                    <div class="formCommentCointainer">
                        <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                        <textarea class="commentTextarea" type="text" name="comment" maxlength="100" placeholder="add a comment" name="comment"></textarea>
                    </div>
                    <button class="commentButton" type="submit">Post comment</button>
                </form>
            </div>
        <?php endforeach; ?>

        <?php require __DIR__ . '/views/footer.php' ?>

</section>

<?php else : ?>

    <?php redirect('/default.php') ?>

<?php endif; ?>
