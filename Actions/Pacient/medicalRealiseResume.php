<?php
	
	session_start();
	require '../../vendor/autoload.php';
	require('../../RtfCleanText/cleanRtf.php');

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	
	$pacientProntuary = intval($_GET['regProntuary']);
	$pacientRegistry = (isset($_GET['regPacient']) ? intval($_GET['regPacient']) : "");
	$medicalHour = $_GET['medicalHour'];
	$medicalDate = $_GET['medicalDate'];
	$pacientName = (isset($_GET['pacientName']) ? $_GET['pacientName'] : "");
	$mother = (isset($_GET['mother']) ? $_GET['mother'] : "");
	$birthday = (isset($_GET['birthday']) ? date('d/m/Y', strtotime($_GET['birthday'])) : "");
	$doctor = (isset($_GET['doctor']) ? $_GET['doctor'] : "");
	$resumeType = (isset($_GET['resumeType']) ? $_GET['resumeType'] : "");
	

	$pacientEvolution = new PacientEvolution();

	// Procura a alta do paciente na tabela PEP_RESUMO_ALTA 
	$pacientEvo = $pacientEvolution->pacientMedicalRealiseResume($pacientProntuary, $medicalDate, $medicalHour);

	
	// VERIFICA SE A CONSULTA NÃO RETORNA VAZIO
	if (empty($pacientEvo)) {
		header('Location: ../../AlertsHTML/alertNoneEvolutionFound.html');
	}
	
	// Função para limpar o texto da evolução e remover caracteres indesejados
	foreach ($pacientEvo as $key => $value) {
		$pacientEvo[$key]['DIAGNOSTICO_ALTA'] = rtf2text(utf8_encode($pacientEvo[$key]['DIAGNOSTICO_ALTA']));
	}

	// Função para substituir os caracteres especiais por letras com acento.
	$pacientEvo = $pacientEvolution->convertEvoLetter($pacientEvo, 'DIAGNOSTICO_ALTA');


	// Verifica se alguma evolução não foi preenchida.
	foreach ($pacientEvo as  $value) {
		if ($value['DIAGNOSTICO_ALTA'] == "") {
			header('Location: ../../AlertsHTML/alertNoneEvolutionWritten.html');
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet"  href="../../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet"  href="../../css/estilo.css">
	<link rel="stylesheet"  href="../../css/print.css" media="print">
	<script type="text/javascript">
		function printPage(){
			window.print();
		}
	</script>
</head>
<body>
	<div class="container-fluid font-pacient-type">
		<section style="border: 1px solid #000000">
			<div class="row">
				<div class="col-sm">
					<img class="p-2" src="../../img/hospital-header-logo.png">
				</div>
				<div class="col-sm p-3">
					<div>
						<h3 style="font-size: 25px;">HOSPITAL MATERNIDADE SÃO LUCAS</h3>
						<h6>Rua: Mauri Bueno de Andrade Nº 101 - Extrema / MG</h6>
						<h6 class="float-center">Fone: (35) 3100-9550</h6>			
					</div>
				</div>
			</div>
			<div class="row d-flex justify-content-center">
				<h4 class="">Resumo de Alta</h4>
			</div>
		</section><!-- Fim Sessão Hospital -->

		<section class="mt-2" style="border: 1px solid #000000"><!-- Sessão Paciente -->
			<div class="row m-2">
				<h4>Dados Paciente</h4>
			</div>
			<div class="row p-4"><!-- Linha 1 -->
				<div class="form-group pacient-group">
					<label class="col-form-label">Paciente:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="nomePaciente" value="<?php echo $pacientName ?>"  disabled="" style="width: auto">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Dt. Nasc:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="dtNascimento" value="<?php echo $birthday ?>" disabled="">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Mãe:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="nomeMae" value="<?php echo $mother ?>" disabled="" style="width: 400px">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Prontuário:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="prontuario" value="<?php echo $pacientProntuary ?>" disabled="">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Reg. Paciente:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="regPaciente" value="<?php echo $pacientRegistry ?>" disabled="">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Dt. Alta:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="dtEvo" value="<?php echo date('d/m/Y', strtotime($medicalDate)) ?>" disabled="">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Profissional:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="tipoEvo" value="<?php echo $doctor ?>" disabled="">
				</div>
				<div class="row pacient-discription border-top border-dark"><!-- Inicio Texto descrição -->
					<p class="">
						<?php 
							foreach ($pacientEvo as $value) {
								echo "<pre style='font-family: Arial;font-size: 80%;'>";
								echo wordwrap($value['DIAGNOSTICO_ALTA'], 300, "<br>", true);
							}	
						?>	
					</p>
				</div><!-- Fim texto Descrição -->	
			</div><!-- Fim Linha 1 -->
		</section><!-- Fim Sessão Paciente -->
		<div class="botoes-imprimir">
			<button class="btn btn-primary btn-lg mt-5 mb-5" type="button" name=""onclick="goBack()">Voltar</button>
			<button class="btn btn-primary btn-lg mt-5 mb-5" type="button" onclick="imprimir();">Imprimir</button>

			<a href="exportEvoDoc.php?regProntuary=<?php echo $pacientProntuary  . '&medicalDate=' . $medicalDate  . '&medicalHour=' . $medicalHour . '&resumeType=' . $resumeType;  ?>" class="btn btn-primary btn-lg">Baixar Evolução</a>
		</div>
	</div>
	
	<script type="text/javascript">
		function goBack(){
			window.history.go(-1);
		}
	</script>

	<script>
		function imprimir(){
			window.print();
		}
	</script>
</body>
</html>







