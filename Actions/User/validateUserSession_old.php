<?php

	session_start();

	$usuario_logado = false;
	$usuario_id = null;
	$nivel_acesso = null;
	$nome_usuario = null;
	$usuario_email = null;

	$usuarios = array(
		array('id' => 1,'nome' => 'wilder', 'email' => 'wilder@gmail.com', 'senha' => 12345, 'nivel_acesso' => 'Administrador'),
		array('id' => 2,'nome' => 'admin', 'email' => 'admin@gmail.com', 'senha' => 12345, 'nivel_acesso' => 'Administrador'),
		array ('id' => 3,'nome' => 'julia', 'email' => 'julia@gamil.com', 'senha' => 12345, 'nivel_acesso' => 'Usuario' ),
		array('id' => 4, 'nome' => 'joelma', 'email' => 'joelma@gmail.com', 'senha' => 12345, 'nivel_acesso' => 'Usuario')
	);
	// percorrer o array e verificar se os dados
	//vindos do formuário são iguais aos do array
	// em seguida atribui os dados do array a variaveis

	foreach($usuarios as $user) {

		if($user['nome'] == $_POST['userName'] && $user['senha'] == $_POST['userPass']) {
				$usuario_logado = true;
				$usuario_id = $user['id'];
				$nivel_acesso = $user['nivel_acesso'];
				$nome_usuario = $user['nome'];
				$usuario_email = $user['email'];

		}
	}

	if($usuario_logado) {
			$_SESSION['usuario_autenticado'] = 'SIM';
			$_SESSION['usuario_nivel_acesso'] = $nivel_acesso;
			$_SESSION['nome_usuario'] = $nome_usuario;
			$_SESSION['email_usuario'] = $usuario_email;

			if($_SESSION['usuario_nivel_acesso'] == 'Administrador') {
				header('Location: ../../home.php');

			} else {
				header('Location: ../../home.php');
			}

	} else {
			$_SESSION['usuario_autenticado'] = 'NÃO';
			header('Location: ../../index.php?login=erro');
		}

?>

