<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    $destination = __DIR__ . '/../avatar/' . 'avatar.jpeg';

    if ($avatar['type'] != 'image/jpeg') {
        $_SESSION['errors'][0] = 'File type not supported. Only jpeg files accepted.';
    } else {
        move_uploaded_file($avatar['tmp_name'], $destination);
    }

    redirect('/edit.php');
}

if (isset($_POST['bio'])) {
    $bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);

    $statement = $pdo->prepare('INSERT INTO users (bio) VALUES (:bio)');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':bio' => $bio,
    ]);

    redirect('/edit.php');
}
