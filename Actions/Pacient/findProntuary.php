<?php
	
	session_start();
	require '../../vendor/autoload.php';
	require('../../RtfCleanText/cleanRtf.php');

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	$pacientRegistry = intval($_GET['regProntuary']);
	$hourEvo = $_GET['hourEvolution'];

	var_dump($pacientRegistry) . '<br>';
	var_dump($hourEvo);
/*
	$pacientEvolution = new PacientEvolution();

	// FindPacientEvolution faz uma consulta no banco para encontrar a evolução do paciente, e changeColummnValue altera o valor da coluna TIPO.
	$pacientEvo = $pacientEvolution->changeColumnValue($pacientEvolution->findPacientEvolution($pacientRegistry), 'TIPO');


	// VERIFICA SE A CONSULTA NÃO RETORNA VAZIO
	if (empty($pacientEvo)) {
		header('Location: ../../AlertsHTML/alertNoneEvolutionFound.html');

	}
	
	foreach ($pacientEvo as $key => $value) {
		$pacientEvo[$key]['EVOLUCAO'] = rtf2text($pacientEvo[$key]['EVOLUCAO']);
	}

	echo "<pre>";
	print_r($pacientEvo);

*/










