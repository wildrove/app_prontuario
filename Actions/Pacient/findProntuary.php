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
			
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\par", " ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e7", "ç", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'f3", "o", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e9", "e", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e3", "ã", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e1", "á", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'d3", "ó", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'ed", "í", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'cd", "í", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u231?\\u245?\\f0 ", "çõ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'b0", "°", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'f5", "õ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'c7\\'d5", "çõ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'c1", "á", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e2", "â", $pacientEvo[$key]['EVOLUCAO']);


			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\rtf1\\ansi\\ansicpg1252\\deff0\\deflang1046", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\fonttbl", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f0\\fnil\\fcharset0 Arial;", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\fswiss\\fprq2\\fcharset128 Arial;", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\viewkind4\\uc1 d\\qc\\b\\fs18", "", $pacientEvo[$key]['EVOLUCAO']);

			$pacientEvo[$key]['EVOLUCAO'] = preg_replace("[{{{}{}}]", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\b0", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\nowidctlpar\\hyphpar0", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\b", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\kerning1", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\kerning0", "", $pacientEvo[$key]['EVOLUCAO']);


			echo "<pre>";
			var_dump($pacientEvo[$key]['EVOLUCAO']);exit();

			//echo "<pre>";
			//echo '<h1>Qunatidade: </h1>' . '<h1>' . count($pacientEvo) . '</h1>';

			// PESQUISAR Convert RTF to Plain Text

		
			
		}
	}

	//strip_tags(html_entity_decode($pacientEvo[$key]['EVOLUCAO']));
	// $pacientEvo[$key]['EVOLUCAO'] = str_replace("\\", "", $pacientEvo[$key]['EVOLUCAO']);
	//$pacientEvo[$key]['EVOLUCAO'] = preg_replace("[\'e7]", "ç", $pacientEvo[$key]['EVOLUCAO']);




