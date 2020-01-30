<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


if (isset($_POST['id'], $_POST['comment'])) {

    $idPost = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
    $comment = trim(filter_var($_POST['comment'], FILTER_SANITIZE_STRING));

    if ($_SESSION['user']['id']) {
        $statement = $pdo->prepare('SELECT * FROM users WHERE id=:user_id');

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':user_id' => $_SESSION['user']['id'],
        ]);

        $user = $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        $_SESSION['message'] = "you are not logged in. Please login again.";
        redirect('/login.php');
    }

    $statement = $pdo->prepare('INSERT INTO comments (post_id, users_id, comment) VALUES (:post_id, :user_id, :comment)');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':post_id' => $idPost,
        ':user_id' => $_SESSION['user']['id'],
        ':comment' => $comment,
    ]);

    $stat = $pdo->prepare('SELECT * FROM comments WHERE users_id=:user_id AND post_id=:post_id AND comment=:comment ORDER BY date DESC');

    if (!$stat) {
        die(var_dump($pdo->errorInfo()));
    }

    $stat->execute([
        ':post_id' => $idPost,
        ':user_id' => $_SESSION['user']['id'],
        ':comment' => $comment,
    ]);

    $postComment = $stat->fetch(PDO::FETCH_ASSOC);

    echo json_response([
        'postId' => $idPost,
        'comment' => $comment,
        'username' => $user['name'],
        'userId' => $user['id'],
        'commentId' => $postComment['id'],
    ]);
}
