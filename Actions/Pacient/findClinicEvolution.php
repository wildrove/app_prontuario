<?php

echo "<pre>";
var_dump($_GET);
$evoType;

if ($_GET['tipoResumo'] == "evolucao" && !empty($_GET['selectEvo'])) {
	$evoType = $_GET['selectEvo'];
}

var_dump($evoType);