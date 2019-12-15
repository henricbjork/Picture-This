<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// !! LOGIC FOR CHANGING PROFILE PICTURE
if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    $fileName = GUID() . '.jpeg';
    $destination = __DIR__ . '/../avatar/' . $fileName;
    $id = $_SESSION['user']['id'];

    if ($avatar['type'] != 'image/jpeg') {
        $_SESSION['errors'][0] = 'File type not supported. Only jpeg files accepted.';
    } else {
        move_uploaded_file($avatar['tmp_name'], $destination);
        $statement = $pdo->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');
        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }
        $statement->execute([
            ':avatar' => $fileName,
            ':id' => $id,
        ]);

        $secondStatement = $pdo->prepare('SELECT avatar FROM users WHERE id = :id');

        $secondStatement->execute([
            ':id' => $id,
        ]);

        $user = $secondStatement->fetch(PDO::FETCH_ASSOC);

        $_SESSION['user']['avatar'] = $user['avatar'];
       
    }

    redirect('/edit.php');
}
// !! LOGIC FOR CHANGING BIOGRAPHY
if (isset($_POST['bio'])) {
    $bio = nl2br(filter_var($_POST['bio'], FILTER_SANITIZE_STRING));
    $id = $_SESSION['user']['id'];

    $statement = $pdo->prepare('UPDATE users SET bio = :bio WHERE id = :id');


    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':bio' => $bio,
        ':id' => $id,
    ]);

    $secondStatement = $pdo->prepare('SELECT bio FROM users WHERE id = :id');

    $secondStatement->execute([
        ':id' => $id,
    ]);

    $user = $secondStatement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user']['bio'] = $user['bio'];

    redirect('/edit.php');
}
