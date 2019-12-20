<?php

declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}
// This function echoes errors when they occur
// and then removes the message on reload.
function displayError()
{
    echo $_SESSION['errors'][0];
    unset($_SESSION['errors']);
}

/**
 * This function redirects the user back to login page
 * if the user tries to access the site without being 
 * logged in
 *
 * @return void
 */
function authenticateUser()
{
    if (!isset($_SESSION['user'])) {
        redirect('/login.php');
    }
}
// This function returns a Globally Unique IDentifier
// that is used to save uploaded image files with an unique
// ID
function GUID()
{
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function getUserById($id, $pdo)
{

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');

    $statement->execute([
        ':id' => $id,
    ]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    return $user;
}

function getPostsById($id, $pdo)
{
    // $statement = $pdo->prepare(
    //     'SELECT * FROM posts 
    //      WHERE user_id = :user_id
    //      ORDER BY posts.id ASC'
    // );

    $statement = $pdo->prepare(
        'SELECT posts.id, posts.image, posts.description, posts.user_id, 
    COUNT(post_likes.id) AS likes 
    FROM posts 
    LEFT JOIN post_likes
    ON posts.id = post_likes.post
    WHERE user_id = :user_id 
    GROUP BY posts.id
    ORDER BY posts.id ASC'
    );

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':user_id' => $id,
    ]);

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

/**
 * Gets one post from database to frontend, with id from database
 * 
 * @param integer $postId
 * @param PDO $pdo
 * @return array
 */
function getPostById(int $id, PDO $pdo): array
{

    $statement = $pdo->prepare('SELECT * FROM posts WHERE id = :id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':id' => $id
    ]);

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    return $post;
}
function getLikes(int $id, PDO $pdo): array
{
    $secondStatement = $pdo->prepare(
        'SELECT posts.id, posts.image, posts.description, posts.user_id, 
    COUNT(post_likes.id) AS likes 
    FROM posts 
    LEFT JOIN post_likes
    ON posts.id = post_likes.post
    WHERE user_id = :user_id 
    GROUP BY posts.id
    ORDER BY posts.id ASC'
    );
    
    if (!$secondStatement) {
        die(var_dump($pdo->errorInfo()));
    }
    $secondStatement->execute([
        ':user_id' => $id,
    ]);

    $likes = $secondStatement->fetchAll(PDO::FETCH_ASSOC);
    return $likes;
}
