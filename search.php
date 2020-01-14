<?php require __DIR__ . '/views/header.php' ?>

<?php
authenticateUser();
if (isset($_GET['search'])) {
    $users = searchForUser($_GET['search'], $pdo);
}
?>

<form class="searchForm" action="/search.php" method="get">
    <input class="searchField" type="text" name="search" id="search" placeholder="Search">
    <button type="submit"><img class="searchIcon" src="/icons/search.svg" alt="search icon"></button>
</form>

<?php if (isset($_SESSION['errors'][0])) : ?>
    <div class="errorContainer">
        <p class="errorMessage"><?php displayError(); ?></p>
    </div>
<?php endif; ?>

<?php if (isset($users)) : ?>
    <ul class="searchResult">
        <?php foreach ($users as $user) : ?>
            <li>
                <?php if (!isset($user['avatar'])) : ?>
                    <div class="author">
                        <div class="authorImage">
                            <img class="searchAvatar" src="app/default_image/default-profile.jpg" alt="user avatar">
                        </div>
                        <a href="/profile.php?id=<?= $user['id'] ?>"><?= $user['name'] ?></a>
                    </div>
                <?php else : ?>
                    <div class="author">
                        <div class="authorImage">
                            <img src="app/avatar/<?= $user['avatar'] ?>" alt="user avatar">
                        </div>
                        <a href="/profile.php?id=<?= $user['id'] ?>"><?= $user['name'] ?></a>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php' ?>