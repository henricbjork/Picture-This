<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['id'])) {

    $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);

    $statement = $pdo->prepare('SELECT * FROM users WHERE id=:id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->execute([
        ':id' => $id,
    ]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($_SESSION['user']['id'] === $user['id']) {


        $statement1 = $pdo->prepare('DELETE FROM users WHERE id=:id');

        if (!$statement1) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement1->execute([
            ':id' => $id,
        ]);

        $statement2 = $pdo->prepare('DELETE FROM posts WHERE user_id=:id');

        if (!$statement2) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement2->execute([
            ':id' => $id,
        ]);

        $statement3 = $pdo->prepare('DELETE FROM post_likes WHERE user_id=:id');

        if (!$statement3) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement3->execute([
            ':id' => $id,
        ]);

        $statement4 = $pdo->prepare('DELETE FROM follow WHERE user_id=:id');

        if (!$statement4) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement4->execute([
            ':id' => $id,
        ]);

        $statement5 = $pdo->prepare('DELETE FROM follow WHERE fu_id=:id');

        if (!$statement5) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement5->execute([
            ':id' => $id,
        ]);

        $statement6 = $pdo->prepare('DELETE FROM comments WHERE users_id=:id');

        if (!$statement6) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement6->execute([
            ':id' => $id,
        ]);

        unset($_SESSION['user']);
        session_destroy();

        redirect('/login.php');
    } else {
        $_SESSION['message'] = "Something went wrong. Please try again.";
        redirect('/profile.php');
    }
}
