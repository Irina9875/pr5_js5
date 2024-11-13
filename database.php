<?php

// index.php

// Параметры подключения к базе данных
$host = 'localhost';
$dbname = '425';
$username = 'root'; // Замените на ваше имя пользователя MySQL
$password = '';     // Замените на ваш пароль MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Устанавливаем режим ошибок PDO на исключения
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
    exit();
}
