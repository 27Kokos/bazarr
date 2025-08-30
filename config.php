<?php
// config.php
$host = 'localhost';
$dbname = 'roman0rv_bd'; // Имя вашей БД
$username = 'roman0rv_bd'; // Пользователь БД
$password = 'bd_roman0rv'; // Пароль к БД

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>