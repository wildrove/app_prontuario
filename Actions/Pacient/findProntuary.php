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
			//$pacientEvo[$key]['EVOLUCAO'] = preg_replace("[\'e7]", "ç", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\par", " ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e7", "ç", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'f3", "ó", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\rtf1", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\rtf1", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\ansi\ansicpg1252\\deff0\\deflang1046", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("{{", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\fonttbl{\\f0\\fnil\\fcharset0 Arial;}}", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\viewkind4\\uc1 d\\fs18", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("}", "", $pacientEvo[$key]['EVOLUCAO']);


			echo "<pre>";
			var_dump($pacientEvo[$key]['EVOLUCAO']);
			
		}
	}

	//strip_tags(html_entity_decode($pacientEvo[$key]['EVOLUCAO']));
	// $pacientEvo[$key]['EVOLUCAO'] = str_replace("\\", "", $pacientEvo[$key]['EVOLUCAO']);





