<?php 

	session_start();
	require '../../vendor/autoload.php';
	
	use Classes\Users\Users;
	//$_SESSION['nomeP'] = strtoupper($_GET['paciente']);
	//$_SESSION['data'] = $_GET['dtNasc'];
   // pega a pagina atual
	$currentPage = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	//itens por página
	$itemsPerPage = 2;
   	// calcula o inicio da consulta
	$start = ($currentPage * $itemsPerPage) - $itemsPerPage;

   $editUser = new Users();

   	// função de consulta no banco
	$resultPage = $editUser->userList($start, $itemsPerPage);
   	// função que pega o total de linhas no banco   
	$totalRowsQuery = $editUser->getTotalUsers();
   	//calcula to total de paginas
	$totalPages = ceil($totalRowsQuery/$itemsPerPage);


	$previousPage = $currentPage -1;
	$nextPage = $currentPage + 1;

     

	?>
	<!DOCTYPE html>
	<html>
	<head>
	  <title>Listar Usuários</title>
	  <meta charset="UTF-8">
	    <!-- Bootstrap Online -->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<!-- Bootstrap Local -->  
		<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	    <!-- Link Personal style.css -->
	    <link rel="stylesheet"  href="../../bootstrap/css/style.css">

	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	</head>
		<body>
			<div class="container">
            <?php 
               require_once '../../forms/header-users.php';
            ?>
            <h1 class="text-center mb-3" style="margin-top: 140px">Lista de Usuários</h1>    
            <div>
			    <table class="table shadow-lg table-hover table-striped table-bordered">
			        <thead class="thead-dark">
			          <tr class="text-center" style="font-size: 15px">
			            <th scope="col" class="border-right">ID</th>
			            <th scope="col" class="border-right">NOME COMPLETO</th>
			            <th scope="col" class="border-right">USUÁRIO</th>
			            <th scope="col" class="border-right">CPF</th>
			            <th scope="col" class="border-right">SENHA</th>
			            <th scope="col" class="border-right">TIPO USUÁRIO</th>
			            <th scope="col">EDITAR</th>
			          </tr>
			        </thead>
			        <tbody>
			        <?php 
			        foreach($resultPage as $rowUser) {
			            ?>
			            <tr class="text-center border font-italic">
			              <th scope="row" class="border-right "><?php echo $rowUser['CODIGO_USUARIO']; ?></th>
			              <td class="border-right"><?php echo utf8_decode($rowUser['NOME_COMPLETO']); ?></td>
			              <td class="border-right"><?php echo $rowUser['NOME']; ?></td>
			              <td class="border-right"><?php echo $rowUser['CPF']; ?></td>
			              <td class="border-right"><?php echo $rowUser['SENHA']; ?></td>
			              <td class="border-right"><?php echo utf8_decode($rowUser['TIPO_USUARIO']); ?></td>
			              <td>
			                <a href="<?php echo $rowUser['CODIGO_USUARIO'] ?>" class="btn btn-primary">Editar</a>
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
					      <a href="userList.php?page=<?php echo $previousPage; ?>" style="text-decoration: none;">
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
					        echo "<li class='page-item'><a class='page-link' href='userList.php?page=".$previousPage."'>".$previousPage."</a></li>";
					        }
					        echo "<li class='page-item active'><a class='page-link' href=''>".$currentPage."</a></li>";
					        if($nextPage <= $totalPages){
					          echo "<li class='page-item'><a class='page-link' href='userList.php?page=".$nextPage ."'>".$nextPage."</a></li>"; 
					        }
					        if($nextPage < $totalPages){
					            echo "<li class='page-item'><span class='page-link' aria-hidden='true'>...</li>";
					        }
					        ?>
					      <li class="page-item <?php if($nextPage > $totalPages){echo 'disabled';} ?>">
					       <?php 
					       if($nextPage <= $totalPages) { ?>
					          <a href="userList.php?page=<?php echo $nextPage; ?>" aria-label="Previous" style="text-decoration: none">
					             <span class="page-link bg-primary text-light" aria-hidden="true">Próximo</span>
					          </a>
					       <?php } else { ?>
					          <span class="page-link" aria-hidden="true">Próximo</span>
					        <?php } ?>
					     </li>
					</ul>
				</nav>
				<a class="btn btn-primary  mb-5 shadow-lg" <?php if($_SESSION['usuario_nivel_acesso'] == 'Administrador'){ echo "href='http://localhost/App_prontuario/forms/content-home-admin.php'";} ?> href="../../home.php">Voltar</a>
			</div>
	</body>
</html>

   

