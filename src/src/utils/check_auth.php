<?php
session_start();

require_once 'db_connection.php';

function checkAuth()
{
	if (!isset($_SESSION['user_email'])) {
		return false;
	}

	return true;
}

function protectedView()
{
	if (!checkAuth()) {
		header('Location: ../views/login.php');
		return false;
	}
}

function protectedAdmin()
{
	global $pdo;

	if (!checkAuth()) {
		header('Location: ../views/login.php');
		exit;
	}

	try {
		// Получаем роль пользователя по email
		$stmt = $pdo->prepare('SELECT role_id FROM user WHERE email = :email');
		$stmt->bindParam(':email', $_SESSION['user_email']);
		$stmt->execute();

		if ($stmt->rowCount() > 0) {
			$role_id = $stmt->fetch(PDO::FETCH_ASSOC)['role_id'];

			if ($role_id == 2) {
				return true;
			} else {
				header('Location: ../views/login.php');
				exit;
			}
		} else {
			header('Location: ../views/login.php');
			exit;
		}
	} catch (PDOException $e) {
		echo 'Ошибка базы данных: ' . $e->getMessage();
		exit;
	}
}