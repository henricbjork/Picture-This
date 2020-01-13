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
    $user['avatar'] = 'default-profile.jpg';
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
        <?php endforeach; ?>

        <?php require __DIR__ . '/views/footer.php' ?>

</section>

<?php else : ?>

    <?php redirect('/default.php') ?>

<?php endif; ?>