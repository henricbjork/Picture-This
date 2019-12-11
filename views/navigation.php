<nav>

    <li>
        <a href="index.php">Home</a>
    </li>
    <!-- This removes the register button from the navigation if the user is logged in. -->
    <?php if (!isset($_SESSION['user'])) : ?>
        <li>
            <a href="register.php">Register</a>
        </li>
    <?php else: ?>
        
    <?php endif; ?>
    
    <li>
        <?php if (isset($_SESSION['user'])) : ?>
            <a href="app/users/logout.php">Logout</a>
        <?php else : ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </li>

</nav>