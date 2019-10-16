<?php
	
	require '../../vendor/autoload.php';

	use Classes\Pacient\Pacient;

	$nomePaciente = $_POST['paciente'];
	$dataNascimento = $_POST['dtNasc'];

	$pacient = new Pacient();

	echo '<pre>';
	print_r($pacient->findPacient($nomePaciente));