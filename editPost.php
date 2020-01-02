<?php
require __DIR__ . '/views/header.php';
authenticateUser();
$user = getUserById($_SESSION['user']['id'], $pdo);
$post = getPostbyId($_GET['id'], $pdo);
if (isset($_SESSION['errors'][0])) {
    displayError();
}
// Prevents users from accessing another users post from the url
if ($_GET['user'] != $_SESSION['user']['id']) {
    redirect('/default.php');
}
?>

<div class="authorContainer">
    <div class="author">
        <div class="authorImage">
            <?php if (!isset($user['avatar'])) : ?>
                <img src="app/avatar/default-profile.jpg" alt="user avatar">
            <?php else : ?>
                <img src="app/avatar/<?= $user['avatar'] ?>" alt="user avatar">
            <?php endif; ?>
        </div>
        <p class="authorName"><?= $user['name'] ?></p>
    </div>
</div>

<div class="upload">
    <img src="/app/uploads/<?= $post['image'] ?>" alt="post image" loading="lazy">
</div>
<div class="description">
    <span>
        <strong>
            <p class="descName"><?= $user['name'] ?>
        </strong>
    </span> <?= $post['description'] ?></p>
</div>

<section class="editPostContainer">
    <form action="/app/posts/editPost.php?id=<?= $post['id'] ?>" method="post" enctype="multipart/form-data">
        <label for="image">Change Image: </label><br>
        <input type="file" name="image" id="image" accept="image/jpeg, image/jpg"><br>
        <label for="description">Change description: </label><br>
        <textarea name="description" id="description" cols="30" rows="10"><?= $post['description'] ?></textarea><br>
        <button class="editPostButton" type=submit>Save</button>
    </form>
</section>

<form action="/app/posts/deletePost.php?id=<?= $post['id'] ?>" method="post">
    <button type="submit">Delete post</button>
</form>

<?php require __DIR__ . '/views/footer.php' ?>