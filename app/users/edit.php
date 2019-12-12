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
    $id = $_SESSION['user']['id'];

    $secondStatement = $pdo->prepare('UPDATE users SET bio = :bio WHERE id = :id');

    if (!$secondStatement) {
        die(var_dump($pdo->errorInfo()));
    }

    $secondStatement->execute([
        ':bio' => $bio,
        ':id' => $id,
    ]);

    redirect('/edit.php');
}
