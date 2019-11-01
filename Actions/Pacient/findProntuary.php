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
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e7", "Ç", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'f3", "O", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e9", "E", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e3", "Ã", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e1", "Á", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'d3", "Ó", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'ed", "Í", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'cd", "Í", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u231?\\u245?\\f0 ", "ÇÕ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'b0", "°", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'f5", "Õ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'c7\\'d5", "ÇÕ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'c1", "Á", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'e2", "Ã", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u225?\\f0 ", "Á", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u231?\\u227?\\f0 ", "ÇÃ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u237?\\f0 ", "Í", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u233?\\f0 ", "É", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'f4", "Ó", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'ea", "Ê", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'c3", "Ã", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'c7", "Ç", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\'c9", "É", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u243?\\f0 ", "Ó", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u250?\\f0 ", "Ú", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u199?\\u195?\\f0 ", "ÇÃ", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\u195?\\f0 ", "Ã", $pacientEvo[$key]['EVOLUCAO']);



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
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f2\\fswiss\\fprq2\\fcharset0 Arial;", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = preg_replace("[{{{}{}{}}]", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = preg_replace("[{{{}}]", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\viewkind4\uc1 ", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\fs20", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\fs19", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\fs18", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\ltrpar\\f2\\fs18", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\ltrpar\\fs20", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace(" d ", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\i0", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\i", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\ltrpar\\qc\\f0\\fs28", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\rtf1\\fbidis\\ansi\\ansicpg1252\\deff0\\deflang1046", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f0\\fswiss\\fprq2\\fcharset0 Arial;", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\fnil\\fprq2\\fcharset2 Wingdings;", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f2\\fnil\\fcharset0 Arial;", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = preg_replace("[{{{}{}{}}]", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\f1\\'e0\\f0", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\lang1046", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\lang1033", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\fs20", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\hyphpar0\\qc\\fs18", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\hyphpar0", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\fi-2160\\li2160 ", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\hyphpar0", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = preg_replace("[{{{}{}}]", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\ltrpar\\nowidctlpar\\hyphpar0\\fs18", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("d\\ltrpar", "", $pacientEvo[$key]['EVOLUCAO']);
			$pacientEvo[$key]['EVOLUCAO'] = str_replace("\\hyphpar0\\fs16", "", $pacientEvo[$key]['EVOLUCAO']);

			
			





			echo "<pre>";
			print_r(strtoupper($pacientEvo[$key]['EVOLUCAO']));exit();

			//echo "<pre>";
			//echo '<h1>Qunatidade: </h1>' . '<h1>' . count($pacientEvo) . '</h1>';

			// PESQUISAR Convert RTF to Plain Text

		
			
		}
	}

	//strip_tags(html_entity_decode($pacientEvo[$key]['EVOLUCAO']));
	// $pacientEvo[$key]['EVOLUCAO'] = str_replace("\\", "", $pacientEvo[$key]['EVOLUCAO']);
	//$pacientEvo[$key]['EVOLUCAO'] = preg_replace("[\'e7]", "ç", $pacientEvo[$key]['EVOLUCAO']);
	//echo "<center><a href='javascript:window.history.go(-1)' class='btn btn-primary'>Voltar</a>";




