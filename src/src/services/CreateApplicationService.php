<?php
session_start();
require_once '../utils/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Проверяем, что пользователь авторизован
	if (!isset($_SESSION['user_email'])) {
		header("Location: ../utils/logout.php");
		exit;
	}

	$visitDate = $_POST['date'] ?? '';
	$email = $_SESSION['user_email'];

	// Получаем текущую дату
	$currentDate = date('Y-m-d');

	// Проверка, чтобы дата не была в прошлом
	if ($visitDate < $currentDate) {
		echo "Невозможно создать заявку на прошедшую дату.";
		exit;
	}

	// Получаем id пользователя по email
	try {
		$stmt = $pdo->prepare("SELECT id FROM user WHERE email = :email LIMIT 1");
		$stmt->bindParam(':email', $email);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			$userId = $user['id'];

			// Вставка новой заявки с установкой статуса
			$sqlInsertApplication = "
                INSERT INTO application (visit_date, user_id, status_id)
                VALUES (:visit_date, :user_id, 1)  -- 1 - это статус 'new'
            ";

			$stmt = $pdo->prepare($sqlInsertApplication);
			$stmt->bindParam(':visit_date', $visitDate);
			$stmt->bindParam(':user_id', $userId);

			if ($stmt->execute()) {
				// Перенаправление на страницу профиля с успехом
				header("Location: ../views/profile.php?application_status=success");
				exit;
			} else {
				echo "Ошибка при добавлении заявки.";
			}
		} else {
			echo "Пользователь не найден.";
		}
	} catch (PDOException $e) {
		echo "Ошибка базы данных: " . $e->getMessage();
	}
}
