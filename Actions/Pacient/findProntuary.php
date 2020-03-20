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
	<meta charset="UTF-8">
	<!-- Bootstrap Local -->  
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<!-- Link Personal style.css -->
    <link rel="stylesheet" href="../../css/estilo.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
	<?php require '../../forms/header-evolution.php' ?><!-- Cabeçalho -->
	<div class="container-fluid">		
		<section class="" style="margin-top: 130px;"><!-- Sessão de cabeçalho -->
				<form class="form text-form bg-light shadow-lg p-5" method="post" action="dataPrint.php">
					<h4 class="">Dados do Paciente</h4>
					<div class="row p-2 border border-dark mb-3" style="font-family: Arial, Helvetica, sans-serif;"><!-- Inicio Linha 1 -->
						<div class="form-group pacient-group">
							<label class="col-form-label">Paciente:</label>
							<input class="form-control-plaintext input-pacient" type="text" name="nomePaciente">
						</div>
						<div class="form-group pacient-group">
							<label class="col-form-label">Dt. Nasc:</label>
							<input class="form-control-plaintext input-pacient" type="date" name="dtNascimento">
						</div>
						<div class="form-group pacient-group">
							<label class="col-form-label">Mãe:</label>
							<input class="form-control-plaintext input-pacient" type="text" name="nomeMae">
						</div>
						<div class="form-group pacient-group">
							<label class="col-form-label">Prontuário:</label>
							<input class="form-control-plaintext input-pacient" type="text" name="prontuario">
						</div>
						<div class="form-group pacient-group">
							<label class="col-form-label">Reg. Paciente:</label>
							<input class="form-control-plaintext input-pacient" type="text" name="regPaciente">
						</div>
						<div class="form-group pacient-group">
							<label class="col-form-label">Dt. Evolução:</label>
							<input class="form-control-plaintext input-pacient" type="date" name="dtEvo">
						</div>
						<div class="form-group pacient-group">
							<label class="col-form-label">Tipo Evolução:</label>
							<input class="form-control-plaintext input-pacient" type="text" name="tipoEvo">
						</div>
						<div class="form-group">
							<textarea name="evolucao" style="display: none; border: none;">
								<?php 
									foreach ($pacientEvo as $value) {
										
										echo $value['EVOLUCAO'];
									}
								?>	
							</textarea>
						</div>
					</div><!-- Fim Linha 1 -->
					<div class="row border border-dark p-3"><!-- Inicio Linha 2 -->
						<div class="form-group">
							<h1 style="text-align: center;">Evolução do paciente</h1>
							<p class="text-break">
								<?php 
									foreach ($pacientEvo as $value) {
										echo "<pre style='font-family: Arial;font-size: 75%;'>";
										echo wordwrap($value['EVOLUCAO'], 250, "<br><br>", true);
									}
								?>	
							</p>
						</div>
					</div><!-- Fim Linha 2 -->
					<div class="form-group">
						<button class="btn btn-primary" type="submit">Enviar</button>
					</div>
				</form>
		</section><!-- Fim Sessão cabeçalho -->
		<div class="p-5">
			<button type="button" class="btn btn-primary btn-lg" onclick="goBack()">Voltar</button>
			<a href="exportEvoDoc.php?regProntuary=<?php echo $pacientRegistry . '&' . 'hourEvolution=' . $hourEvo . '&' . 'dateEvolution=' . $dateEvo;  ?>" class="btn btn-primary btn-lg ml-5">Baixar Evolução</a>
		</div>
	</div>
	<script type="text/javascript">
		function goBack(){
			window.history.go(-1);
		}
	</script>
</body>
</html>










