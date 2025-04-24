<?php
session_start();

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