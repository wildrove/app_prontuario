<?php
	session_start();
	// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
		
	}
	
	require '../../vendor/autoload.php';
	
	use Classes\Users\Users;

	$name = strtoupper($_POST['fullName']);
	$userName = strtoupper($_POST['userName']);
	$userPass = $_POST['userPass'];
	$userType = $_POST['userType'];
	$userCpf = $_POST['userCPF'];

	$createUser = new Users();
	//$createUser->deleteUser();exit();
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




