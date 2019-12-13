<?php
	session_start();
	require '../../vendor/autoload.php';
	// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
	}elseif(isset($_SESSION['usuario_nivel_acesso']) && $_SESSION['usuario_nivel_acesso'] != 'Administrador'){
        header('Location: ../../index.php?login=erro3');
        session_destroy();
        exit();
    }
    
	use Classes\Users\Users;

	$idUser = intval($_GET['idUser']);

	$validateUser = new Users();

	if (!empty($idUser)) {
		$validateUser->deleteUser($idUser);
			header("Location: ../../AlertsHTML/validateuser/alertUserDeleted.html");
			exit();
	}