<?php 

	session_start();
	require '../../vendor/autoload.php';
	
	use Classes\Pacient\Pacient;
	$_SESSION['nomeP'] = '';
	$_SESSION['data'] = '';
	// Pegar data do formulario content-home.php
	$birthday = (isset($_GET['dtNasc'])) ? $_GET['dtNasc'] : '';
	//pegar nome do paciente
	$name = (isset($_GET['paciente'])) ? strtoupper($_GET['paciente']) : '';
   // pega a pagina atual
	$currentPage = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	//itens por página
	$itemsPerPage = 10;
   // calcula o inicio da consulta
	$start = ($currentPage * $itemsPerPage) - $itemsPerPage;

   $pacient = new Pacient();

   // função de consulta no banco
	$resultPage = $pacient->findPacient($name, $birthday, $start, $itemsPerPage);
   // função que pega o total de linhas no banco   
	$totalRowsQuery = $pacient->getTotalPacient($name, $birthday);
   //calcula to total de paginas
	$totalPages = ceil($totalRowsQuery/$itemsPerPage);


	$previousPage = $currentPage -1;
	$nextPage = $currentPage + 1;


   // verifica se nome e data nascimento são vazios
   if(empty($name) && empty($birthday)){
      header('Location: ../../AlertsHTML/alertInvalidPacient.html');
      exit();
   }
   //verifica se data de nascimento é válida
   if ($birthday && count($resultPage) == 0) {
      header('Location: ../../AlertsHTML/alertInvalidPacient.html');
      exit();
   }
   // verifica se nome do paciente é válido
   if ($name && count($resultPage) == 0) {
     header('Location: ../../AlertsHTML/alertInvalidPacient.html');
      exit();
   }

      

	?>
	<!DOCTYPE html>
	<html>
	<head>
	  <title>Listar Pacientes</title>
	  <meta charset="utf-8">
      <!-- Link Personal style.css -->
     <link rel="stylesheet" type="text/css" href="../../bootstrap/css/style.css">
	    <!-- Bootstrap -->  
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	</head>
		<body>
			<div class="container">
            <?php 
               require_once '../../forms/headerUserPacientList.php';
            ?>
            <h1 class="text-center mb-3" style="margin-top: 130px">*Lista de Pacientes*</h1>    
            <div>
			    <table class="table shadow-lg table-hover table-striped table-bordered">
			        <thead class="thead-dark">
			          <tr class="text-center" style="font-size: 15px">
			            <th scope="col" class="border-right">REG. PRONTUÁRIO</th>
			            <th scope="col" class="border-right">NOME PACIENTE</th>
			            <th scope="col" class="border-right">DT NASCIMENTO</th>
			            <th scope="col" class="border-right">Nº DOCUMENTO</th>
			            <th scope="col" class="border-right">NOME MÃE</th>
			            <th scope="col" class="border-right">Nº TELEFONE</th>
			            <th scope="col">EVOLUÇÃO</th>
			          </tr>
			        </thead>
			        <tbody>
			        <?php 
			        foreach($resultPage as $rowPacient) {
			            ?>
			            <tr class="text-center border font-italic">
			              <th scope="row" class="border-right "><?php echo $rowPacient['REGISTRO_PRONTUARIO']; ?></th>
			              <td class="border-right"><?php echo $rowPacient['NOME']; ?></td>
			              <td class="border-right"><?php echo date('d-m-Y', strtotime($rowPacient['DATA_NASCIMENTO'])); ?></td>
			              <td class="border-right"><?php if(empty($rowPacient['DOCUMENTO'])){
                        echo '<b>-</b>';
                       } echo $rowPacient['DOCUMENTO']; ?></td>
			              <td class="border-right"><?php if (empty($rowPacient['NOME_MAE'])) {
                          echo '<b>-</b>';
                       } echo $rowPacient['NOME_MAE']; ?></td>
			              <td class="border-right"><?php if (empty($rowPacient['TELEFONE'])) {
                          echo '<b>-</b>';
                       } echo $rowPacient['TELEFONE']; ?></td>
			              <td>
			                <a href="findProntuaryDate.php?regProntuary=<?php echo $rowPacient['REGISTRO_PRONTUARIO'] ?>" class="btn btn-primary">Pesquisar</a>
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
					      <a href="findPacient.php?page=<?php echo $previousPage; ?>&paciente=<?php if(isset($_GET['paciente']))($_SESSION['nomeP'] = $name); echo $_SESSION['nomeP']; ?>&data=<?php if(isset($_GET['dtNasc']))($_SESSION['data'] = $birthday); echo $_SESSION['data']; ?>" style="text-decoration: none;">
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
					        echo "<li class='page-item'><a class='page-link' href='findPacient.php?page=".$previousPage."&paciente=".$_SESSION['nomeP']."&data=".$_SESSION['data']."'>".$previousPage."</a></li>";
					        }
					        echo "<li class='page-item active'><a class='page-link' href=''>".$currentPage."</a></li>";
					        if($nextPage <= $totalPages){
					          echo "<li class='page-item'><a class='page-link' href='findPacient.php?page=".$nextPage ."&paciente=".$_SESSION['nomeP']."&data=".$_SESSION['data']."'>".$nextPage."</a></li>"; 
					        }
					        if($nextPage < $totalPages){
					            echo "<li class='page-item'><span class='page-link' aria-hidden='true'>...</li>";
					        }
					        ?>
					      <li class="page-item <?php if($nextPage > $totalPages){echo 'disabled';} ?>">
					       <?php 
					       if($nextPage <= $totalPages) { ?>
					          <a href="findPacient.php?page=<?php echo $nextPage; ?>&paciente=<?php if(isset($_GET['paciente']))($_SESSION['nomeP'] = $name); echo $_SESSION['nomeP']; ?>&data=<?php if(isset($_GET['dtNasc']))($_SESSION['data'] = $birthday); echo $_SESSION['data']; ?>" aria-label="Previous" style="text-decoration: none">
					             <span class="page-link bg-primary text-light" aria-hidden="true">Próximo</span>
					          </a>
					       <?php } else { ?>
					          <span class="page-link" aria-hidden="true">Próximo</span>
					        <?php } ?>
					     </li>
					</ul>
				</nav>
				<a class="btn btn-primary  mb-5 shadow-lg" href="../../home.php">Voltar</a>
			</div>
	</body>
</html>

   

