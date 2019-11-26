<?php 

	session_start();
	require '../../vendor/autoload.php';
	
	use Classes\Users\Users;

   // pega a pagina atual
	$currentPage = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	//itens por página
	$itemsPerPage = 3;
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
			            <th scope="col">EXCLUIR</th>
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
			              <td class="border-right"><?php echo str_replace("?", "á", utf8_decode($rowUser['TIPO_USUARIO'])); ?></td>
			              <td>
			                <a href="editUser.php?idUser=<?php echo $rowUser['CODIGO_USUARIO']; ?>" class="btn btn-warning" data-toggle="" data-target="">Editar</a>
			              </td>
			              <td>
			                <a href="deleteUser.php?idUser=<?php echo $rowUser['CODIGO_USUARIO']; ?>" data-toggle="" data-target="" class="btn btn-danger">Excluir</a>
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
			<!-- Modal Edit -->
			<div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Editar usuário</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <form method="post" action="">     	
			        	<div class="form-group">
			        		<label for="name">Nome Completo:</label>
			        		<input class="form-control" type="text" name="editName">
			        	</div>
			        	<div class="form-group">
			        		<label for="name">Usuário:</label>
			        		<input class="form-control" type="text" name="editUser">
			        	</div>
			        	<div class="form-group">
			        		<label for="name">CPF:</label>
			        		<input class="form-control" type="text" name="editCPF">
			        	</div>
			        	<div class="form-group">
			        		<label for="name">Senha:</label>
			        		<input class="form-control" type="password" name="editPass">
			        	</div>
			        	<div class="form-group">
			        		<label for="name">Tipo Usuário:</label>
			        		<input class="form-control" type="text" name="editType">
			        	</div>
			        </form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-warning" data-dismiss="modal">Fechar</button>
			        <button type="button" class="btn btn-warning">Savlar</button>
			      </div>
			    </div>
			  </div>
			</div>
			<!-- Modal Delete -->
			<div class="modal fade" id="deletar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			  		<img src="../../img/hospital-header-logo.png" class="img-fluid">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<h4 class="text-danger">Deseja remover este usuário?</h4>
			      </div>
			      <div class="modal-footer">
			      	<a href="" class="btn btn-danger">Sim</a>
			        <button type="button" class="btn btn-danger" data-dismiss="modal">Não</button>
			      </div>
			    </div>
			  </div>
			</div>
	</body>
</html>

   

