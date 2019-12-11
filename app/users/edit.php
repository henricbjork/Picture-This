<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    $destination = __DIR__ . '/../avatar/' . 'avatar.jpeg';

    if ($avatar['type'] != 'image/jpeg') {
        echo 'Only jpegs allowed bitch';
    } else {
        move_uploaded_file($avatar['tmp_name'], $destination);
    }
}
redirect('../../edit.php');

?>