<?php
	
	require '../../vendor/autoload.php';

	use Classes\Pacient\Pacient;

	$pacient = new Pacient();


	//Receber a requisição da Pesquisa
	$requestaData = $_REQUEST;

	// Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
	$columns = array(
    array( '0' => 'REGISTRO_PRONTUARIO'),
    array( '1' => 'NOME'),
    array( '2' => 'DATA_NASCIMENTO'),
    array( '3' => 'DOCUMENTO'),
    array('4' => 'NOME_MAE'),
    array('5' => 'TELEFONE')
   );

	//Obtendo registros do número total sem qualquer pesquisa
	$result_user = $pacient->findPacient($nomePaciente, $dataNascimento);

	$qtd_rows_pacient = count($result_user);

	// Obter os dados a serem apresentados 
	$totalPacientFiltered = $result_user;


	//Ordenar o resultado
	$result_user.=" ORDER BY ". $columns[$requestaData['order'][0]['column']]. "  ".$requestaData['order'][0]['dir']." LIMIT ".$requestaData['start']." ,".$requestaData['length']." ";
	$totalPacientFiltered = $result_user; // =mysqli_query($conn, $resultusuarios);

	// lear e criar o array de dados
	$dados = array();
	//while($qtd_rows_pacient =mysqli_fetch_array($totalPacientFilterd))
	while ($qtd_rows_pacient = $totalPacientFiltered->fetch(PDO::FETCH_ASSOC)) {
		
		$dado = array();
		$dado[] = $row_pacient['REGISTRO_PRONTUARIO'];
		$dado[] = $row_pacient['NOME'];
		$dado[] = $row_pacient['DATA_NASCIMENTO'];
		$dado[] = $row_pacient['DOCUMENTO'];
		$dado[] = $row_pacient['NOME_MAE'];
		$dado[] = $row_pacient['TELEFONE'];

		$dados = $dado;
	}

	// Criar array de informações a serem retornadas para o Javascript

	$json_data = array(
		"draw": => intval($requestaData['draw']), //para cada requisição é enviado um número como parâmetro
		 "recordsTotal": => intval($qtd_rows_pacient), // quantidades de registros que há no banco de dados
		 "recordsFiltered": => intval($totalPacientFiltered), //total de registros quando houver pesquisa
		 "data" => $dados; // Array de dados completo dos dados retornados da tabela

	);

	echo json_encode($json_data); //enviar dados como formato json



