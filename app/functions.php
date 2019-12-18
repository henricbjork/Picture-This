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
function getUserById($id, $pdo) {

    $statement = $pdo->prepare('SELECT * FROM users WHERE id = :id');

    $statement->execute([
        ':id' => $id,
    ]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    return $user;
    
}

function getPostsById($id, $pdo) {

    $statement = $pdo->prepare('SELECT * FROM posts WHERE user_id = :user_id ORDER BY image DESC');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':user_id' => $id,
    ]);

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}