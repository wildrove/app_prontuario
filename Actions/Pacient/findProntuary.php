<?php
	
	session_start();
	require '../../vendor/autoload.php';

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	$pacientRegistry = intval($_GET['prontuario']);

	$pacientEvolution = new PacientEvolution();

	echo '<pre>';
	var_dump($pacientEvolution->findPacientEvolution($pacientRegistry));



