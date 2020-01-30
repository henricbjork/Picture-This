<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// !! LOGIC FOR UPLOADING POSTS
if (isset($_FILES['image'], $_POST['description'])) {
    $image = $_FILES['image'];
    $description = $_POST['description'];
    $fileName = GUID() . '.jpeg';
    $destination = __DIR__ . '/../uploads/' . $fileName;
    $id = $_SESSION['user']['id'];

    if ($image['type'] != 'image/jpeg') {
        $_SESSION['errors'][0] = 'File type not supported. Only jpeg files accepted.';
    } elseif ($image['size'] >= 5097152) {
        $_SESSION['errors'][0] = 'The uploaded file exceeded the file size limit.';
    } else {
        move_uploaded_file($image['tmp_name'], $destination);

        $statement = $pdo->prepare(
            'INSERT INTO posts
            (image, user_id, description)
            VALUES (:image, :user_id, :description)'
        );

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':image' => $fileName,
            ':user_id' => $id,
            ':description' => $description,
        ]);

        $secondStatement = $pdo->prepare('SELECT image, description FROM posts WHERE user_id = :user_id');

        $secondStatement->execute([
            ':user_id' => $id,
        ]);

        $images = $secondStatement->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION['messages'][0] = 'Your post has been uploaded!';
    }

    redirect('/upload.php');
}
