<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['currentPassword'], $_POST['newPassword'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $id = $_SESSION['user']['id'];

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $id,
    ]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (password_verify($currentPassword, $user['password'])) {
        $statement = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':id' => $id,
            ':password' => $hashedPassword,
        ]);

        $_SESSION['user'] = $user;
    } else {
        $_SESSION['errors'][] = 'Incorrect password';
    }

}
redirect('/settings.php');
