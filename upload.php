<?php
require __DIR__ . '/views/header.php';
authenticateUser();
$posts = getPostsById($_SESSION['user']['id'], $pdo);
?>

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

<section class="uploadContainer">
    <form action="/app/posts/upload.php" method="post" enctype="multipart/form-data">
        <label for="image">Choose Image</label>
        <input type="file" name="image" id="image" required accept="image/jpeg, image/jpg">
        <label for="description">Add description</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <button type=submit>Upload</button>
    </form>
</section>

<?php require __DIR__ . '/views/footer.php' ?>