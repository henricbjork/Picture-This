<?php require __DIR__ . '/views/header.php' ?>

<section class="register">

    <h1 class="registerBanner">Kindagram</h1>

    <h2>Create an account</h2>

    <form action="app/users/register.php" method="post">
        <label for="name">Full name: </label><br>
        <input type="text" name="name" id="name" required><br>

        <?php if (isset($_SESSION['errors'][0])) : ?>
            <div class="errorContainer">
                <p class="errorMessage"><?php displayError(); ?></p>
            </div>
        <?php endif; ?>

        <label for="email">Email: </label><br>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password: </label><br>
        <input type="password" name="password" id="password" required><br>
        <div class="registerButton">
            <button type="submit">Register</button>
        </div>
    </form>
    <a class="registerLoginLink" href="/login.php">Already have an account?</a>
</section>