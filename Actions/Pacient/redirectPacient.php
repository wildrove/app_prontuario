<?php

session_start();
require '../../vendor/autoload.php';

echo "<pre>";
var_dump($_GET);
$evoType = isset($_GET['tipoResumo']) ? $_GET['tipoResumo'] : "";
$selectEvo = isset($_GET['selectEvo']) ? $_GET['selectEvo'] : "";
$selectClinicEvo = isset($_GET['selectClinicEvo']) ? $_GET['selectClinicEvo'] : "";

if ($evoType == "evolucao" || $evoType == "consultorio" && !empty($selectEvo) && !empty($selectClinicEvo)) {
	echo "Não pode selecionar Evolução e consultório ao mesmo tempo";
}



exit();

$prontuario = (isset($_GET['regProntuary']) ? intval($_GET['regProntuary']) : "");
$tipoResumo = (isset($_GET['tipoResumo']) ? $_GET['tipoResumo'] : "");
$mae = (isset($_GET['mother']) ? $_GET['mother'] : "");
$aniversario = (isset($_GET['birthday']) ? $_GET['birthday'] : "");
$tipoPaciente = (isset($_GET['tipoPaciente']) ? $_GET['tipoPaciente'] : "");


if ($tipoResumo == "evolucao") {
	header("Location: findEvolution.php?regProntuary=$prontuario&resumeType=$tipoResumo&pacientType=$tipoPaciente");

}elseif ($tipoResumo == "alta") {
	header("Location: findMedicalRealise.php?regProntuary=$prontuario&resumeType=$tipoResumo&pacientType=$tipoPaciente");
}elseif($tipoResumo == "cirurgia"){
	header("Location: findCirurgicalRealise.php?regProntuary=$prontuario&resumeType=$tipoResumo&pacientType=$tipoPaciente");
}elseif($tipoResumo == "imagem") {
	header("Location: findImageExame.php?regProntuary=$prontuario&resumeType=$tipoResumo&birthday=$aniversario&mother=$mae&pacientType=$tipoPaciente");
}elseif ($tipoResumo == "consultorio") {
	header("Location: findClinicEvolution.php?regProntuary=$prontuario&resumeType=$tipoResumo&pacientType=$tipoPaciente");
}
