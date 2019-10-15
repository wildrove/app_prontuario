<?php
	
	require 'vendor/autoload.php';
	use Classes\FirebirdConnection\FirebirdConnection;
	use Classes\TesteConsulta\TesteConsulta;

	$test = new TesteConsulta();

	echo '<pre>';
	print_r($test->testeConsulta());

