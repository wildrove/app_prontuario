<?php
	
	require '../../vendor/autoload.php';
	use Classes\Users\Users;
	session_start();

	$name = strtoupper(utf8_encode($_POST['fullName']));
	$userName = strtoupper(utf8_encode($_POST['userName']));
	$userPass = utf8_encode($_POST['userPass']);
	$userType = utf8_encode($_POST['userType']);
	$userCpf = $_POST['userCPF'];

	$createUser = new Users();

	if (strlen($name) > 30) {
		header("Location: ../../AlertsHTML/validateUser/invalidPass.html");
	}

	if (strlen($userName) > 10) {
		header("Location: ../../AlertsHTML/validateUser/invalidPass.html");
	}

	if (strlen($userCpf) > 11) {
		header("Location: ../../AlertsHTML/validateUser/invalidPass.html");
	}

	if (strlen($userPass) > 10) {
		header("Location: ../../AlertsHTML/validateUser/invalidPass.html");
	}

	$newUser = $createUser->findUserLogin($userName);


	foreach ($newUser as $value) {

		if(count($newUser) > 0 && $value['NOME'] == $userName) {
			header("Location: ../../AlertsHTML/validateUser/alertUserFound.html");
			exit();
		}
	}

	// insere novo usuario
	if($createUser->insertNewUser($name, $userName, $userCpf, $userPass, $userType)){

			header("Location: ../../AlertsHTML/validateUser/alertUserInserted.html");

	}else{
			header("Location: ../../AlertsHTML/validateUser/alertUserInsertFail.html");
	}




