<?php 
	session_start();
	// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
	}elseif(isset($_SESSION['usuario_nivel_acesso']) && $_SESSION['usuario_nivel_acesso'] != 'Administrador'){
        header('Location: ../../index.php?login=erro3');
        session_destroy();
    }
    
	require '../../vendor/autoload.php';
	use Classes\Users\Users;
	
	// pega o usuário digitado no campo pequisar.
	$userSearch = (isset($_GET['userSearch']) ? strtoupper($_GET['userSearch']) : 'vazio');
 
    $user = new Users();
    $resultPage;

   	if($userSearch != 'vazio') {
   		$resultPage = $user->userSearch($userSearch);
   	}elseif($userSearch == 'vazio'){
   		// função de consulta no banco
		$resultPage = $user->userList();
   	}

   	/* ============== Zebra Pagination ================= */

   	// let's paginate data from an array...
$countries = $resultPage;
// how many records should be displayed on a page?
$records_per_page = 20;

// include the pagination class
	require '../../vendor/stefangabos/zebra_pagination/Zebra_Pagination.php';

// instantiate the pagination object
$pagination = new Zebra_Pagination();

// the number of total records is the number of records in the array
$pagination->records(count($countries));

// records per page
$pagination->records_per_page($records_per_page);

// here's the magic: we need to display *only* the records for the current page
$countries = array_slice(
    $countries,
    (($pagination->get_page() - 1) * $records_per_page),
    $records_per_page
);

?>
<!DOCTYPE html>
	<html>
	<head>
	  	<title>Listar Usuários</title>
	  	<meta charset="UTF-8">
		<!-- Bootstrap Local -->  
		<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	    <!-- Link Personal style.css -->
	    <link rel="stylesheet" href="../../vendor/stefangabos/zebra_pagination/public/zebra_pagination.css" type="text/css">
	    <!-- Link Personal style.css -->
	    <link rel="stylesheet"  href="../../css/home-style.css">
	    <!-- Link jquery 3.4.1 -->
    	<script src="../../js/jquery.js"></script>
	</head>
	<body>	
		<div class="container">
            <?php 
               require_once '../../forms/header-users.php';
            ?>
            <h1 class="text-center mb-3" style="margin-top: 140px">Lista de Usuários</h1>    
            <div>
			    <table class="table shadow-lg table-hover table-striped table-bordered">
			    	<div class="d-flex justify-content-end">
			    		<form method="get" action="userList.php">
			    			<div class="form-group">
			    				<input type="text" class="form-control border rounded-right-0" name="userSearch" placeholder="nome de usuário" required="" maxlength="30" autocomplete="off">
			    			</div>
			    			<div class="form-group">
			    				<button type="submit" class="btn btn-primary border rounded-left-0">Pesquisar</button>
			    				<a href="exportXls.php" class="btn btn-primary" id="" name="export">Exportar</a>
			    				<a href="../../forms/content-home-admin.php" class="btn btn-primary">Início</a>
			    			</div>
			    		</form>
			    	</div>
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
			        foreach($countries as $rowUser) {

			            ?>
			            <tr class="text-center border font-italic" id="dvData">
			              <th scope="row" class="border-right "><?php echo $rowUser['CODIGO_USUARIO']; ?></th>
			              <td class="border-right"><?php echo utf8_decode($rowUser['NOME_COMPLETO']); ?></td>
			              <td class="border-right"><?php echo $rowUser['NOME']; ?></td>
			              <td class="border-right"><?php echo $rowUser['CPF']; ?></td>
			              <td class="border-right"><?php echo md5($rowUser['SENHA']); ?></td>
			              <td class="border-right"><?php echo $rowUser['TIPO_USUARIO']; ?></td>
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
			     <?php
            		// render the pagination links
					$pagination->render();
				 ?>
				 <a class=" mb-5 btn btn-primary m2-2" href="javascript:history.back(-1)">Voltar</a>
            </div>         	
        </div>
	</body>
</html>
