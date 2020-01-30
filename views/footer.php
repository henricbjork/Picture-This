<?php $user = getUserById($_SESSION['user']['id'], $pdo); ?>

<div class="bottomNav">
    <a href="/index.php"><img class="homeIcon" src="icons/home.svg" alt="home icon"></a>
    <a href="/upload.php"><img class="uploadIcon" src="icons/upload.svg" alt="upload icon"></a>
    <a href="/profile.php?id=<?= $user['id'] ?>"><img class="profileIcon" src="icons/profile.svg" alt="profile icon"></a>
</div>
</main>
<script src="/../assets/scripts/main.js"></script>
<script src="/../assets/scripts/functions.js"></script>
</body>


</html>
