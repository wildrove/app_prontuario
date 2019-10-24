<?php	

	session_start();
	require_once '../../forms/headerUserPacientList.php';
	require '../../vendor/autoload.php';

	use Classes\Pacient\Pacient;

	// Pegar data do formulario content-home.php
	$birthday = (isset($_GET['dtNasc'])) ? $_GET['dtNasc'] : '';
	//pegar nome do paciente
	$name = (isset($_GET['paciente'])) ? strtoupper($_GET['paciente']) : '';
	//itens por página
	$itemsPerPage = 3;
	//pegar página atual
	$currentPage = (isset($_GET['page'])) ? $_GET['page'] : 0;

	// multiplica pagina atual * limite por página para gerar paginação
	$page = ($currentPage * $itemsPerPage);

	$pacient = new Pacient();

	$resultData = $pacient->findPacient($name, $birthday, $page, $itemsPerPage);
	// pega a quantidade total de objetos no banco de dados
	$totalRows = $pacient->getTotalPacient($name, $birthday);
	// definir numero de páginas
	$numPages = ceil($totalRows / $itemsPerPage);


	// verifica se nome e data nascimento são vazios
	if(($name === '') && ($birthday === '')){
		header('Location: ../../AlertsHTML/alertInvalidPacient.html');
		exit;
	}

	// verifca se a data é inválido
	if(($birthday !== $resultData) && ($name === '')){
		header('Location: ../../AlertsHTML/invalidDate.html');
		exit;
	}

	// validar se o nome é inválido

	
	
	// verifica se o a variavel é um array e atribui ao contador
	$count = (is_array($resultData) ? count($resultData) : 0);

	if(($resultData) AND ($count > 0)){
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
				   <a class="page-link" href="findPacient.php?page=0&paciente=<?php if(isset($_GET['paciente']))($_SESSION['nomeP'] = $name); echo $_SESSION['nomeP']; ?>&data=<?php if(isset($_GET['dtNasc']))($_SESSION['data'] = $birthday); echo $_SESSION['data']; ?>">Primeira</a>
				</li>
				<?php 
				for($i=0;$i<$numPages;$i++){
				$style = "";
				if($currentPage == $i)
				    $style = "class=\"active page-item\"";
				?>
				<li <?php echo $style; ?> ><a class="page-link" href="findPacient.php?page=<?php echo $i; ?>&paciente=<?php if(isset($_GET['paciente']))($_SESSION['nomeP'] = $name); echo $_SESSION['nomeP']; ?>&data=<?php if(isset($_GET['dtNasc']))($_SESSION['data'] = $birthday); echo $_SESSION['data']; ?>"><?php echo $i+1; ?></a></li>
				<?php } ?>
				<li class="page-item">
				   <a class="page-link" href="findPacient.php?page=<?php echo $numPages-1;?>&paciente=<?php if(isset($_GET['paciente']))($_SESSION['nomeP'] = $name); echo $_SESSION['nomeP']; ?>&data=<?php if(isset($_GET['dtNasc']))($_SESSION['data'] = $birthday); echo $_SESSION['data']; ?>">Última</a>
				</li>
			</ul>
		</nav>
	</div>
<?php	
}
	echo "<div style='padding: 10px'>";
	echo "<button class='btn btn-primary'><a class='text-light' href='../../home.php'>voltar</a></button>";
	echo "</div>";
?>
