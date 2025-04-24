<?php
require_once '../utils/check_auth.php';
require_once '../utils//db_connection.php';

protectedView();

$email = $_SESSION['user_email'];

// Получение данных пользователя
try {
	$stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email");
	$stmt->bindParam(":email", $email);
	$stmt->execute();

	if ($stmt->rowCount() > 0) {
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
	} else {
		header("Location: ../utils/logout.php");
	}
} catch (PDOException $e) {
	echo "Ошибка: " . $e->getMessage();
}

// Получение заявок пользователя
try {
	$userId = $user['id'];

	$stmt = $pdo->prepare("
        SELECT application.*, application_status.name AS status_name
        FROM application
        JOIN application_status ON application.status_id = application_status.id
        WHERE application.user_id = :user_id
    ");
	$stmt->bindParam(":user_id", $userId);
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
	<title>Профиль</title>
	<link rel="stylesheet" href="../css/style.css">
	<script src="../js/script.js"></script>
</head>

<body>
	<!-- Шапка -->
	<?php include '../components/header.php' ?>

	<!-- Основной контент -->
	<div class="app">
		<!-- Информация о пользователе -->
		<main class="main container profile" style='margin-bottom: 32px;'>
			<h1>Профиль пользователя</h1>
			<div class="profile__data">
				<p>Фамилия: <?php echo $user['surname'] ?></p>
				<p>Имя: <?php echo $user['name'] ?></p>
				<p>Отчество: <?php echo $user['patronymic'] ?></p>
				<p>Пол: <?php echo $user['gender'] ?></p>
				<p>Дата рождения: <?php echo $user['dob'] ?></p>
				<p>Email: <?php echo $user['email'] ?></p>
				<p>Телефон: <?php echo $user['phone'] ?></p>
			</div>
		</main>

		<!-- Все заявки пользователя -->
		<section class="applications container">
			<h2>Ваши заявки:</h2>
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
						<h3>Дата посещения: <?php echo $application['visit_date'] ?></h3>
						<p class="application__status <?php echo $statusClass; ?>"><?php echo $application['status_name']; ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</section>

		<!-- Форма создания заявки -->
		<section class="create-application container">
			<form action="../services/CreateApplicationService.php" method='post' class='auth__form form'>
				<div class="form__header">
					<h2>Новая заявка</h2>
				</div>
				<div class="form__body">
					<label for="input--date" style='display: none;'>Дата посещения</label>
					<input type="date" class="form__input" placeholder='Дата посещения' name="date" required min='' id='input--date'>
					<p class="error-message">*Поле обязательно для заполнения. <br> Введите корректную дату посещения</p>
				</div>
				<div class="form__footer">
					<button type="submit" class='button button--primary'>Записаться</button>
				</div>
			</form>
		</section>
	</div>

	<!-- Подвал -->
	<?php include '../components/footer.php' ?>
</body>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    // Устанавливаем минимальную дату для поля "Дата посещения"
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('input--date').setAttribute('min', today);

    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        alert('Пожалуйста, исправьте ошибки в форме');
      }
    });
  });
</script>

</html>