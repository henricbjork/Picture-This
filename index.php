<?php 
require __DIR__ . '/views/header.php';
authenticateUser(); 

$statement = $pdo->query('SELECT * FROM posts WHERE user_id = 25');

if(!$statement) {
        die(var_dump($pdo->errorInfo()));
}

$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
        echo $post['image'];
}

?>

<section class="startPage">

        <p>This is the feed.</p>

</section>

<?php require __DIR__ . '/views/footer.php' ?>