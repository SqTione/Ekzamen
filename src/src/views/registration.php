<!DOCTYPE html>
<html lang="ru">

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
			<form action="../services/RegisterService.php" method='post' class='auth__form form' id='register-form' enctype="multipart/form-data">
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

					<label for="input--phone" style='display: none;'>Телефон</label>
					<input type="tel" class="form__input" placeholder='Номер телефона' name="phone" required pattern="^(\+7|8)[\d]{10}$" id='input--phone'>
					<p class="error-message">*Поле обязательно для заполнения. <br> Введите корректный номер телефона (+7(8)9123456789) </p>

					<label for="input--dob" style='display: none;'>Дата рождения</label>
					<input type="date" class="form__input" name="dob" required id="input--dob" max="" />
					<p class="error-message">*Поле обязательно для заполнения. <br> Укажите валидную дату рождения</p>

					<label for="input--gender" style='display: none;'>Пол</label>
					<select class="form__input" name="gender" required id="input--gender">
						<option value="">Выберите пол</option>
						<option value="male">Мужской</option>
						<option value="female">Женский</option>
					</select>
					<p class="error-message">*Поле обязательно для заполнения.</p>

					<label for="input--certificate" style='display: none;'>Медицинская справка (PDF)</label>
					<input type="file" class="form__input" name="certificate" accept="application/pdf" required id="input--certificate">
					<p class="error-message">*Поле обязательно для заполнения. <br> Загрузите скан медицинской справки в формате PDF.</p>

					<label for="input--password" style='display: none;'>Пароль</label>
					<input type="password" class="form__input" placeholder='Пароль' name="password" required minlength="8"
						pattern="^[A-Za-z0-9!@#$%^&*()_+={}\[\]:;,.<>?/-]*$" id='input--password'>
					<p class="error-message">*Поле обязательно для заполнения. <br> Пароль должен содержать минимум 8 символов</p>

					<label for="input--password-repeat" style='display: none;'>Повтор пароля</label>
					<input type="password" class="form__input" placeholder='Повтор пароля' name="password_repeat" required minlength="8"
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
		// Установка максимальной даты для поля Дата рождения
		const today = new Date().toISOString().split('T')[0];
		document.getElementById('input--dob').setAttribute('max', today);

		// Проверка совпадения паролей
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

	form.addEventListener('submit', (event) => {
      if (!form.checkValidity()) {
        event.preventDefault();
        alert('Пожалуйста, исправьте ошибки в форме');
      }
    });
</script>

	<!-- Подвал -->
	<?php include '../components/footer.php' ?>
</body>

</html>