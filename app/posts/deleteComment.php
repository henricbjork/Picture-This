<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


if (isset($_POST['id'])) {

    $idPost = filter_var($_POST['id'], FILTER_SANITIZE_STRING);

    $statement = $pdo->prepare('SELECT * FROM comments WHERE id=:id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $idPost,
    ]);

    $comment = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM posts WHERE id=:id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $comment['post_id'],
    ]);

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    if ($_SESSION['user']['id'] === $post['user_id'] ||  $_SESSION['user']['id'] === $comment['users_id']) {

        $statement = $pdo->prepare('DELETE FROM comments WHERE id=:id');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':id' => $idPost,
        ]);

        echo json_response([
            'delete' => true,
        ]);
    } else {
        $_SESSION['message'] = "Something went wrong. Please try again.";
        redirect('/profile.php');
    }
}
