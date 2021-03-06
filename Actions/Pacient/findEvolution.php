<?php

	session_start();
	// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
	}
	
	require '../../vendor/autoload.php';
	use Classes\Pacient\PacientEvolution\PacientEvolution;
    use Classes\Pacient\Pacient;

	// variavel para validar o link de redirecionar para o inicio;
	$redirect = $_SESSION['usuario_nivel_acesso'];
    // Pega o tipo de resumo de evolução
    $resumeType = (isset($_GET['resumeType']) ? $_GET['resumeType'] : "");
    // Pega o tipo de evolução
    $selectEvo = (isset($_GET['selectEvo']) ? $_GET['selectEvo'] : "");
    // Registro vindo do formulário
	$regProntuary = (isset($_GET['regProntuary']) ? intval($_GET['regProntuary']) : $_GET['regProntuary']);
	

	$findDate = new PacientEvolution();
	// Dados do Paciente para o cabeçalho
	$pacientHeader = $findDate->findPacientHeader($regProntuary);
	$resultPage = $findDate->findEvolutionDate($regProntuary, $resumeType, $selectEvo);
    //Encontrar a evolução por data e trocar o valor da coluna TIPO
	$resultPage = $findDate->changeColumnValue($findDate->findEvolutionDate($regProntuary, $resumeType, $selectEvo), 'TIPO');

	if (empty($resultPage)) {
		header('Location: ../../AlertsHTML/alertNoneEvolutionFound.html');
	}

    $name;
    $mother;
    $birthday;
    foreach ($pacientHeader as $value) {
    	$name = $value['NOME'];
    	$mother = $value['NOME_MAE'];
    	$birthday = $value['DATA_NASCIMENTO'];
    }

    /* ============== Zebra Pagination ================= */

   	// let's paginate data from an array...
	$pacient = $resultPage;

	// how many records should be displayed on a page?
	$records_per_page = 10;

	// include the pagination class
	require '../../vendor/stefangabos/zebra_pagination/Zebra_Pagination.php';

	// instantiate the pagination object
	$pagination = new Zebra_Pagination();

	// the number of total records is the number of records in the array
	$pagination->records(count($pacient));

	// records per page
	$pagination->records_per_page($records_per_page);

	// here's the magic: we need to display *only* the records for the current page
	$pacient = array_slice(
    	$pacient,
    	(($pagination->get_page() - 1) * $records_per_page),
    	$records_per_page
	);

?>

<!DOCTYPE html>
	<html>
	<head>
	  	<title>Listar Pacientes</title>
	  	<meta charset="UTF-8">
		<!-- Bootstrap Local -->  
		<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	    <!-- Link Personal style.css -->
	    <link rel="stylesheet" href="../../vendor/stefangabos/zebra_pagination/public/zebra_pagination.css" type="text/css">
	    <link rel="stylesheet"  href="../../css/estilo.css">
	    <!-- Link jquery 3.4.1 -->
    	<script src="../../js/jquery.js"></script>
	</head>
	<body>
		<div class="row"><!-- Div de loading -->
			<div class="load" style="top: 55%; left: 43%;">
         		<img class="loading-img" src="../../img/load.gif">
         		<h6 class="text-dark font-weight-bold">Aguarde...</h6>
      		</div>
		</div><!-- Fim Div de loading -->
		<div class="container">
			<?php 
               include '../../forms/headerPacient.php';
            ?>
            <h1 class="text-center mb-3" style="margin-top: 140px">Evoluções do Paciente</h1>    
            <div>
            	<div class="d-flex justify-content-end font-italic mb-2">
            		<a class="btn btn-lg btn-primary border-0" href="<?php if($redirect == "Administrador"){ echo '../../forms/content-home-admin.php';}else echo '../../forms/content-home-user.php'; ?>">Inicio</a>
            	</div>
			    <table class="table shadow-lg table-hover table-striped table-bordered">
			        <thead class="thead-dark">
			        	<tr class="text-center" style="font-size: 15px">
				            <th scope="col" class="border-right">DATA EVOLUÇÃO</th>
				            <th scope="col" class="border-right">REGISTRO PACIENTE</th>
				            <th scope="col" class="border-right">TIPO EVOLUÇÃO</th>
				            <th scope="col" class="border-right">PROFISSIONAL</th>
				            <th scope="col" class="border-right">EVOLUÇÃO</th>
			          	</tr>
			        </thead>
			        <tbody>
			        	<?php 
				        	foreach($pacient as $rowPacient) { ?><!--- Inicio Laço -->
				            	<tr class="text-center border font-italic">
				              		<th scope="row" class="border-right "><?php echo date('d/m/Y', strtotime($rowPacient['DATA_EVOLUCAO'])); ?></th>
				              		<td class="border-right"><?php echo $rowPacient['REGISTRO_PACIENTE']; ?></td>
				              		<td class="border-right"><?php echo $rowPacient['TIPO']; ?></td>
				              		<td class="border-right"><?php echo $rowPacient['NOME_COMPLETO']; ?></td>
				              		<td>
			               				<a href="evolutionResume.php?regProntuary=<?php echo $rowPacient['REGISTRO_PRONTUARIO']; ?>&hourEvolution=<?php echo $rowPacient['HORA_EVOLUCAO']; ?>&dateEvolution=<?php echo $rowPacient['DATA_EVOLUCAO']; ?>&regPacient=<?php echo $rowPacient['REGISTRO_PACIENTE']; ?>&type=<?php echo $selectEvo; ?>&pacientName=<?php echo $name; ?>&mother=<?php echo $mother; ?>&birthday=<?php echo $birthday; ?>&resumeType=<?php echo $resumeType; ?>&professional=<?php echo $rowPacient['NOME_COMPLETO']; ?>" class="btn btn-primary loadingEvo">Visualizar</a>
			              			</td>
				            	</tr>
				        <?php }?><!-- Fim do Laço -->
			        </tbody>
			    </table>
			    <?php 
            		// render the pagination links
					$pagination->render();
            	?>
			    <a class="btn btn-primary  mb-5 shadow-lg back-filter" href="javascript:history.back()">Voltar</a>
            </div>
		</div>
		<script> // Habilita o gif de loading da pagina
		$(document).ready(function(){
			$('.loadingEvo').click(function(){
				$('html, body').css({ // Remove o Scroll ao clicar em pesquisar.
	    			overflow:'hidden',
	   				height:'100%'
				});

		        $('.load').show();
		    });
			// habilita o gif no botão voltar
		    $('.back-filter').click(function(){
		    	$('.load').show();
		    });

		    $('.back-filter').click(function(){
				$('html, body').css({
	    			overflow:'hidden',
	   				height:'100%'
				});
			});	
		});
	</script>	
	</body>
</html>



