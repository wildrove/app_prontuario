<?php

	session_start();

	require '../../vendor/autoload.php';

	use Classes\Users\Users;

	$userLogged = false;
	$levelAccess = null;
	$userName = null;

	$userForm = strtoupper($_POST['userName']);
	$passForm = strtoupper($_POST['userPass']);

	$user = new Users();

	$users = $user->findUserLogin($userForm);


	foreach($users as $value) {

		if($value['NOME'] == $userForm && $value['SENHA'] == $passForm) {
				$userLogged = true;
				$levelAccess = $value['TIPO_USUARIO'];
				$userName = $value['NOME'];
				$name = explode(" ", $value['NOME_COMPLETO']);
				$name = $name[0];

		}
	}

	if($userLogged) {
			$_SESSION['usuario_autenticado'] = 'SIM';
			$_SESSION['usuario_nivel_acesso'] = $levelAccess;
			$_SESSION['nome_usuario'] = $name;

			if($_SESSION['usuario_nivel_acesso'] == 'Administrador') {
				header('Location: ../../forms/content-home-admin.php');

			} else {
				header('Location: ../../forms/content-home-user.php');
			}

	} else {
			$_SESSION['usuario_autenticado'] = 'NÃO';
			header('Location: ../../index.php?login=erro');
		}


	


