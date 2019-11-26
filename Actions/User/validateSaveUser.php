<?php
	require '../../vendor/autoload.php';
	use Classes\users\Users;

	$countRows = count($_POST);
	$id = intval($_POST['userId']);
	$name = strtoupper($_POST['userName']);
	$user = strtoupper($_POST['user']);
	$cpf = $_POST['userCpf'];
	$pass = $_POST['userPass'];
	$type = utf8_decode($_POST['userType']);

	$userValidate = new Users();

	if ($countRows > 1) {
		if($userValidate->updateUser($id, $name, $user, $cpf, $pass, $type) == true){
			header("Location: ../../AlertsHTML/validateUser/alertUserUpdated.html");
			exit();
		}

	}


