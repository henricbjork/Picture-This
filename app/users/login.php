<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':email' => $email,
    ]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        redirect('/login.php');
    }

    if (password_verify($password, $user['password'])) {
        unset($user['password']);

        $_SESSION['user'] = $user;
    }
}   


redirect('/index.php');
