<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';
$user = getUserById($_SESSION['user']['id'], $pdo);
$post = getPostbyId((int) $_GET['id'], $pdo);

if ($user['id'] === $post['user_id']) {
    $userId = $user['id'];
    $postId = $post['id'];

    $statement = $pdo->prepare('DELETE FROM posts WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $postId,
    ]);

    redirect('/profile.php');
} 
