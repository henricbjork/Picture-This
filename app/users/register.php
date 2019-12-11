<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['errors'] = [];

if (isset($_POST['email'], $_POST['password'])) {
    $name = $_POST['name'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Displays error message if the email is not valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'][] = 'Unvalid Email';
        redirect('/register.php');
    }

    $secondStatement = $pdo->prepare("SELECT * FROM users WHERE email = :email");

    $secondStatement->execute([
        ':email' => $email,
    ]);

    $user = $secondStatement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($user['email'] === $email) {
            $_SESSION['errors'][] =  'This email is already taken';
            redirect('/register.php');
        }
    }

    $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    if (!$statement) {
        die(var_dump($statement->errorInfo()));
    }

    $statement->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashedPassword,
    ]);
}

redirect('/login.php');
