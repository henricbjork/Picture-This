<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_GET['id'])) {
    $fuId = $_GET['id'];
    $userId = $_SESSION['user']['id'];

    $statement = $pdo->prepare('SELECT * FROM follow WHERE fu_id = :fu_id AND user_id = :user_id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':fu_id' => $fuId,
        ':user_id' => $userId,
    ]);

    $isFollowing = $statement->fetch(PDO::FETCH_ASSOC);

    if ($isFollowing) {
        $statement = $pdo->prepare('DELETE FROM follow WHERE user_id = :user_id AND fu_id = :fu_id');
        $statement->execute([
            ':fu_id' => $fuId,
            ':user_id' => $userId,
        ]);
        redirect('/profile.php?id=' . $_GET['id']);
        }
    $secondStatement = $pdo->prepare('INSERT INTO follow (fu_id, user_id) VALUES (:fu_id, :user_id)');

    if (!$secondStatement) {
        die(var_dump($pdo->errorInfo()));
    }

    $secondStatement->execute([
        ':fu_id' => $fuId,
        ':user_id' => $userId,
    ]);
}

redirect('/profile.php?id=' . $_GET['id']);
