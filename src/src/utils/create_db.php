<?php
// Подключение к базе данных
require_once 'db_connection.php';

// Функция для выполнения SQL-запросов
function executeQuery($sql)
{
	global $pdo;
	try {
		$pdo->exec($sql);
	} catch (PDOException $e) {
		echo "Ошибка выполнения запроса: " . $e->getMessage();
		exit;
	}
}

// Создание таблицы для ролей
$sqlCreateRoleTable = "
CREATE TABLE IF NOT EXISTS role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);
";
executeQuery($sqlCreateRoleTable);

// Вставка ролей в таблицу
$sqlInsertRoles = "
INSERT INTO role (name) 
VALUES 
('user'), 
('admin')
ON DUPLICATE KEY UPDATE name=name;
";
executeQuery($sqlInsertRoles);

// Создание таблицы для пользователей
$sqlCreateUserTable = "
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surname VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    patronymic VARCHAR(100),
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    dob DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    password VARCHAR(255) NOT NULL,
    certificate LONGBLOB,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE
);
";
executeQuery($sqlCreateUserTable);

echo "База данных и таблицы успешно созданы!";
?>