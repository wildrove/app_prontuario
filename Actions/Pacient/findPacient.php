<?php 

	session_start();
    /*=== valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php === */
    if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM'){
      header('Location: ../index.php?login=erro2');
     }
        
	require '../../vendor/autoload.php';
	use Classes\Pacient\Pacient;

	// variavel para validar o link de redirecionar para o inicio;
	$redirect = $_SESSION['usuario_nivel_acesso'];	
	// Pegar data do formulario content-home.php
	$birthday = (isset($_GET['dtNasc'])) ? $_GET['dtNasc'] : $_SESSION['data'];
	//pegar nome do paciente
	$name = (isset($_GET['paciente'])) ? strtoupper($_GET['paciente']) : $_SESSION['nomeP'];


   	$pacient = new Pacient();
   	// função de consulta no banco
	$resultPage = $pacient->findPacient($name, $birthday);
 
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
	  	<title>PACIENTE</title>
	  	<meta charset="UTF-8">
		<!-- Bootstrap Local -->  
		<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	    <!-- Link Personal style.css -->
	    <link rel="stylesheet" href="../../vendor/stefangabos/zebra_pagination/public/zebra_pagination.css" type="text/css">
	    <link rel="stylesheet"  href="../../css/estilo.css">
	    <!-- Link jquery 3.4.1 -->
    	<link rel="stylesheet" type="text/css" href="../../js/jquery-3.4.1.js">
	</head>
	<body>
		<div class="container">
			<?php 
               include '../../forms/headerPacient.php';
            ?>
            <h1 class="text-center" style="margin-top: 150px">PACIENTE</h1>    
            <div style="margin-top: -30px;">
            	<div class="d-flex justify-content-end font-italic mb-2">
            		<a class="btn btn-lg btn-primary border-0" href="<?php if($redirect == "Administrador"){ echo '../../forms/content-home-admin.php';}else echo '../../forms/content-home-user.php'; ?>">Inicio</a>
            	</div>
			    <table class="table shadow-lg table-hover table-striped table-bordered">
			        <thead class="thead-dark">
			        	<tr class="text-center" style="font-size: 15px">
				            <th scope="col" class="border-right">PRONTUÁRIO</th>
				            <th scope="col" class="border-right">NOME PACIENTE</th>
				            <th scope="col" class="border-right">DATA NASCIMENTO</th>
				            <th scope="col" class="border-right">DOCUMENTO</th>
				            <th scope="col" class="border-right">NOME MÃE</th>
				            <th scope="col" class="border-right">TELEFONE</th>
				            <th scope="col">INFORMAÇÕES</th>
			          	</tr>
			        </thead>
			        <tbody>
			        	<?php 
				        	foreach($pacient as $rowPacient) { ?><!--- Inicio Laço -->
				            	<tr class="text-center border font-italic">
				              		<th scope="row" class="border-right "><?php echo $rowPacient['REGISTRO_PRONTUARIO']; ?></th>
				              		<td class="border-right"><?php echo utf8_encode($rowPacient['NOME']); ?></td>
				              		<td class="border-right"><?php echo date('d/m/Y', strtotime($rowPacient['DATA_NASCIMENTO'])); ?></td>
				              		<td class="border-right"><?php if(empty($rowPacient['DOCUMENTO'])){
	                        				echo '<b>-</b>';
	                      				}echo $rowPacient['DOCUMENTO']; ?></td>
				              		<td class="border-right"><?php if (empty($rowPacient['NOME_MAE'])) {
	                         		 		echo '<b>-</b>';
	                       				}echo utf8_encode($rowPacient['NOME_MAE']); ?></td>
				              		<td class="border-right"><?php if (empty($rowPacient['TELEFONE'])) {
	                         				 echo '<b>-</b>';
	                      				 }echo $rowPacient['TELEFONE']; ?></td>
				              		<td>
				                		<a href="pacientFilter.php?regProntuary=<?php echo $rowPacient['REGISTRO_PRONTUARIO'] ?>&pacientName=<?php echo $rowPacient['NOME']; ?>&pacientBirthday=<?php echo $rowPacient['DATA_NASCIMENTO']; ?>&motherName=<?php echo $rowPacient['NOME_MAE']; ?>" class="btn btn-primary">Pesquisar</a>
				              		</td>
				            	</tr>
				        <?php }?><!-- Fim do Laço -->
			        </tbody>
			    </table>
			    <?php 
            		// render the pagination links
					$pagination->render();
            	?>
			    <a class="btn btn-primary  mb-5 shadow-lg" <?php if($_SESSION['usuario_nivel_acesso'] == 'Administrador'){ echo "href='http://localhost/App_prontuario/forms/content-home-admin.php'";} ?> href="../../forms/content-home-user.php">Voltar</a>
            </div>
		</div>	
	</body>
</html>

   

