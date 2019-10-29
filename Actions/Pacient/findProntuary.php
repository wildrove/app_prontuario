<?php
	
	session_start();
	require '../../vendor/autoload.php';

	use Classes\Pacient\PacientEvolution\PacientEvolution;

	$x = new PacientEvolution();

	$x->teste();

$pacientProntuary = intval($_GET['prontuario']);
var_dump($pacientProntuary);

echo "<br><a href='../../home.php'><h3>Voltar</h3></a>";