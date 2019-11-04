<?php

	session_start();
	require '../../vendor/autoload.php';

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	$regProntuary = intval($_GET['regProntuary']);

	$findDate = new PacientEvolution();

	$evolutionDate = $findDate->changeColumnValue($findDate->findEvolutionDate($regProntuary), 'TIPO');

	echo "<pre>";
	var_dump($evolutionDate);


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
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

</body>
</html>	










