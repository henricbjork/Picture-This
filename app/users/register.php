<?php  
declare(strict_types=1);

require __DIR__.'/../autoload.php';

$errors = [];

if (isset($_POST['email'], $_POST['password'])) {
    $name = $_POST['name'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Displays error message if the email is not valid
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Unvalid Email';
    }

    $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    if(!$statement) {
        die(var_dump($statement->errorInfo()));
    }    

    $statement->execute([
        ':name' => $name,
        ':email' => $email,
        ':password' => $hashedPassword,
        ]);

}

redirect('/login.php');

?>