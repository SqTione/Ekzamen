<?php

session_start();

require_once '../utils/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = $_POST['email'] ?? '';
	$password = $_POST['password'] ?? '';

	// Получение пароля из БД
	try {
		$stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email LIMIT 1");
		$stmt->bindParam(':email', $email);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$user = $stmt->fetch(PDO::FETCH_ASSOC);

			if (password_verify($password, $user['password'])) {
				$_SESSION['user_email'] = $user['email'];

				header('Location: ../views/profile.php');
				exit();
			} else {
				echo "Неверный логин или пароль!";
			}
		} else {
			echo "Неверный логин или пароль";
		}
	} catch (PDOException $e) {
		echo "Ошибка базы данных: " . $e->getMessage();
		exit;
	}
}