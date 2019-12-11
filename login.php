<?php require __DIR__ . '/app/autoload.php'; ?>

<h1>Log in</h1>
<form action="app/users/login.php" method="post">
    <label for="email">Email: </label>
    <input type="email" name="email" id="email" required>
    <label for="password">Password: </label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Log in</button>

    <?php if (isset($_SESSION['errors'][0])) : ?>
    <p><?php displayError(); ?></p>
    <?php endif ; ?>
    
</form>
<a href="/register.php">Create Account</a>