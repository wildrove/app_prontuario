<?php
	session_start();

$pacientName = (isset($_GET['pacientName']) ? strtoupper($_GET['pacientName']) : "");
$prontuary = intval($_GET['regProntuary']);
$birthday = (isset($_GET['pacientBirthday']) ? $_GET['pacientBirthday'] : "");
$mother = (isset($_GET['motherName']) ? $_GET['motherName'] : "");
/* Criar filtro aqui antes de listar as evoluções 

		- Tipo paciente: internado ou c/alta
		- Enfermagem
		- Fisioterapia
		- Neovida/Consultorio
		- Exames de Imagem
		- Resumo de Alta
		- Resumo de Cirurgia

		*** Verificar se os campos acima serão um filtro para procurar a evolução ou se serão
		opções de para visualizar alguma informação do Paciente.



		*/

		/* Criar na tela de evolução Cabeçalho com esses dados

		- Nome paciente 
		- Data Nascimento
		- Data evolução
		- Nº prontuário
		- Nome mãe
		- Tipo evlução (Filtro)
		- Opção de impressão

		*/


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>Filtrar Dados</title>
	<meta charset="utf-8">
	<link rel="stylesheet"  href="../../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet"  href="../../css/estilo.css">
	<script src="../../bootstrap/js/jquery.min.js"></script>
	<script src="../../js/selectEvolutionType.js"></script>
</head>
<body>
	<div class="container-fluid body-filtrar-paciente"><!-- Div Principal -->
		<div class="row"><!-- Área do cabeçalho -->
			<?php  include '../../forms/headerPacient.php'; ?>
		</div><!-- Fim cabeçalho -->
		<div class="row div-principal-filtrar-paciente">
			<form class="form m-5 form-filtrar-paciente" method="get" action="resumePacient.php">	
					<div class="row mb-3">
						<h2>Filtrar dados do Paciente:</h2>
					</div>
					<div class="row mb-3">
						<h3 class="paciente-nome-filtrar-titulo"><?php echo ucwords(strtolower($pacientName));  ?></h3>
					</div>
					<div class="row"><!-- Registro do Paciente -->
						<div class="form-check mr-2">
							<input type="hidden" name="regProntuary" value="<?php echo $prontuary ?>">
						</div>
					</div><!-- Fim registro Paciente -->
					<div class="row">
						<label class="label-filtrar-paciente">Paciente:</label>
					</div>
					<div class="row mb-3">
						<div class="form-check mr-2">
							<input class="form-check-input" type="radio" name="tipoPaciente" id="radioInterndo1" value="internado">
							<label class="form-check-label" for="radioInterndo1">Internado</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="tipoPaciente" id="radioInterndo2" value="comAlta">
							<label class="form-check-label" for="radioInterndo2">Intern.C/Alta</label>
						</div>						
					</div>

					<div class="row">
						<label class="label-filtrar-paciente">Atendimento:</label>
					</div>
					<div class="row mb-3">	
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="consultorio" id="checkboxNeo" value="consultorio">
							<label class="form-check-label" for="checkboxNeo">Neovida/Consultório</label>
						</div>
					</div>

					<div class="row">
						<label class="label-filtrar-paciente">Categoria:</label>
					</div>
					<div class="row mb-3">
						<select class="form-control" name="selectCat" style="width: 30%">
							<option value="" selected=""></option>
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

					<div class="row">
						<label class="label-filtrar-paciente">Tipo Resumo:</label>
					</div>
					<div class="row">
						<div class="form-check mr-2">
							<input class="form-check-input" type="radio" name="tipoResumo" id="radioResumo1" value="evolucao">
							<label class="form-check-label" for="radioResumo1">Evolução</label>
						</div>
						<!-- <div id="evoType">
							<div class="form-group mr-2" id="evolucao">
								<select class="form-control" name="selectEvo">
									<option value="" selected=""></option>
									<option value="medico">Médico</option>
									<option value="nutricionista">Nutricionista</option>
									<option value="psicologo">Psicólogo</option>
									<option value="enfermagem">Enfermaria</option>
									<option value="fisioterapeuta">Fisioterapeuta</option>
									<option value="ambulatorio">Ambulatório</option>
									<option value="externo">Externo</option>
									<option value="interno">Interno</option>
								</select>
							</div>
						</div> -->
						<div class="form-check mr-2">
							<input class="form-check-input" type="radio" name="tipoResumo" id="radioResumo2" value="alta">
							<label class="form-check-label" for="radioResumo2">Resumo de Alta</label>
						</div>
						<div class="form-check mr-2">
							<input class="form-check-input" type="radio" name="tipoResumo" id="radioResumo3" value="cirurgia">
							<label class="form-check-label" for="radioResumo3">Resumo de Cirurgia</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="tipoResumo" id="radioResumo4" value="imagem">
							<label class="form-check-label" for="radioResumo4">Exame de Imagem</label>
						</div>
					</div>
					<div class="form-group btn-filtrar-paciente">
						<button class="btn btn-primary" type="submit">Filtrar</button>
						<a class="btn btn-primary" href="javascript:history.back();">Voltar</a>
					</div>
			</form>
		</div>		
	</div><!-- Fim da Div principal -->
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>