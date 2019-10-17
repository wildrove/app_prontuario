<?php
	
	require '../../vendor/autoload.php';

	use Classes\Pacient\Pacient;

	$nomePaciente = strtoupper($_POST['paciente']);
	$dataNascimento = $_POST['dtNasc'];

	$pacient = new Pacient();

	if($nomePaciente == null && $dataNascimento == null){
					
		echo '<h1 style="text-align: center; color: #fff; background-color: red; padding: 20px;">Dados Inválidos!</h1>';
		echo "<button><a href='../../home.php'>Voltar</button>";
		exit;



	}

	echo '<pre>';
	print_r($pacient->findPacient($nomePaciente, $dataNascimento));