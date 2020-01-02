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
                        <a class="editButton" href="editPost.php?id=<?= $post['id'] ?>&user=<?= $_GET['id'] ?>"><img class="editIcon" src="icons/edit.svg" alt="edit button"></a>
                    <?php endif; ?>
                </div>
                <div class="upload">
                    <img src="/app/uploads/<?= $post['image'] ?>" alt="post image">
                </div>
                <div class="like">
                    <a href="app/posts/like.php?post_id=<?= $post['id'] ?>&user_id=<?= $user['id'] ?>"><img class="heartIcon" src="/icons/heart.svg" alt="heart icon"></a>
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