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
    } elseif ($image['size'] >= 2097152) {
        $_SESSION['errors'][0] = 'The uploaded file exceeded the file size limit.';
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

    redirect('/edit.php');
}

// !! LOGIC FOR CHANGING NAME
if (isset($_POST['changeName'])) {
    $name = $_POST['changeName'];
    $email = $_POST['changeEmail'];
    $id = $_SESSION['user']['id'];

    $statement = $pdo->prepare('UPDATE users SET name = :name WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $id,
        ':name' => $name,
    ]);

    $secondStatement = $pdo->prepare('SELECT name FROM users WHERE id = :id');

    $secondStatement->execute([
        ':id' => $id,
    ]);

    $user = $secondStatement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user']['name'] = $user['name'];

    redirect('/edit.php');
}

// !! LOGIC FOR CHANGING EMAIL
if (isset($_POST['changeEmail'])) {
    $email = filter_var($_POST['changeEmail'], FILTER_SANITIZE_EMAIL);
    $id = $_SESSION['user']['id'];

    if ($email === "") {
        $_SESSION['errors'][] = 'Please enter an email';
        redirect('/edit.php');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'][] = 'Unvalid Email';
        redirect('/edit.php');
    }

    $statement = $pdo->prepare('UPDATE users SET email = :email WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $id,
        ':email' => $email,
    ]);

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
            redirect('/edit.php');
        }
    }

    $thirdStatement->execute([
        ':id' => $id,
    ]);

    $user = $thirdStatement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['user']['email'] = $user['email'];

    redirect('/edit.php');
}
redirect('/edit.php');
