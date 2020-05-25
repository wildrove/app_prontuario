<?php
	session_start();
	// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
	}
	// variavel para validar o link de redirecionar para o inicio;
	$redirect = $_SESSION['usuario_nivel_acesso'];
	$pacientName = (isset($_GET['pacientName']) ? strtoupper($_GET['pacientName']) : "");
	$prontuary = intval($_GET['regProntuary']);
	$birthday = (isset($_GET['pacientBirthday']) ? $_GET['pacientBirthday'] : "");
	$mother = (isset($_GET['motherName']) ? $_GET['motherName'] : "");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Filtrar Dados</title>
	<meta charset="utf-8">
	<link rel="stylesheet"  href="../../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet"  href="../../css/estilo.css">
	<script src="../../bootstrap/js/jquery.min.js"></script>
	<script src="../../js/selectClinicEvolution.js"></script>
	<script src="../../js/jquery.js"></script>
	<script>
		// Limpa o formulário quando o usuário retorna a página anterior.
		$(window).bind("pageshow", function(){
			$('#filter')[0].reset();
		})
	</script>
	<script src="../../js/changeSelectEvoValue.js"></script>
	<script src="../../js/validateRadioButton.js"></script>
</head>
<body class="body-filtrar-paciente">
	<div class="container">
		<div class="row"><!-- Inicio seesão header -->
			<?php  include '../../forms/headerPacient.php'; ?>
		</div><!-- Fim sessão header -->
		<div class="div-principal-filtrar-paciente"><!-- Card Principal -->
			<div class="card shadow shadow-lg">
  				<h4 class="card-header text-center text-light bg-dark P-5">Prontuário Médico Eletrônico</h4>
  				<div class="card-body">
    				<form id="filter" class="form p-4" method="get" action="redirectPacient.php">
    					<div class="row border-bottom mb-2">
    						<h3 class="card-title">Paciente: <?php echo ucwords(strtolower($pacientName));  ?></h3>
    					</div>
    					<div class="row"><!-- Dados Ocultos do Paciente -->
							<div class="form-check mr-2">
								<input type="hidden" name="regProntuary" value="<?php echo $prontuary ?>">
							</div>
							<div class="form-check mr2">
								<input type="hidden" name="mother" value="<?php echo $mother ?>">
							</div>
							<div class="form-check mr-2">
								<input type="hidden" name="birthday" value="<?php echo $birthday ?>">
							</div>
						</div><!-- Fim dados ocultos Paciente -->
    					<div class="row">
							<label class="label-filtrar-paciente">Paciente:</label>
						</div>
						<div class="row mb-3"><!-- Linha Tipo Paciente -->
							<div class="form-check mr-2">
								<input class="form-check-input" type="radio" name="tipoPaciente" id="radioInterndo1" value="internado">
								<label class="form-check-label" for="radioInterndo1">Internado</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="tipoPaciente" id="radioInterndo2" value="comAlta">
								<label class="form-check-label" for="radioInterndo2">Intern.C/Alta</label>
							</div>						
						</div><!-- Fim Linha Paciente -->
						<div class="row">
							<label class="label-filtrar-paciente">Tipo Resumo:</label>
						</div>
						<div class="row"><!-- Inicio Linha Tipo de Resumo -->
							<div class="form-check mr-2">
								<input class="form-check-input" type="radio" name="tipoResumo" id="radioResumo1" value="evolucao">
								<label class="form-check-label" for="radioResumo1">Evolução</label>
							</div>
							<div id="evoType"><!-- Menu de seleção de Tipo Evolução -->
								<div class="form-group mr-2" id="evolucao">
									<select id="selectEvoValue" class="form-control" name="selectEvo">
										<option value="TODOS">Todos</option>
										<option value="CRM">Médico</option>
										<option value="CRN">Nutricionista</option>
										<option value="CRP">Psicólogo</option>
										<option value="COREN">Enfermaria</option>
										<option value="CREFITO">Fisioterapeuta</option>
										<option value="A">Ambulatório</option>
										<option value="E">Externo</option>
										<option value="I">Interno</option>
									</select>
								</div>
							</div><!-- Fim Menu Evolução -->
							<div class="form-check mr-2">
								<input class="form-check-input" type="radio" name="tipoResumo" id="radioResumo2" value="alta">
								<label class="form-check-label" for="radioResumo2">Resumo de Alta</label>
							</div>
							<div class="form-check mr-2">
								<input class="form-check-input" type="radio" name="tipoResumo" id="radioResumo3" value="cirurgia">
								<label class="form-check-label" for="radioResumo3">Resumo de Cirurgia</label>
							</div>
							<div class="form-check mr-2">
								<input class="form-check-input" type="radio" name="tipoResumo" id="radioResumo4" value="imagem">
								<label class="form-check-label" for="radioResumo4">Exame de Imagem</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="tipoResumo" id="radioResumo5" value="consultorio">
								<label class="form-check-label" for="radioResumo5">Evolução Consultório</label>
							</div>
							<div id="clinicEvoType" class="ml-2">
								<div class="form-group mr-2" id="consultorio">
									<select id="selectClinicValue" class="form-control" name="selectClinicEvo">
										<option value="CONDUTA_MEDICA" selected="">Conduta Médica</option>
										<option value="DESCRICAO_EXAME">Exame Clínico</option>
										<option value="EXAMES_LAB">Exame Lab</option>
										<option value="DESCRICAO_PROCEDIMENTO">Procedimento</option>
										<option value="HIPOTESE_DIAGNOSTICA">Hipotese Diagnóstico</option>
										<option value="EXAMES_COMPL_REALIZADOS">Exames Complementares</option>
									</select>
								</div>
							</div>
						</div><!-- Fim Linha Tipo RESUMO -->
						<div class="form-group btn-filtrar-paciente"><!-- Inicio Div Confirmar -->
							<button class="btn btn-primary" type="submit" id="enviarFiltro" name="enviarFiltro">Filtrar</button>
							<a class="btn btn-primary" href="javascript:history.back();">Voltar</a>
							<a class="btn btn-primary" href="<?php if($redirect == "Administrador"){ echo '../../forms/content-home-admin.php';}else echo '../../home.php'; ?>">Inicio</a>
						</div><!-- Fim Div Confirmar -->
    				</form>
  				</div>
			</div>
		</div><!-- Fim Card Principal -->
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>