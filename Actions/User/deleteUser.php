<?php
	require '../../vendor/autoload.php';
	require 'validateAccessFile.php';
	use Classes\Users\Users;

	$idUser = intval($_GET['idUser']);

	$validateUser = new Users();

	if (!empty($idUser)) {
		if ($validateUser->deleteUser($idUser)) {
			header("Location: ../../AlertsHTML/validateuser/alertUserDeleted.html");
			exit();
		}
	}