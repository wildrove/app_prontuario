<?php

	session_start();

	require '../../vendor/autoload.php';

	use Classes\Users\Users;

	$userLogged = false;
	$levelAccess = null;
	$userName = null;

	$userForm = strtoupper($_POST['userName']);
	$passForm = $_POST['userPass'];

	$user = new Users();

	$users = $user->findUserLogin($userForm);


	foreach($users as $value) {

		if($value['NOME'] == $userForm && $value['SENHA'] == $passForm) {
				$userLogged = true;
				$levelAccess = $value['TIPO_USUARIO'];
				$userName = $value['NOME'];
		}
	}

	if($userLogged) {
			$_SESSION['usuario_autenticado'] = 'SIM';
			$_SESSION['usuario_nivel_acesso'] = $levelAccess;
			$_SESSION['nome_usuario'] = $userName;

			if($_SESSION['usuario_nivel_acesso'] == 'Administrador') {
				header('Location: ../../forms/content-home-admin.php');

			} else {
				header('Location: ../../home.php');
			}

	} else {
			$_SESSION['usuario_autenticado'] = 'NÃO';
			header('Location: ../../index.php?login=erro');
		}


