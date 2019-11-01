<?php

	session_start();
	require '../../vendor/autoload.php';

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	$pacientRegistry = intval($_GET['prontuario']);


	$pacientEvolution = new PacientEvolution();
	$pacientEvo = $pacientEvolution->findPacientEvolution($pacientRegistry);

	$evolution = null;

	foreach ($pacientEvo as $key => $value) {
		if ($pacientEvo[$key]['EVOLUCAO']) {
			$evolution = $pacientEvo[$key]['EVOLUCAO'];
		}

	}

	use RtfHtmlPhp\Document;

	$document = new Document($evolution);








