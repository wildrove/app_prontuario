<?php	
	require '../../vendor/autoload.php';
	use Classes\Pacient\Pacient;

	$nomePaciente = strtoupper($_POST['paciente']);
	$dataNascimento = $_POST['dtNasc'];

	$pacient = new Pacient();

	$resultData = $pacient->findPacient($nomePaciente, $dataNascimento);

	$count = (is_array($resultData) ? count($resultData) : 0);

	if(($resultData) AND ($count != 0)){
?>		
	
	<div class="container-fluid">
		<table class="table">
			  <thead class="thead-dark">
			    <tr class="text-center">
			      <th scope="col" class="border-right">REGISTRO PRONTUÁRIO</th>
			      <th scope="col" class="border-right">NOME PACIENTE</th>
			      <th scope="col" class="border-right">DATA NASCIMENTO</th>
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
	</div>
<?php	
}else{
	echo "<div class='alert alert-danger' role='alert'>Nenhum usuário encontrado!</div>";
}