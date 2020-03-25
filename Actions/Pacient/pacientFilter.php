<?php
	session_start();

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
</head>
<body>
	<div class="container"><!-- Div Principal -->
		<div class="row"><!-- Área do cabeçalho -->
			<?php  
			include '../../forms/headerPacient.php';
		?>

		</div><!-- Fim cabeçalho -->
		<div class="row border border-dark" style="margin-top: 130px;">
			<form class="form">
				<fieldset class="p-5">
					<legend class="p-2">Filtrar dados do Paciente</legend>
					<div class="row">
						<div class="form-check mr-2">
							<input class="form-check-input" type="radio" name="tipoPaciente" id="checkboxInterndo1" value="internado">
							<label class="form-check-label" for="checkboxInterndo1">Internado</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="tipoPaciente" id="checkboxInterndo2" value="comAlta">
							<label class="form-check-label" for="checkboxInterndo2">Intern.C/Alta</label>
						</div>						
					</div>
					<div class="row mt-2">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="Consultorio" value="">
							<label class="form-check-label">Neovida/Consultório</label>
						</div>
					</div>
					<div class="row mt-2">
						<div class="form-check mr-2">
							<input class="form-check-input" type="radio" name="tipoResumo" id="checkboxResumo1" value="evolucao">
							<label class="form-check-label" for="checkboxResumo1">Evolução</label>
						</div>
						<div class="form-check mr-2">
							<input class="form-check-input" type="radio" name="tipoResumo" id="checkboxResumo2" value="alta">
							<label class="form-check-label" for="checkboxResumo2">Resumo de Alta</label>
						</div>
						<div class="form-check mr-2">
							<input class="form-check-input" type="radio" name="tipoResumo" id="checkboxResumo3" value="cirurgia">
							<label class="form-check-label" for="checkboxResumo3">Resumo de Cirurgia</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="tipoResumo" id="checkboxResumo4" value="imagem">
							<label class="form-check-label" for="checkboxResumo4">Exame de Imagem</label>
						</div>
					</div>			
				</fieldset>
			</form>
		</div>
		
	</div><!-- Fim da Div principal -->
</body>
</html>