<?php
	
	session_start();
	require '../../vendor/autoload.php';
	require('../../RtfCleanText/cleanRtf.php');

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	$pacientRegistry = intval($_GET['regProntuary']);
	$hourEvo = $_GET['hourEvolution'];
	$dateEvo = $_GET['dateEvolution'];


	$pacientEvolution = new PacientEvolution();

	// Procura a evolução do paciente na tabela PEP_EVOLUCAO_MEDICA OU EVOLUCAO_WARELINE (SISTEMA ANTIGO)
	$pacientEvo = $pacientEvolution->pacientEvo($pacientRegistry,$dateEvo,$hourEvo);

		
	// VERIFICA SE A CONSULTA NÃO RETORNA VAZIO
	if (empty($pacientEvo)) {
		header('Location: ../../AlertsHTML/alertNoneEvolutionFound.html');

	}
	
	foreach ($pacientEvo as $key => $value) {
		$pacientEvo[$key]['EVOLUCAO'] = rtf2text(utf8_encode($pacientEvo[$key]['EVOLUCAO']));
	}

	// Função para substituir os caracteres especiais por letras com acento.
	$pacientEvo = $pacientEvolution->convertEvoLetter($pacientEvo, 'EVOLUCAO');

	foreach ($pacientEvo as $value) {
		echo "<pre>";
		echo $value['EVOLUCAO'];
	}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
    <!-- Bootstrap Online -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Bootstrap Local -->  
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Link Personal style.css -->
    <link rel="stylesheet"  href="../../bootstrap/css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

</body>
</html>










