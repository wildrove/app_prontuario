<?php

	session_start();
	// variavel para validar o link de redirecionar para o inicio;
	$redirect = $_SESSION['usuario_nivel_acesso'];
	require '../../vendor/autoload.php';

	use Classes\Pacient\PacientEvolution\PacientEvolution;
    use Classes\Pacient\Pacient;


    $evoHeader = null;
    // Pega o tipo de resumo de evolução
    $resumeType = (isset($_GET['resumeType']) ? $_GET['resumeType'] : "");
    // Pega o tipo de evolução
    $evoType = (isset($_GET['selectClinicEvo']) ? $_GET['selectClinicEvo'] : "");
    // variavel para validar o link de redirecionar para o inicio;
    $redirect = $_SESSION['usuario_nivel_acesso'];
    // Registro vindo do formulário
	$regProntuary = (isset($_GET['regProntuary']) ? intval($_GET['regProntuary']) : $_GET['regProntuary']);
	$_SESSION['regValue'] = '';
    // pega a pagina atual
    $currentPage = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    //itens por página
    $itemsPerPage = 30;
    // calcula o inicio da consulta
    $start = ($currentPage * $itemsPerPage) - $itemsPerPage;

	$findDate = new PacientEvolution();

	$evolutionDate = $findDate->findClinicResume($regProntuary, $resumeType, $evoType, $start, $itemsPerPage);

	if (empty($evolutionDate)) {
		header('Location: ../../AlertsHTML/alertNoneEvolutionFound.html');
	}

	$totalRows = $findDate->totalClinicRealise($regProntuary);

    $totalPages = ceil($totalRows/$itemsPerPage);
    $previousPage = $currentPage -1;
    $nextPage = $currentPage + 1;

    // Dados do Paciente para o cabeçalho
    $pacientHeader = new PacientEvolution();
    $name;
    $mother;
    $birthday;

    $pacientHeader = $pacientHeader->findPacientHeader($regProntuary);
    foreach ($pacientHeader as $value) {
    	$name = $value['NOME'];
    	$mother = $value['NOME_MAE'];
    	$birthday = $value['DATA_NASCIMENTO'];
    }

    // Verificar o tipo de evolução de consultório para gerar o cabeçalho 
    // da tabela e para buscar a evolução na coluna correta no banco.
   if ($evoType == 'CONDUTA_MEDICA') {
   		$evoHeader = 'CONDUTA MÉDICA';
   }
   if($evoType == 'DESCRICAO_EXAME'){
   		$evoHeader = 'EXAME CLÍNICO';
   }
   if($evoType == 'EXAMES_LAB'){
   		$evoHeader = 'EXAME LAB';
   }
   if($evoType == 'DESCRICAO_PROCEDIMENTO'){
   		$evoHeader = 'PROCEDIMENTO';
   }
   if($evoType == 'HIPOTESE_DIAGNOSTICA'){
   		$evoHeader = 'HIPÓTESE DIAGNÓSTICO';
   }
   if($evoType == 'EXAMES_COMPL_REALIZADOS'){
   		$evoHeader = 'EXAMES COMPLEMENTARES';
   }
    
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="ISO-8859-1">
    <!-- Bootstrap Online -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- Bootstrap Local -->  
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Link Personal style.css -->
    <link rel="stylesheet"  href="../../css/estilo.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <?php 
            include '../../forms/headerPacient.php';
        ?>
        <h1 class="text-center mb-3"  style="margin-top: 120px;">Evoluções Consultório</h1>    
        <div>
        	<div class="d-flex justify-content-end font-italic mb-2">
            	<a class="btn btn-lg btn-primary border-0" href="<?php if($redirect == "Administrador"){ echo '../../forms/content-home-admin.php';}else echo '../../home.php'; ?>">Inicio</a>
            </div>
			 <table class="table shadow-lg table-hover table-striped table-bordered">
			     <thead class="thead-dark">
			         <tr class="text-center" style="font-size: 15px">
			            <th scope="col" class="border-right">REG. PACIENTE</th>
			            <th scope="col" class="border-right">DATA</th>
			            <th scope="col" class="border-right">HORA</th>
			            <th scope="col" class="border-right"><?php echo $evoHeader; ?></th>
			            <th scope="col" class="border-right">PROFISSIONAL</th>
			            <th scope="col">EVOLUÇÃO</th>
			         </tr>
			     </thead>
			     <tbody>
			         <?php 
			             foreach($evolutionDate as $rowPacient) {
			         ?>
			         <tr class="text-center border font-italic">
			         	  <th scope="row" class="border-right"><?php echo $rowPacient['REGISTRO_PACIENTE_EXTERNO']; ?></th>
			              <td class="border-right "><?php echo date('d/m/Y', strtotime($rowPacient['DATA'])); ?></td>
			              <td class="border-right"><?php echo $rowPacient['HORA']; ?></td>
			              <td class="border-right"><?php echo mb_convert_case($evoHeader, MB_CASE_TITLE, "UTF-8"); ?></td>
			              <td class="border-right"><?php echo $rowPacient['NOME_COMPLETO']; ?></td>
			              <td>
			              	<a href="clinicResume.php?regProntuary=<?php echo $regProntuary . '&regPacient=' . $rowPacient['REGISTRO_PACIENTE_EXTERNO'] . '&pacientName=' . $name . '&birthday=' . $birthday . '&mother=' . $mother . '&resumeType=' . $resumeType . '&evoType=' . $evoType . '&doctor=' . $rowPacient['NOME_COMPLETO'] . '&date=' . $rowPacient['DATA'] . '&hour=' . $rowPacient['HORA']; ?>" class="btn btn-primary">Visualizar</a>
			              </td>
			         </tr>
			            <?php
			        }?>
			     </tbody>
			 </table>
            </div>
			<nav align="center" aria-label="Page navigation" style="margin-bottom: 20px;">
					<ul class="pagination mt-3">
					   <li class="page-item <?php if($previousPage == 0){ echo 'disabled';} ?>">
					       <?php 
					           if($previousPage != 0) { ?>
					               <a href="findClinicEvolution.php?page=<?php echo $previousPage; ?>&regProntuary=<?php if(isset($_GET['regProntuary']))($_SESSION['regValue'] = $regProntuary); echo $_GET['regProntuary'];?>" style="text-decoration: none;">
					               <span class="page-link bg-primary text-light" aria-hidden="true">Anterior</span>
					               </a>
					       <?php } else { ?>
					         <span class="page-link" >Anterior</span>
					       <?php } ?>
					   </li>
					   <?php

					        if($currentPage > 2){
					            echo "<li class='page-item'><span class='page-link' aria-hidden='true'>...</li>";
					        }
					        if($currentPage > 1){
					        echo "<li class='page-item'><a class='page-link ' href='findClinicEvolution.php?page=".$previousPage."&regProntuary=".$_GET['regProntuary']."'>".$previousPage."</a></li>";
					        }
					        echo "<li class='page-item active'><a class='page-link ' href=''>".$currentPage."</a></li>";
					        if($nextPage <= $totalPages){
					          echo "<li class='page-item'><a class='page-link' href='findClinicEvolution.php?page=".$nextPage ."&regProntuary=".$_GET['regProntuary']."'>".$nextPage."</a></li>"; 
					        }
					        if($nextPage < $totalPages){
					            echo "<li class='page-item'><span class='page-link' aria-hidden='true'>...</li>";
					        }
					        ?>
					      <li class="page-item <?php if($nextPage > $totalPages){echo 'disabled';} ?>">
					           <?php 
					               if($nextPage <= $totalPages) { ?>
					                   <a href="findClinicEvolution.php?page=<?php echo $nextPage; ?>&regProntuary=<?php if(isset($_GET['regProntuary']))($_SESSION['regValue'] = $regProntuary); echo $_GET['regProntuary'];?>" style="text-decoration: none;">
					                   <span class="page-link bg-primary text-light" aria-hidden="true">Próximo</span>
					                   </a>
					           <?php } else { ?>
					           <span class="page-link" aria-hidden="true">Próximo</span>
					           <?php } ?>
					      </li>
					</ul>
			</nav>
			<a class="btn btn-primary  mb-5 shadow-lg" href="javascript:history.back()">Voltar</a>
	</div>
</body>
</html>	




