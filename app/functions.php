<?php

declare(strict_types=1);

if (!function_exists('json_response')) {
    /**
     * Create and return a JSON response.
     *
     * @param array $data
     * @param int $code
     *
     * @return string
     */
    function json_response(array $data = [], int $code = 200): string
    {

        http_response_code($code);

        header('Content-Type: application/json');

        return json_encode($data);
    }
}

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
 * Displays messages if there are any
 *
 * @return void
 */
function displayMessage()
{
    echo $_SESSION['messages'][0];
    unset($_SESSION['messages']);
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

    return $user;
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
        'SELECT posts.id, posts.image, posts.description, posts.user_id
    FROM posts
    WHERE user_id = :user_id
    GROUP BY posts.id
    ORDER BY posts.upload_date DESC'
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
 * Returns array of all of the users post and the posts from users that the
 * user follows from the database.
 *
 *
 * @param integer $id
 * @param PDO $pdo
 * @return void
 */
function getAllPostsById(int $id, PDO $pdo)
{
    $statement = $pdo->prepare(
        'SELECT
    posts.id AS post_id,
    image,
    description,
    posts.user_id,
    upload_date,
    fu_id,
    follow.user_id,
    users.id AS author_id,
    name,
    avatar
	FROM posts

	LEFT JOIN follow
	ON posts.user_id = follow.user_id
	OR posts.user_id = follow.fu_id
    INNER JOIN users
    ON posts.user_id = users.id
	WHERE follow.user_id = :user_id
    OR posts.user_id = :user_id
	GROUP BY posts.id
	ORDER BY posts.upload_date desc'
    );

    $statement->execute([
        ':user_id' => $id,
    ]);

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
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

function isLiked($pdo, $userId, $postId)
{
    $statement = $pdo->prepare('SELECT *
        FROM post_likes
        WHERE user_id = :user_id
        AND post_id = :post_id');

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->execute([
        ':user_id' => $userId,
        ':post_id' => $postId
    ]);

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getAmountLikes($pdo, $postId)
{
    $statement = $pdo->prepare('SELECT COUNT(post_likes.post_id)
        FROM posts
        INNER JOIN post_likes
        ON posts.id = post_likes.post_id
        WHERE post_likes.post_id = :post_id');

    $statement->execute([
        ':post_id' => $postId
    ]);

    return $statement->fetchAll(PDO::FETCH_COLUMN);
}

if (!function_exists('getComment')) {
    /**
     * get all comments to post
     *
     * @param string $id
     * @param PDO $pde
     *
     * @return array
     */
    function getComment(String $id, $pdo): array
    {
        $sql = 'SELECT * FROM comments WHERE post_id=:id';

        $statment = $pdo->prepare($sql);

        if (!$statment) {
            die(var_dump($pdo->errorInfo()));
        }

        $statment->execute([
            ':id' => $id,
        ]);

        $comments = $statment->fetchAll(PDO::FETCH_ASSOC);

        return $comments;
    }
}

if (!function_exists('getUsersUsername')) {
    /**
     *  Get one user username
     *
     *  @param string $userId
     * @param PDO $pdo
     *
     * @return string
     */
    function getUsersUsername(string $userId, PDO $pdo): string
    {
        $sql = 'SELECT name FROM users WHERE id=:id';

        $statement = $pdo->prepare($sql);

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':id' => $userId,
        ]);

        $username = $statement->fetch(PDO::FETCH_ASSOC);

        return $username['name'];
    }
}

if (!function_exists('getUsersIdFromPost')) {
    /**
     *  Get one user username
     *
     *  @param string $userId
     * @param PDO $pdo
     *
     * @return string
     */
    function getUsersIdFromPost(string $postId, PDO $pdo): string
    {
        $sql = 'SELECT user_id FROM posts WHERE id=:id';

        $statement = $pdo->prepare($sql);

        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }

        $statement->execute([
            ':id' => $postId,
        ]);

        $userId = $statement->fetch(PDO::FETCH_ASSOC);

        return $userId['user_id'];
    }
}
