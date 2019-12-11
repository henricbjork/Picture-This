<?php require __DIR__ . '/views/header.php' ?>

<section class="register">

    <h1>Create Account</h1>

    <form action="app/users/register.php" method="post">
        <label for="name">Full name: </label><br>
        <input type="text" name="name" id="name" required><br>

        <?php if (isset($_SESSION['errors'][0])) : ?>

            <p><?php displayError(); ?><p>

                <?php endif; ?>

                <label for="email">Email: </label><br>
                <input type="email" name="email" id="email" required><br>
                <label for="password">Password: </label><br>
                <input type="password" name="password" id="password" required><br>
                <button type="submit">Register</button>
    </form>

    <a href="/login.php">Already have an account?</a>

</section>

<?php require __DIR__ . '/views/footer.php'; ?>