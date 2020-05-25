<?php

	session_start();
	// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
	}
	// variavel para validar o link de redirecionar para o inicio;
	$redirect = $_SESSION['usuario_nivel_acesso'];
	require '../../vendor/autoload.php';

	use Classes\Pacient\PacientEvolution\PacientEvolution;
    use Classes\Pacient\Pacient;

   
    // variavel para validar o link de redirecionar para o inicio;
    $redirect = $_SESSION['usuario_nivel_acesso'];
    // Registro vindo do formulário
	$regProntuary = (isset($_GET['regProntuary']) ? intval($_GET['regProntuary']) : $_GET['regProntuary']);
	$resumeType = isset($_GET['resumeType']) ? $_GET['resumeType'] : "";
	$_SESSION['regValue'] = '';
    // pega a pagina atual
    $currentPage = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    //itens por página
    $itemsPerPage = 30;
    // calcula o inicio da consulta
    $start = ($currentPage * $itemsPerPage) - $itemsPerPage;

	$findDate = new PacientEvolution();

	 // Dados do Paciente para o cabeçalho
    $pacientHeader = new PacientEvolution();
    $name;
    $mother;
    $birthday;

    $pacientHeader = $pacientHeader->findPacientHeader($regProntuary);
    // laço para encontar os dados do paciente em prontuário
    foreach ($pacientHeader as $value) {
    	$name = $value['NOME'];
    	$mother = $value['NOME_MAE'];
    	$birthday = $value['DATA_NASCIMENTO'];
    }

    //Encontrar a evolução por data e trocar o valor da coluna TIPO
	$evolutionDate = $findDate->findImageExame($regProntuary,$name, $start, $itemsPerPage);

	if (empty($evolutionDate)) {
		header('Location: ../../AlertsHTML/alertNoneEvolutionFound.html');
	}

	$totalRows = $findDate->totalImageExame($regProntuary);

    $totalPages = ceil($totalRows/$itemsPerPage);
    $previousPage = $currentPage -1;
    $nextPage = $currentPage + 1;



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
        <h1 class="text-center mb-3"  style="margin-top: 120px;">Exames de Imagem</h1>    
        <div>
        	<div class="d-flex justify-content-end font-italic mb-2">
            	<a class="btn btn-lg btn-primary border-0" href="<?php if($redirect == "Administrador"){ echo '../../forms/content-home-admin.php';}else echo '../../home.php'; ?>">Inicio</a>
            </div>
			 <table class="table shadow-lg table-hover table-striped table-bordered">
			     <thead class="thead-dark">
			         <tr class="text-center" style="font-size: 15px">
			            <th scope="col" class="border-right">DATA EXAME</th>
			            <th scope="col" class="border-right">Nº LAUDO</th>
			            <th scope="col" class="border-right">CÓDIGO EXAME</th>
			            <th scope="col" class="border-right">EXAME</th>
			            <th scope="col">RESULTADO</th>
			         </tr>
			     </thead>
			     <tbody>
			         <?php 
			             foreach($evolutionDate as $rowPacient) {
			         ?>
			         <tr class="text-center border font-italic">
			              <th scope="row" class="border-right "><?php echo date('d/m/Y', strtotime($rowPacient['DATA_REALIZ'])); ?></th>
			              <td class="border-right"><?php echo $rowPacient['NLAUDO']; ?></td>
			              <td class="border-right"><?php echo $rowPacient['CODIGO_EXAME']; ?></td>
			              <td class="border-right"><?php echo utf8_encode($rowPacient['NOME']); ?></td>
			              <td>
			               <a href="imageExameResume.php?regProntuary=<?php echo $regProntuary . '&regPacient=' . $rowPacient['REG_PACIENTE'] . '&nLaudo=' . $rowPacient['NLAUDO'] . '&exameCode=' . $rowPacient['CODIGO_EXAME'] . '&pacientName=' . $name . '&birthday=' . $birthday . '&mother=' . $mother . '&exameDate=' . $rowPacient['DATA_REALIZ'] . '&doctor=' . $rowPacient['NOME_COMPLETO'] . '&resumeType=' . $resumeType ?>" class="btn btn-primary">Visualizar</a>
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
					               <a href="findImageExame.php?page=<?php echo $previousPage; ?>&regProntuary=<?php if(isset($_GET['regProntuary']))($_SESSION['regValue'] = $regProntuary); echo $_GET['regProntuary'];?>" style="text-decoration: none;">
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
					        echo "<li class='page-item'><a class='page-link ' href='findImageExame.php?page=".$previousPage."&regProntuary=".$_GET['regProntuary']."'>".$previousPage."</a></li>";
					        }
					        echo "<li class='page-item active'><a class='page-link ' href=''>".$currentPage."</a></li>";
					        if($nextPage <= $totalPages){
					          echo "<li class='page-item'><a class='page-link' href='findImageExame.php?page=".$nextPage ."&regProntuary=".$_GET['regProntuary']."'>".$nextPage."</a></li>"; 
					        }
					        if($nextPage < $totalPages){
					            echo "<li class='page-item'><span class='page-link' aria-hidden='true'>...</li>";
					        }
					        ?>
					      <li class="page-item <?php if($nextPage > $totalPages){echo 'disabled';} ?>">
					           <?php 
					               if($nextPage <= $totalPages) { ?>
					                   <a href="findImageExame.php?page=<?php echo $nextPage; ?>&regProntuary=<?php if(isset($_GET['regProntuary']))($_SESSION['regValue'] = $regProntuary); echo $_GET['regProntuary'];?>" style="text-decoration: none;">
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




