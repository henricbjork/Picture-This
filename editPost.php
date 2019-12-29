<?php
require __DIR__ . '/views/header.php';
$user = getUserById($_SESSION['user']['id'], $pdo);
$post = getPostbyId($_GET['id'], $pdo);

?>

<?php if (isset($_SESSION['errors'][0])) : ?>
    <?php displayError(); ?>
<?php endif; ?>

<div class="upload">
    <img src="/app/uploads/<?= $post['image'] ?>" alt="post image" loading="lazy">
</div>
<div class="description">
    <p><?= $post['description'] ?></p>
</div>

<section class="editContainer">
    <form action="/app/posts/editPost.php?id=<?= $post['id'] ?>" method="post" enctype="multipart/form-data">
        <label for="image">Change Image</label>
        <input type="file" name="image" id="image" accept="image/jpeg, image/jpg">
        <label for="description">Change description</label>
        <textarea name="description" id="description" cols="30" rows="10"><?= $post['description'] ?></textarea>
        <button type=submit>Save</button>
    </form>
</section>

<form action="/app/posts/deletePost.php?id=<?= $post['id'] ?>" method="post">
    <button type="submit">Delete post</button>
</form>