<?php require __DIR__ . '/views/header.php' ?>

<form action="/app/users/edit.php" method="post" enctype="multipart/form-data">
    <label for="avatar">Upload profile image</label>
    <input type="file" name="avatar" id="avatar" required accept="image/jpeg, image/jpg">
    <button type=submit>Upload</button>

    <img width="100px" height="100px" class="avatar" src="/app/avatar/avatar.jpeg">

</form>