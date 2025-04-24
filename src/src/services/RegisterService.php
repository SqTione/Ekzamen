<?php
// Подключение к базе данных
require_once '../utils/db_connection.php';

// Старт сессии для сохранения данных
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Получаем данные из формы
	$surname = $_POST['surname'] ?? '';
	$name = $_POST['name'] ?? '';
	$patronymic = $_POST['patronymic'] ?? '';
	$email = $_POST['email'] ?? '';
	$phone = $_POST['phone'] ?? '';
	$dob = $_POST['dob'] ?? '';
	$gender = $_POST['gender'] ?? '';
	$password = $_POST['password'] ?? '';
	$passwordRepeat = $_POST['password_repeat'] ?? '';

	// Валидация даты рождения
	$dobDate = new DateTime($dob);
	$currentDate = new DateTime();
	if ($dobDate > $currentDate) {
		die("Ошибка: Дата рождения не может быть в будущем.");
	}

	// Валидация паролей
	if ($password !== $passwordRepeat) {
		die("Ошибка: Пароли не совпадают.");
	}

	// Хэшируем пароль
	$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

	// Валидация и загрузка файла медицинской справки
	// if (isset($_FILES['certificate']) && $_FILES['certificate']['error'] == 0) {
	// 	$fileType = mime_content_type($_FILES['certificate']['tmp_name']);
	// 	if ($fileType !== 'application/pdf') {
	// 		die("Ошибка: Загрузите файл в формате PDF.");
	// 	}

	// 	// Открытие файла для чтения
	// 	$fileContent = file_get_contents($_FILES['certificate']['tmp_name']);
	// } else {
	// 	if (isset($_FILES['certificate'])) {
	// 		$error = $_FILES['certificate']['error'];
	// 		die("Ошибка загрузки файла. Код ошибки: " . $error);
	// 	} else {
	// 		die("Ошибка: Необходимо загрузить медицинскую справку.");
	// 	}
	// }

	// Сохранение данных в базе данных
	try {
		$sql = "INSERT INTO user (surname, name, patronymic, email, phone, dob, gender, password, role_id)
		VALUES (:surname, :name, :patronymic, :email, :phone, :dob, :gender, :password, 1)";
		$stmt = $pdo->prepare($sql);

		// Привязываем параметры
		$stmt->bindParam(':surname', $surname);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':patronymic', $patronymic);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':phone', $phone);
		$stmt->bindParam(':dob', $dob);
		$stmt->bindParam(':gender', $gender);
		$stmt->bindParam(':password', $hashedPassword);
		// $stmt->bindParam(':certificate', $fileContent, PDO::PARAM_LOB);

		// Выполняем запрос
		$stmt->execute();

		// Получаем последний вставленный id пользователя
		$userId = $pdo->lastInsertId();

		// Сохраняем в сессии id и email пользователя
		$_SESSION['user_id'] = $userId;
		$_SESSION['user_email'] = $email;

		// Редирект на страницу профиля
		header('Location: src/views/profile.php');
		exit;

	} catch (PDOException $e) {
		echo "Ошибка базы данных: " . $e->getMessage();
		header('Location: src/views/register.php');
		exit;
	}
}
?>