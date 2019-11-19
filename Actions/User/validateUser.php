<?php
	
	require '../../vendor/autoload.php';
	use Classes\Users\Users;


	$name = strtoupper(utf8_encode($_POST['fullName']));
	$userName = strtoupper(utf8_encode($_POST['userName']));
	$pass = utf8_encode($_POST['userPass']);
	$userType = utf8_encode($_POST['userType']);
	$userCpf = $_POST['userCPF'];

	if (strlen($pass) > 10) {
		header("Location: ../../AlertsHTML/invalidPass.html");
	}

	$newUser = new Users();
	
	if($newUser->insertNewUser($name, $userName, $userCpf, $pass, $userType) > 0){
		header("Location: ../../AlertsHTML/alertUserInserted.html");
	}else{
		header("Location: ../../AlertsHTML/alertUserInsertFail.html");
	}


