<?php
	session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Online -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Bootstrap Local -->  
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Link Personal style.css -->
    <link rel="stylesheet"  href="bootstrap/css/style.css">

     <!-- Fontawesome link -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">

     <!-- Favicon -->
     <link rel="shortcut icon" href="caminhodoarquivo/favicon.ico" />

</head>
<body>
	<?php 
		/* ==== Trecho de código que encerra a sessão do usuário após 0:15min inativo === 
        ini_set('session.use_trans_sid', 0);
        if (!isset($_SESSION['usuario_autenticado'])){
          $_SESSION['usuario_autenticado'] = "Guest";
        }
        if ($_SESSION['usuario_autenticado'] != "Guest"){
          $counter = time();
          if (!isset($_SESSION['count'])){
            $_SESSION['count'] = $counter;
          }
          if ($counter - $_SESSION['count'] >= 900){
            header('Location: ../../App_prontuario/index.php?login=erro4');
          }
            $_SESSION['count'] = $counter;
        }

      */  
		// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
		if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
			header('Location: index.php?login=erro2');
			exit();
		}
		//require_once('Actions/User/validateAccessFile.php');
		require('forms/header.php');
		require('forms/content-home.php');



	?>

</body>
</html>