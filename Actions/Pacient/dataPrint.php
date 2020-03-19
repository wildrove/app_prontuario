<?php

	$nome = $_POST['nomePaciente'];
	$nascimento = $_POST['dtNascimento'];
	$nomeMae = $_POST['nomeMae'];
	$prontuario = $_POST['prontuario'];
	$regPaciente = $_POST['regPaciente'];
	$dtEvo = $_POST['dtEvo'];
	$tipoEvo = $_POST['tipoEvo'];
	$text = $_POST['evolucao'];

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet"  href="../../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet"  href="../../css/estilo.css">
	<script type="text/javascript">
		function printPage(){
			window.print();
		}
	</script>
</head>
<body>
	<div class="container font-pacient-type">
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
				<h3 class="">Resumo de Alta</h3>
			</div>
		</section><!-- Fim Sessão Hospital -->

		<section class="mt-2" style="border: 1px solid #000000">
			<div class="row m-2">
				<h3>Dados Paciente</h3>
			</div>
			<div class="row p-4"><!-- Linha 1 -->
				<div class="form-group pacient-group">
					<label class="col-form-label">Paciente:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="nomePaciente" autocomplete="off">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Dt. Nasc:</label>
					<input class="form-control-plaintext input-pacient" type="date" name="dtNascimento" autocomplete="off">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Mãe:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="nomeMae" autocomplete="off">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Prontuário:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="prontuario" autocomplete="off">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Reg. Paciente:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="regPaciente" autocomplete="off">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Dt. Evolução:</label>
					<input class="form-control-plaintext input-pacient" type="date" name="dtEvo" autocomplete="off">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Tipo Evolução:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="tipoEvo" autocomplete="off">
				</div>	
			</div><!-- Fim Linha 1 -->
		</section><!-- Fim Sessão Paciente -->
	</div>
</body>
</html>