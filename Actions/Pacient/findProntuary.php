<?php
	
	session_start();
	require '../../vendor/autoload.php';

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	$pacientRegistry = intval($_GET['prontuario']);

	$pacientEvolution = new PacientEvolution();

	$pacientEvolution->findPacientEvolution($pacientRegistry);

	$pacientEvo = $pacientEvolution->findPacientEvolution($pacientRegistry);

	// Verifica a chave TIPO e altera o valor.
	$pacientEvolution->changeColumnType($pacientEvo, 'TIPO');




	$evolution = null;

	foreach ($pacientEvo as $key => $value) {	

		if ($pacientEvo[$key]['EVOLUCAO']) {
			$evolution = $pacientEvo[$key]['EVOLUCAO'];
		}
	}

	require('../../cleanRtf.php');

	echo "<pre>";
	print_r(rtf2text($evolution));exit();








