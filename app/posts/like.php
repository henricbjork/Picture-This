<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user']['id'];

    // !! INSERTS LIKE TO DATABASE
    $statement = $pdo->prepare('INSERT INTO post_likes (user, post) 
        SELECT :user_id, :id
        FROM posts
        WHERE EXISTS(
            SELECT id
            FROM posts
            WHERE id = :id)
            AND NOT EXISTS (
                SELECT id 
                FROM post_likes
                WHERE user = :user_id
                AND post = :id)
                LIMIT 1');

    

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':user_id' => $user_id,
        ':id' => $id,
    ]);

}
redirect('/profile.php');
