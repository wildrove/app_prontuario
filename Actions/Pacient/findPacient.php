<?php	

	session_start();
	require_once '../../forms/headerUserPacientList.php';
	require '../../vendor/autoload.php';

	use Classes\Pacient\Pacient;

	// Nome recebido por POST
	$nomePaciente = strtoupper($_POST['paciente']);
	//Data Recebido por POST
	$dataNascimento = $_POST['dtNasc'];
	//pegar página atual
	$currentPage = (isset($_GET['page'])) ? $_GET['page'] : 0;
	//pegar nome do paciente
	$nome = (isset($_GET['paciente'])) ? $_GET['paciente'] : 'WILDER';
	//itens por página
	$itemsPerPage = 3;

	$pacient = new Pacient();

	$resultData = $pacient->findPacient($nome, $dataNascimento, $currentPage, $itemsPerPage);
	// pega a quantidade total de objetos no banco de dados
	$totalRows = $pacient->getTotalPacient($nome, $dataNascimento);
	// definir numero de páginas
	$numPages = ceil($totalRows / $itemsPerPage);


	$count = (is_array($resultData) ? count($resultData) : 0);

	if(($resultData) AND ($count > 0)){
?>		

<!DOCTYPE html>
<html>
<head>
	    <head>  
        <meta charset="utf-8">
        <title>Listar Pacientes</title>

        <!-- Bootstrap -->  
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

		<!-- Link Personal style.css -->
		<link rel="stylesheet" type="text/css" href="../../bootstrap/css/style.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    </head>
</head>
<body>

	<div class="container-fluid">
		<table class="table" style="margin-top: 180px;">
			  <thead class="thead-dark">
			    <tr class="text-center" style="font-size: 15px;">
			      <th scope="col" class="border-right">REG. PRONTUÁRIO</th>
			      <th scope="col" class="border-right">NOME PACIENTE</th>
			      <th scope="col" class="border-right">DT NASCIMENTO</th>
			      <th scope="col" class="border-right">Nº DOCUMENTO</th>
			      <th scope="col" class="border-right">NOME MÃE</th>
			      <th scope="col" class="border-right">Nº TELEFONE</th>
			      <th scope="col">AÇÃO</th>
			    </tr>
			  </thead>
			  <tbody>
			  <?php 
			  foreach($resultData as $rowPacient) {
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
		<nav>
			<ul class="pagination">
				<li class="page-item">
				   <a class="page-link" href="findPacient.php?page=0&paciente=WILDER">Anterior</a>
				</li>
				<?php 
				for($i=0;$i<$numPages;$i++){
				$style = "";
				if($currentPage == $i)
				    $style = "class=\"active page-item\"";
				?>
				<li <?php echo $style; ?> ><a class="page-link" href="findPacient.php?page=<?php echo $i; ?>&paciente=WILDER"><?php echo $i+1; ?></a></li>
				<?php } ?>
				<li class="page-item">
				   <a class="page-link" href="findPacient.php?page=<?php echo $numPages-1;?>&paciente=WILDER">Próximo</a>
				</li>
			</ul>
		</nav>
	</div>
<?php	
}else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum usuário encontrado!</div>";
}
	echo "<div style='padding: 10px'>";
	echo "<h6>Pagina atual: " . $currentPage . "<br></h6>";
	echo "<h6>Itens por página: " . $itemsPerPage . "<br></h6>";
	echo "<h6>Nome: " . $nomePaciente . "<br></h6>";
	echo "<h6>Get Nome: " . $nome . "<br></h6>";
	echo "<h6>" . var_dump($dataNascimento) . "</h6>";
	echo "</div>";
?>
