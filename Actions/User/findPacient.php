<?php 

	
	$paciente = $_POST['paciente'];
	$dtNascimento = $_POST['dtNasc'];
	$tipoPaciente = $_POST['tipoPaciente'];

	if(isset($_POST)){

		if($paciente == null && $dtNascimento == null && $tipoPaciente == null){
		echo 'Pelo menos um campo deve ser selecionado!';
		}else {
		echo "<pre>";
		print_r($_POST);
		}
		
	}
