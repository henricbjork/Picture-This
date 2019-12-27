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
/**
 * Displays errors if there are any
 *
 * @return void
 */
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
/**
 * Returns a GUID
 *
 * @return void
 */
function GUID()
{
    if (function_exists('com_create_guid') === true) {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}
/**
 * Returns user from database
 *
 * @param integer $id
 * @param PDO $pdo
 * @return array
 */
function getUserById(int $id, PDO $pdo)
{
    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');

    $statement->execute([
        ':id' => $id,
    ]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // IF NO ID IS GIVEN IN URL, REDIRECTS TO LOGGED IN USERS
    if (!$id) {
        redirect('/profile.php?id=' . $_SESSION['user']['id']);
    } else {
        return $user;
    }
}
/**
 * Fetches all posts by a user from the database
 *
 * @param integer $id
 * @param PDO $pdo
 * @return array
 */
function getPostsById(int $id, PDO $pdo): array
{
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
/**
 * Fetches users id, name and avatar image from database from search query
 *
 * @param string $search
 * @param PDO $pdo
 * @return array
 */
function searchForUser(string $search, PDO $pdo): array
{
    $search = filter_var($search, FILTER_SANITIZE_STRING);

    $statement = $pdo->prepare('SELECT id, name, avatar FROM users WHERE name LIKE :search');

    $search = '%' . $search . '%';

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':search' => $search,
    ]);

    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    if (!$users) {
        $_SESSION['errors'][] = 'No users found.';
        redirect('/search.php');
    } else {
        return $users;
    }
}
