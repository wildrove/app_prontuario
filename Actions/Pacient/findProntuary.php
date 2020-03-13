<?php
	
	session_start();
	require '../../vendor/autoload.php';
	require('../../RtfCleanText/cleanRtf.php');

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	$pacientRegistry = intval($_GET['regProntuary']);
	$hourEvo = $_GET['hourEvolution'];
	$dateEvo = $_GET['dateEvolution'];


	$pacientEvolution = new PacientEvolution();

	// Procura a evolução do paciente na tabela PEP_EVOLUCAO_MEDICA OU EVOLUCAO_WARELINE (SISTEMA ANTIGO)
	$pacientEvo = $pacientEvolution->pacientEvo($pacientRegistry,$dateEvo,$hourEvo);

	
	// VERIFICA SE A CONSULTA NÃO RETORNA VAZIO
	if (empty($pacientEvo)) {
		header('Location: ../../AlertsHTML/alertNoneEvolutionFound.html');
	}
	
	// Função para limpar o texto da evolução e remover caracteres indesejados
	foreach ($pacientEvo as $key => $value) {
		$pacientEvo[$key]['EVOLUCAO'] = rtf2text(utf8_encode($pacientEvo[$key]['EVOLUCAO']));
	}

	// Função para substituir os caracteres especiais por letras com acento.
	$pacientEvo = $pacientEvolution->convertEvoLetter($pacientEvo, 'EVOLUCAO');


	// Verifica se alguma evolução não foi preenchida.
	foreach ($pacientEvo as  $value) {
		if ($value['EVOLUCAO'] == "") {
			header('Location: ../../AlertsHTML/alertNoneEvolutionWritten.html');
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="ISO-8859-1">
    <!-- Bootstrap Online -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Link Personal style.css -->
    <link rel="stylesheet" type="text/css"  href="../../bootstrap/css/style.css">
	<!-- Bootstrap Local -->  
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"> 
    

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
	<?php 

		require '../../forms/header-evolution.php'
	?>
	<!-- Sessão de cabeçalho -->
	<section class="container-fluid" style="margin-top: 130px;">
		<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-lg">
			<form method="" action="">
				<div style="width: 20%">
					<h4 class="">Dados do Paciente</h4>
				</div>
				<div class="row cabecalho p-2"><!-- Inicio Linha 1 -->
					<div class="form-group">
						<label class="col-form-label border-bottom border-info">Paciente:</label>
						<input class="form-control-plaintext" type="text" name="nomePaciente">
					</div>
					<div class="form-group">
						<label class="col-form-label border-bottom border-info">Dt. Nasc:</label>
						<input class="form-control-plaintext" type="date" name="nascimento">
					</div>
					<div class="form-group">
						<label class="col-form-label border-bottom border-info">Mãe:</label>
						<input class="form-control-plaintext" type="text" name="nomeMae">
					</div>
					<div class="form-group">
						<label class="col-form-label border-bottom border-info">Prontuário:</label>
						<input class="form-control-plaintext" type="text" name="prontuario">
					</div>
					<div class="form-group">
						<label class="col-form-label border-bottom border-info">Reg. Paciente:</label>
						<input class="form-control-plaintext" type="text" name="regPaciente">
					</div>
					<div class="form-group">
						<label class="col-form-label border-bottom border-info">Dt. Evolução:</label>
						<input class="form-control-plaintext" type="date" name="dtEvo">
					</div>
					<div class="form-group">
						<label class="col-form-label border-bottom border-info">Tipo Evolução:</label>
						<input class="form-control-plaintext" type="text" name="tipoEvo">
					</div>
				</div><!-- Fim Linha 1 -->
			</form>
		</nav>
	</section><!-- Fim Sessão cabeçalho -->

	<div class="container-fluid p-3" style="margin-top: 30px;">
		<h1 style="text-align: center;">Evolução do paciente</h1>
		<p class="text-break">
			<?php 
				foreach ($pacientEvo as $value) {
					echo "<pre style='font-family: Arial;font-size: 75%;'>";
					echo strtoupper(wordwrap($value['EVOLUCAO'], 160, "<br />", true));
				}
			?>	
		</p>
		<div class="d-flex justify-content-center">
			<button type="button" class="btn btn-primary btn-lg" onclick="goBack()">Voltar</button>
			<a href="exportEvoDoc.php?regProntuary=<?php echo $pacientRegistry . '&' . 'hourEvolution=' . $hourEvo . '&' . 'dateEvolution=' . $dateEvo;  ?>" class="btn btn-primary btn-lg ml-5">Exportar evolução</a>
		</div>	
	</div>
	<script type="text/javascript">
		function goBack(){
			window.history.go(-1);
		}
	</script>
</body>
</html>










