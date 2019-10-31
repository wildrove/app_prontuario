<?php
	
	session_start();
	require '../../vendor/autoload.php';

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	$pacientRegistry = intval($_GET['prontuario']);

	$pacientEvolution = new PacientEvolution();

	$pacientEvo = $pacientEvolution->findPacientEvolution($pacientRegistry);

	// Verifica a chave TIPO e altera o valor.
	foreach ($pacientEvo as $key => $value) {

		if ($pacientEvo[$key]['TIPO'] == 'CRM') {
			$pacientEvo[$key]['TIPO'] = 'MÉDICO';

		}elseif ($pacientEvo[$key]['TIPO'] == 'CRN') {
			$pacientEvo[$key]['TIPO'] = 'NUTRICIONISTA';

		}elseif ($pacientEvo[$key]['TIPO'] == 'CRP ') {
			$pacientEvo[$key]['TIPO'] = 'PSICÓLOGO';

		}elseif ($pacientEvo[$key]['TIPO'] == 'COREN') {
			$pacientEvo[$key]['TIPO'] = 'ENFERMAGEM';

		}elseif ($pacientEvo[$key]['TIPO'] == 'CREFITO') {
			$pacientEvo[$key]['TIPO'] = 'FISIOTERAPEUTA';
		}
	}


	foreach ($pacientEvo as $key => $value) {
		if ($pacientEvo[$key]['EVOLUCAO']) {
			echo "<pre>";
			print_r($pacientEvo[$key]['EVOLUCAO']);
			exit();
		}
	}




	$x = strip_tags(html_entity_decode($pacientEvo['EVOLUCAO']));

	print_r($x);



