<?php require __DIR__ . '/views/header.php' ?>

<section class="logIn">

    <?php if (isset($_SESSION['messages'][0])) : ?>
        <div class="messageContainer">
            <p class="message"><?php displayMessage(); ?></p>
        </div>
    <?php endif; ?>

    <h1>Log in</h1>
    <form action="app/users/login.php" method="post">
        <label for="email">Email: </label><br>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password: </label><br>
        <input type="password" name="password" id="password" required><br>
        <div class="logInButton">
            <button type="submit">Log in</button>
        </div>

        <?php if (isset($_SESSION['errors'][0])) : ?>
            <div class="errorContainer">
                <p class="errorMessage"><?php displayError(); ?></p>
            </div>
        <?php endif; ?>

    </form>
    <a class="registerLoginLink" href="/register.php">Create Account</a>
</section>