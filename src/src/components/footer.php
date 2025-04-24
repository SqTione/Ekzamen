<?php require_once '../utils/check_auth.php' ?>

<footer class='footer'>
	<div class="container">
		<a href="<?php header('Location: /src/views/profile.php') ?>" class="logo">
			<p>CoolPool</p>
		</a>

		<nav class="footer__nav">
			<?php if (!checkAuth()) {
				echo '<a href="../views/login.php">Вход</a>';
				echo '<a href="../views/registration.php">Регистрация</a>';
			} else {
				echo '<a href="../views/profile.php">Профиль</a>';
				echo '<a href="../views/admin_panel.php">Панель администратора</a>';
			}
			?>
		</nav>
	</div>
</footer>