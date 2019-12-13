<?php
	session_start();
	// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
		
	}elseif(isset($_SESSION['usuario_nivel_acesso']) && $_SESSION['usuario_nivel_acesso'] != 'Administrador'){
        header('Location: ../../index.php?login=erro3');
        session_destroy();
        exit();
    }
	
	require '../../vendor/autoload.php';

	use Classes\users\Users;

	$countRows = count($_POST);
	$id = intval($_POST['userId']);
	$name = strtoupper($_POST['userName']);
	$user = strtoupper($_POST['user']);
	$cpf = $_POST['userCpf'];
	$pass = $_POST['userPass'];
	$type = $_POST['userType'];

	$userValidate = new Users();

	if ($countRows > 1) {
		if($userValidate->updateUser($id, $name, $user, $cpf, $pass, $type) == true){
			header("Location: ../../AlertsHTML/validateUser/alertUserUpdated.html");
			exit();
		}

	}


