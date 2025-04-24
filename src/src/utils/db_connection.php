<?php

// Данные для подключения к БД
$host = 'db';
$db = 'pool';
$user = 'root';
$password = 'root';
$charset = 'utf8mb4';

// Настройки подключения к БД
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Опции подключения
$options = [
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	PDO::ATTR_EMULATE_PREPARES => false,
];

try {
	// Подключение к БД
	$pdo = new PDO($dsn, $user, $password, $options);
} catch (PDOException $e) {
	echo 'Ошибка подключения к базе данных ' . $e->getMessage();
	exit;
}