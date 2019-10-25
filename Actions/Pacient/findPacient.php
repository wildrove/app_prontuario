<?php 

	session_start();
	require '../../vendor/autoload.php';
	
	use Classes\Pacient\Pacient;
	$pacient = new Pacient();

	// Pegar data do formulario content-home.php
	$birthday = (isset($_GET['dtNasc'])) ? $_GET['dtNasc'] : '';
	//pegar nome do paciente
	$name = (isset($_GET['paciente'])) ? strtoupper($_GET['paciente']) : '';
   // pega a pagina atual
	$pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
	//itens por página
	$quantidade = 10;
   // calcula o inicio da consulta
	$inicio = ($pagina * $quantidade) - $quantidade;
   // função de consulta no banco
	$result_pagina= $pacient->findPacient($name, $birthday, $inicio, $quantidade);
   // função que pega o total de linhas no banco
	$numTotal = $pacient->getTotalPacient($name, $birthday);
   //calcula to total de paginas
	$num_pagina = ceil($numTotal/$quantidade);


	$pagina_anterior = $pagina -1;
	$pagina_posterior = $pagina + 1;
	?>
	<!DOCTYPE html>
	<html>
	<head>
	  <title>Listar Pacientes</title>
	  <meta charset="utf-8">
	    <!-- Bootstrap -->  
	  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	  <!-- Link Personal style.css -->
	  <link rel="stylesheet" type="text/css" href="../../bootstrap/css/style.css">

	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	</head>
		<body>
			<div class="container-fluid">
            <?php 
               require_once '../../forms/headerUserPacientList.php';
            ?>   
			    <table class="table shadow-lg" style="margin-top: 180px;">
			        <thead class="thead-dark">
			          <tr class="text-center" style="font-size: 15px;">
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
			        foreach($result_pagina as $rowPacient) {
			            ?>
			            <tr class="text-center border">
			              <th scope="row" class="border-right"><?php echo $rowPacient['REGISTRO_PRONTUARIO']; ?></th>
			              <td class="border-right"><?php echo $rowPacient['NOME']; ?></td>
			              <td class="border-right"><?php echo date('d-m-Y', strtotime($rowPacient['DATA_NASCIMENTO'])); ?></td>
			              <td class="border-right"><?php echo $rowPacient['DOCUMENTO']; ?></td>
			              <td class="border-right"><?php echo $rowPacient['NOME_MAE']; ?></td>
			              <td class="border-right"><?php echo $rowPacient['TELEFONE']; ?></td>
			              <td>
			                <a href="#" class="btn btn-primary">Pesquisar</a>
			              </td>
			            </tr>
			            <?php
			        }?>
			        </tbody>
			    </table>
				<nav align="center" aria-label="Page navigation" style="margin-bottom: 20px;">
					<ul class="pagination">
					   <li class="page-item <?php if($pagina_anterior == 0){ echo 'disabled';} ?>">
					   <?php 
					   if($pagina_anterior != 0) { ?>
					      <a href="findPacient.php?pagina=<?php echo $pagina_anterior; ?>&paciente=<?php if(isset($_GET['paciente']))($_SESSION['nomeP'] = $name); echo $_SESSION['nomeP']; ?>&data=<?php if(isset($_GET['dtNasc']))($_SESSION['data'] = $birthday); echo $_SESSION['data']; ?>" style="text-decoration: none;">
					         <span class="page-link" aria-hidden="true">Anterior</span>
					      </a>
					   <?php } else { ?>
					         <span class="page-link" >Anterior</span>
					   <?php } ?>
					   </li>
					   <?php

					        if($pagina > 2){
					            echo "<li class='page-item'><span class='page-link' aria-hidden='true'>...</li>";
					        }
					        if($pagina > 1){
					        echo "<li class='page-item'><a class='page-link' href='findPacient.php?pagina=".$pagina_anterior."'>".$pagina_anterior."</a></li>";
					        }
					        echo "<li class='page-item active'><a class='page-link' href='findPacient.php?pagina=".$pagina."'>".$pagina."</a></li>";
					        if($pagina_posterior <= $num_pagina){
					          echo "<li class='page-item'><a class='page-link' href='findPacient.php?pagina=".$pagina_posterior ."'>".$pagina_posterior."</a></li>"; 
					        }
					        if($pagina_posterior < $num_pagina){
					            echo "<li class='page-item'><span class='page-link' aria-hidden='true'>...</li>";
					        }
					        ?>
					   <li class="page-item <?php if($pagina_posterior > $num_pagina){echo 'disabled';} ?>">
					       <?php 
					       if($pagina_posterior <= $num_pagina) { ?>
					          <a href="findPacient.php?pagina=<?php echo $pagina_posterior; ?>&paciente=<?php if(isset($_GET['paciente']))($_SESSION['nomeP'] = $name); echo $_SESSION['nomeP']; ?>&data=<?php if(isset($_GET['dtNasc']))($_SESSION['data'] = $birthday); echo $_SESSION['data']; ?>" aria-label="Previous" style="text-decoration: none">
					             <span class="page-link" aria-hidden="true">Próximo</span>
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

