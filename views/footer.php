
<?php $user = getUserById($_SESSION['user']['id'], $pdo);?>

<div class="bottomNav">
    <a href="/index.php">Feed</a>
    <a href="/upload.php">New Photo</a>
    <a href="/profile.php?id=<?= $user['id'] ?>">Profile</a>
</div>
</main>
<script src="/../assets/scripts/main.js"></script>
<script src="/../assets/scripts/functions.js"></script>
</body>


</html>