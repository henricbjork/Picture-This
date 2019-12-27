<?php require __DIR__ . '/views/header.php' ?>

<?php
authenticateUser();
if(isset($_GET['search'])) {
$users = searchForUser($_GET['search'], $pdo);
}
?>

<form action="/search.php" method="get">
    <label for="search">Search for users: </label>
    <input type="text" name="search" id="search">
    <button type="submit">Search</button>
</form>

<?php if (isset($_SESSION['errors'][0])) : ?>
    <?php displayError(); ?>
<?php endif; ?>

<?php if (isset($users)) : ?>
    <ul>
        <?php foreach ($users as $user) : ?>
            <li>
                <img src="app/avatar/<?= $user['avatar'] ?>">
                <a href="#"><?= $user['name'] ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>