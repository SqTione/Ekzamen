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
    gender ENUM('Мужчина', 'Женщина') NOT NULL,
    password VARCHAR(255) NOT NULL,
    certificate LONGBLOB,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE
);
";
executeQuery($sqlCreateUserTable);

// Создание таблицы для статусов заявок
$sqlCreateApplicationStatusTable = "
CREATE TABLE IF NOT EXISTS application_status (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);
";
executeQuery($sqlCreateApplicationStatusTable);

// Заполнение статусами таблицы
$sqlInsertStatuses = "
INSERT INTO application_status (name) 
VALUES 
('Новое'),
('В работе'),
('Одобрено'),
('Отклонено')
ON DUPLICATE KEY UPDATE name=name;
";
executeQuery($sqlInsertStatuses);

// Создание таблицы для заявок
$sqlCreateApplicationTable = "
CREATE TABLE IF NOT EXISTS application (
    id INT AUTO_INCREMENT PRIMARY KEY,
    visit_date DATE NOT NULL,
    user_id INT NOT NULL,
    status_id INT NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE,
    FOREIGN KEY (status_id) REFERENCES application_status(id) ON DELETE CASCADE
);
";
executeQuery($sqlCreateApplicationTable);

echo "База данных и таблицы успешно созданы!";
?>