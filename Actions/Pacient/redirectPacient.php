<?php

session_start();
require '../../vendor/autoload.php';


$prontuario = (isset($_GET['regProntuary']) ? intval($_GET['regProntuary']) : "");
$tipoResumo = (isset($_GET['tipoResumo']) ? $_GET['tipoResumo'] : "");
$mae = (isset($_GET['mother']) ? $_GET['mother'] : "");
$aniversario = (isset($_GET['birthday']) ? $_GET['birthday'] : "");

if ($tipoResumo == "evolucao") {
	header("Location: findEvolution.php?regProntuary=$prontuario&resumeType=$tipoResumo");

}elseif ($tipoResumo == "alta") {
	header("Location: findMedicalRealise.php?regProntuary=$prontuario&resumeType=$tipoResumo");
}elseif($tipoResumo == "cirurgia"){
	header("Location: findCirurgicalRealise.php?regProntuary=$prontuario&resumeType=$tipoResumo");
}else {
	header("Location: findImageExame.php?regProntuary=$prontuario&resumeType=$tipoResumo&birthday=$aniversario&mother=$mae");
}
