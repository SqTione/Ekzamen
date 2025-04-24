<?php
require_once '../utils/check_auth.php';
require_once '../utils//db_connection.php';

protectedAdmin();

// Получение заявок пользователя
try {
	$stmt = $pdo->prepare("
        SELECT 
        application.*, 
        application_status.name AS status_name,
        user.name AS user_name,
        user.surname AS user_surname,
        user.patronymic AS user_patronymic,
        user.email AS user_email,
        user.phone AS user_phone,
        user.dob AS user_dob,
        user.gender AS user_gender
    FROM application
    JOIN user ON application.user_id = user.id
    JOIN application_status ON application.status_id = application_status.id
    ");
	$stmt->execute();

	$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
	echo 'Ошибка: ' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Панель администратора</title>
	<link rel="stylesheet" href="../css/style.css">
	<script src="../js/script.js"></script>
</head>

<body>
	<!-- Шапка -->
	<?php include '../components/header.php' ?>

	<!-- Основной контент -->
	<div class="app" style='margin-top: 2rem; min-height: 100vh;'>
		<!-- Все заявки пользователя -->
		<section class="applications container">
			<h1 style='margin-bottom: 1.25rem;'>Панель администратора</h1>
			<h2>Заявки пользователей:</h2>
			<div class="applications__container">
				<?php
				if (empty($applications)) {
					echo 'У вас нет заявок.';
				}

				foreach ($applications as $application):
					// Присваиваем класс в зависимости от статуса
					$statusClass = '';
					switch ($application['status_name']) {
						case 'Новое':
							$statusClass = 'application__status--new';
							break;
						case 'В работе':
							$statusClass = 'application__status--in-work';
							break;
						case 'Одобрено':
							$statusClass = 'application__status--applied';
							break;
						case 'Отклонено':
							$statusClass = 'application__status--denied';
							break;
					}
					?>
					<div class="application">
						<h3>Дата посещения: <?= $application['visit_date'] ?></h3>

						<p><strong>ФИО:</strong> <?= $application['user_surname'] ?> 	<?= $application['user_name'] ?>
							<?= $application['user_patronymic'] ?>
						</p>
						<p><strong>Email:</strong> <?= $application['user_email'] ?></p>
						<p><strong>Телефон:</strong> <?= $application['user_phone'] ?></p>
						<p><strong>Дата рождения:</strong> <?= $application['user_dob'] ?></p>
						<p><strong>Пол:</strong> <?= $application['user_gender'] ?></p>

						<form method="post" action="../services/UpdateApplicationStatus.php">
							<input type="hidden" name="application_id" value="<?= $application['id'] ?>">
							<select name="status_id" onchange="this.form.submit()">
								<?php
								// Получаем все возможные статусы
								$statusStmt = $pdo->query("SELECT * FROM application_status");
								$statuses = $statusStmt->fetchAll();

								foreach ($statuses as $status):
									$selected = $status['name'] === $application['status_name'] ? 'selected' : '';
									echo "<option value='{$status['id']}' $selected>{$status['name']}</option>";
								endforeach;
								?>
							</select>
						</form>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</div>

	<!-- Подвал -->
	<?php include '../components/footer.php' ?>
</body>

</html>