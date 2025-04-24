<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Регистрация</title>
	<link rel="stylesheet" href="../css/style.css">
	<script src="../js/script.js"></script>
</head>

<body>
	<!-- Шапка -->
	<?php include '../components/header.php' ?>

	<!-- Основной контент -->
	<div class="app">
		<main class="main container auth__container">
			<!-- Форма регистрации -->
			<form action="../services/LoginService.php" method='post' class='auth__form form' id='register-form'>
				<div class="form__header">
					<h1>Регистрация</h1>
					<p>Уже зарегистрированы? <a href="./login.php">Войдите!</a></p>
				</div>
				<div class="form__body">
					<label for="input--surname" style='display: none;'>Фамилия</label>
					<input type="text" class="form__input" placeholder='Фамилия' name="surname" required id='input--surname'>
					<p class="error-message">*Поле обязательно для заполнения.</p>

					<label for="input--name" style='display: none;'>Имя</label>
					<input type="text" class="form__input" placeholder='Имя' name="name" required id='input--name'>
					<p class="error-message">*Поле обязательно для заполнения.</p>

					<label for="input--patronymic" style='display: none;'>Отчество</label>
					<input type="text" class="form__input" placeholder='Отчество' name="patronymic" id='input--patronymic'>

					<label for="input--email" style='display: none;'>Email</label>
					<input type="email" class="form__input" placeholder='Email' name="email" required id='input--email'>
					<p class="error-message">*Поле обязательно для заполнения. <br> Введите корректный Email-адрес </p>

					<label for="input--password" style='display: none;'>Пароль</label>
					<input type="password" class="form__input" placeholder='Пароль' name="password" required minlength="8"
						pattern="^[A-Za-z0-9!@#$%^&*()_+={}\[\]:;,.<>?/-]*$" id='input--password'>
					<p class="error-message">*Поле обязательно для заполнения. <br> Пароль должен содержать минимум 8 символов</p>

					<label for="input--password-repeat" style='display: none;'>Повтор пароля</label>
					<input type="password" class="form__input" placeholder='Повтор пароля' name="password" required minlength="8"
						pattern="^[A-Za-z0-9!@#$%^&*()_+={}\[\]:;,.<>?/-]*$" id='input--password-repeat'>
					<p class="error-message">*Поле обязательно для заполнения. <br> Пароли не совпадают</p>
				</div>
				<div class="form__footer">
					<button type="submit" class='button button--primary'>Зарегистрироваться</button>
				</div>
			</form>
		</main>
	</div>

	<script>
  document.addEventListener('DOMContentLoaded', () => {
    let password = document.getElementById('input--password');
    let passwordRepeat = document.getElementById('input--password-repeat');
    let form = document.getElementById('register-form');

    password.addEventListener('input', validatePasswords);
    passwordRepeat.addEventListener('input', validatePasswords);

    function validatePasswords() {
      if (password.value !== passwordRepeat.value) {
        passwordRepeat.setCustomValidity('Пароли не совпадают');
      } else {
        passwordRepeat.setCustomValidity('');
      }
    }

    form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        alert('Form is invalid');
      }
    });
  });
</script>

	<!-- Подвал -->
	<?php include '../components/footer.php' ?>
</body>

</html>