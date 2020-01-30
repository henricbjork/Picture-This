<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


if (isset($_POST['id'], $_POST['comment'])) {

    $idPost = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);

    $statement = $pdo->prepare('SELECT * FROM comments WHERE id=:id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $idPost,
    ]);

    $commentDB = $statement->fetch(PDO::FETCH_ASSOC);

    $statement = $pdo->prepare('SELECT * FROM posts WHERE id=:id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $commentDB['post_id'],
    ]);

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    if ($_SESSION['user']['id'] === $post['user_id'] ||  $_SESSION['user']['id'] === $commentDB['users_id']) {


        $statement = $pdo->prepare('UPDATE comments SET comment=:comment WHERE id=:id');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':comment' => $comment,
            ':id' => $idPost,
        ]);


        echo json_response([
            'comment' => $comment,
            'id' => $idPost,
        ]);
    } else {
        $_SESSION['message'] = "Something went wrong. Please try again.";
        redirect('/index.php');
    }
}
