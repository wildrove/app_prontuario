<?php
	
	require '../../vendor/autoload.php';
	use Classes\Users\Users;


	$name = strtoupper(utf8_encode($_POST['fullName']));
	$userName = strtoupper(utf8_encode($_POST['userName']));
	$pass = utf8_encode($_POST['userPass']);
	$userType = utf8_encode($_POST['userType']);
	$userCpf = $_POST['userCPF'];

	$newUser = new Users();

	if (strlen($pass) > 10) {
		header("Location: ../../AlertsHTML/validateUser/invalidPass.html");
	}

	// validação de novo usuário
	if (count($newUser->findUser($name, $userName, $userCpf, $pass, $userType)) > 0) {
		header("Location: ../../AlertsHTML/validateUser/alertUserFound.html");

	}else {
		// insere novo usuario
		if($newUser->insertNewUser($name, $userName, $userCpf, $pass, $userType) > 0){
			header("Location: ../../AlertsHTML/validateUser/alertUserInserted.html");

		}else{
			header("Location: ../../AlertsHTML/validateUser/alertUserInsertFail.html");
		}
	}

	



