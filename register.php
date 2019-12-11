<?php require __DIR__ . '/views/header.php'; ?>

<h1>Register</h1>
<form action="app/users/register.php" method="post">
    <label for="name">Name: </label>
    <input type="text" name="name" id="name" required>

    <?php if (isset($_SESSION['errors'][0])) : ?>

        <p><?= $_SESSION['errors'][0] ?></p>

    <?php else : ?>

        <?php unset($_SESSION['errors']) ?>

    <?php endif; ?> <label for="email">Email: </label>
    <input type="text" name="email" id="email" required>
    <label for="password">Password: </label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Register</button>
</form>

<?php require __DIR__ . '/views/footer.php'; ?>