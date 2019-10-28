<?php 

	session_start();
	require '../../vendor/autoload.php';
	
	use Classes\Pacient\Pacient;
	$pacient = new Pacient();

	// Pegar data do formulario content-home.php
	$birthday = (isset($_GET['dtNasc'])) ? $_GET['dtNasc'] : null;
	//pegar nome do paciente
	$name = (isset($_GET['paciente'])) ? strtoupper($_GET['paciente']) : null;
   // pega a pagina atual
	$pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
	//itens por página
	$quantidade = 20;
   // calcula o inicio da consulta
	$inicio = ($pagina * $quantidade) - $quantidade;

   // função de consulta no banco
	$result_pagina = $pacient->findPacient($name, $birthday, $inicio, $quantidade);
   // função que pega o total de linhas no banco   
	$numTotal = $pacient->getTotalPacient($name, $birthday);
   //calcula to total de paginas
	$num_pagina = ceil($numTotal/$quantidade);


	$pagina_anterior = $pagina -1;
	$pagina_posterior = $pagina + 1;
   // enviar o prontuario do paciente para consulta de evolução
   $prontuario = null;



   // verifica se nome e data nascimento são vazios
   if(empty($name) && empty($birthday)){
      header('Location: ../../AlertsHTML/alertInvalidPacient.html');
      exit();
   }

   // Transforma o array Paciente coluna NOME em uma String
   $validarNome = implode(',', array_column($result_pagina, 'NOME'));
   // transforma o array paciente coluna DATA_NASCIMENTO em uma String
   $validarDtNasc = implode(',', array_column($result_pagina, 'DATA_NASCIMENTO'));
   
   // Verifica se existe o nome e se a data de nascimento é vazia
   if(strrpos($validarNome, $name) && empty($birthday)){
   
   }
   // verifica se o nome não existe e data de nascimento é vazia
   if(!strrpos($validarNome, $name) && empty($birthday)){
      header('Location: ../../AlertsHTML/alertInvalidName.html');
      exit();
   }
   // Verifica se existe a data de nascimento e se o nome é vazio
   if (strrpos($validarDtNasc, $birthday) && empty($name)) {
   
   }
   // verifica se data de nascimento é inválida
   if(!strrpos($validarDtNasc, $birthday) && empty($name)){
      header('Location: ../../AlertsHTML/alertInvalidDate.html');
      exit();
   }

   // verifica se o nome e data nascimento existem
   if(strrpos($validarNome, $name) && strrpos($validarDtNasc, $birthday)){
   
   }
   // Verifica se nome e data de nascimento são inválidos
   if(!strrpos($validarNome, $name) && !strrpos($validarDtNasc, $birthday)){
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
            <h1 class="text-center mb-3" style="margin-top: 130px">Lista de Pacientes</h1>    
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
			        foreach($result_pagina as $rowPacient) {
			            ?>
			            <tr class="text-center border font-italic">
			              <th scope="row" class="border-right "><?php echo $rowPacient['REGISTRO_PRONTUARIO']; ?></th>
			              <td class="border-right"><?php echo $rowPacient['NOME']; ?></td>
			              <td class="border-right"><?php echo date('d-m-Y', strtotime($rowPacient['DATA_NASCIMENTO'])); ?></td>
			              <td class="border-right"><?php echo $rowPacient['DOCUMENTO']; ?></td>
			              <td class="border-right"><?php echo $rowPacient['NOME_MAE']; ?></td>
			              <td class="border-right"><?php echo $rowPacient['TELEFONE']; ?></td>
			              <td>
			                <a href="findProntuary.php?prontuario=<?php echo $rowPacient['REGISTRO_PRONTUARIO'] ?>" class="btn btn-primary">Pesquisar</a>
			              </td>
			            </tr>
			            <?php
			        }?>
			        </tbody>
			     </table>
            </div>
				<nav align="center" aria-label="Page navigation" style="margin-bottom: 20px;">
					<ul class="pagination mt-3">
					   <li class="page-item <?php if($pagina_anterior == 0){ echo 'disabled';} ?>">
					   <?php 
					   if($pagina_anterior != 0) { ?>
					      <a href="findPacient.php?pagina=<?php echo $pagina_anterior; ?>&paciente=<?php if(isset($_GET['paciente']))($_SESSION['nomeP'] = $name); echo $_SESSION['nomeP']; ?>&data=<?php if(isset($_GET['dtNasc']))($_SESSION['data'] = $birthday); echo $_SESSION['data']; ?>" style="text-decoration: none;">
					         <span class="page-link bg-primary text-light" aria-hidden="true">Anterior</span>
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
					        echo "<li class='page-item'><a class='page-link' href='findPacient.php?pagina=".$pagina_anterior."&paciente=".$_SESSION['nomeP']."&data=".$_SESSION['data']."'>".$pagina_anterior."</a></li>";
					        }
					        echo "<li class='page-item active'><a class='page-link' href=''>".$pagina."</a></li>";
					        if($pagina_posterior <= $num_pagina){
					          echo "<li class='page-item'><a class='page-link' href='findPacient.php?pagina=".$pagina_posterior ."&paciente=".$_SESSION['nomeP']."&data=".$_SESSION['data']."'>".$pagina_posterior."</a></li>"; 
					        }
					        if($pagina_posterior < $num_pagina){
					            echo "<li class='page-item'><span class='page-link' aria-hidden='true'>...</li>";
					        }
					        ?>
					      <li class="page-item <?php if($pagina_posterior > $num_pagina){echo 'disabled';} ?>">
					       <?php 
					       if($pagina_posterior <= $num_pagina) { ?>
					          <a href="findPacient.php?pagina=<?php echo $pagina_posterior; ?>&paciente=<?php if(isset($_GET['paciente']))($_SESSION['nomeP'] = $name); echo $_SESSION['nomeP']; ?>&data=<?php if(isset($_GET['dtNasc']))($_SESSION['data'] = $birthday); echo $_SESSION['data']; ?>" aria-label="Previous" style="text-decoration: none">
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

   

