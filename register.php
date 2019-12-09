<?php require __DIR__ . '/views/header.php'; ?>

<h1>Register</h1>
<form action="app/users/register.php" method="post">
    <label for="email">Email: </label>
    <input type="email" name="email" id="email" required>
    <label for="password">Password: </label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Register</button>
</form>

<?php require __DIR__ . '/views/footer.php'; ?>