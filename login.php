<?php require __DIR__ . '/views/header.php' ?>

<section class="logIn">

    <h1>Log in</h1>
    <form action="app/users/login.php" method="post">
        <label for="email">Email: </label><br>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password: </label><br>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">Log in</button><br>

        <?php if (isset($_SESSION['errors'][0])) : ?>
            <p><?php displayError(); ?></p>
        <?php endif; ?>

    </form>
    <a href="/register.php">Create Account</a>
</section>