<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Вход</title>
	<link rel="stylesheet" href="../css/style.css">
	<script src="../js/script.js"></script>
</head>

<body>
	<!-- Шапка -->
	<?php include '../components/header.php' ?>

	<!-- Основной контент -->
	<div class="app">
		<main class="main container auth__container">
			<!-- Форма авторизации -->
			<form action="../services/LoginService.php" method='post' class='auth__form form'>
				<div class="form__header">
					<h1>Вход</h1>
					<p>Нет аккаунта? <a href="./registration.php">Зарегистрируйтесь!</a></p>
				</div>
				<div class="form__body">
					<label for="input--email" style='display: none;'>Email</label>
					<input type="email" class="form__input" placeholder='Email' name="email" required id='input--email'>
					<p class="error-message">*Поле обязательно для заполнения. <br> Введите корректный Email-адрес </p>

					<label for="input--password" style='display: none;'>Пароль</label>
					<input type="password" class="form__input" placeholder='Пароль' name="password" required minlength="8"
						pattern="^[A-Za-z0-9!@#$%^&*()_+={}\[\]:;,.<>?/-]*$" id='input--password'>
					<p class="error-message">*Поле обязательно для заполнения. <br> Пароль должен содержать минимум 8 символов</p>
				</div>
				<div class="form__footer">
					<button type="submit" class='button button--primary'>Войти</button>
				</div>
			</form>
		</main>
	</div>

	<!-- Подвал -->
	<?php include '../components/footer.php' ?>
</body>

</html>