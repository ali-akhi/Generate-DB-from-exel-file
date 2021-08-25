<?php


try {
    $dsn = "mysql:host=localhost;dbname=Piccolo; charset=utf8";
    $user = 'root';
    $passwrd = '';
    $connection = new PDO($dsn, $user, $passwrd);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
