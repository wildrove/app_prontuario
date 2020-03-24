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
	<div class="container">
		<?php  
			include '../../forms/headerPacient.php';
		?>
	</div>
</body>
</html>