<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$_SESSION['errors'] = [];
$_SESSION['messages'] = [];

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
    // Compares the given email to the exisiting emails within the database to see if 
    // it's already been registered
    $secondStatement = $pdo->prepare("SELECT * FROM users WHERE email = :email");

    $secondStatement->execute([
        ':email' => $email,
    ]);

    $user = $secondStatement->fetch(PDO::FETCH_ASSOC);

    // Pushes error message to errors array if the email has already been registered
    // and redirects the user back to the register page 
    if ($user) {
        if ($user['email'] === $email) {
            $_SESSION['errors'][] = 'This email is already taken';
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

    $_SESSION['messages'][0] = 'Your account has been successfully created! Log in to start uploading photos.';
}

redirect('/index.php');
