<?php
require_once '../utils/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$applicationId = $_POST['application_id'];
	$statusId = $_POST['status_id'];

	try {
		$stmt = $pdo->prepare("UPDATE application SET status_id = :status_id WHERE id = :id");
		$stmt->execute([
			':status_id' => $statusId,
			':id' => $applicationId
		]);
	} catch (PDOException $e) {
		echo 'Ошибка: ' . $e->getMessage();
		exit;
	}
}

header('Location: ../views/admin_panel.php');
exit;
