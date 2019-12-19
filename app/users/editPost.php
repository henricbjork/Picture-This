<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['description'])) {
    $description = $_POST['description'];
    $id = $_GET['id'];

    $statement = $pdo->prepare('UPDATE posts SET description = :description WHERE id = :id');

    if (!$statement) {
        die(var_dump($errorInfo()));
    }

    $statement->execute([
        ':description' => $description,
        ':id' => $id,
    ]);
}

if (isset($_FILES['image'])) {
    $image = $_FILES['image'];
    $fileName = GUID() . '.jpeg';
    $destination = __DIR__ . '/../uploads/' . $fileName;
    $id = $_GET['id'];

    if ($image['type'] === "") {
        redirect('/profile.php');
    } elseif ($image['type'] != 'image/jpeg') {
        $_SESSION['errors'][0] = 'File type not supported. Only jpeg files accepted.';
    } else {
        move_uploaded_file($image['tmp_name'], $destination);

        $statement = $pdo->prepare('UPDATE posts SET image = :image WHERE id = :id');

        if (!$statement) {
            die(var_dump($errorInfo()));
        }

        $statement->execute([
            ':image' => $fileName,
            ':id' => $id,
        ]);
    }
}
redirect('/profile.php');
