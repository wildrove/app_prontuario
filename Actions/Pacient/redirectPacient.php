<?php

session_start();
// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
	}
require '../../vendor/autoload.php';

echo "<pre>";
var_dump($_GET);
$evoType = isset($_GET['tipoResumo']) ? $_GET['tipoResumo'] : "";
$selectEvo = isset($_GET['selectEvo']) ? $_GET['selectEvo'] : "";
$selectClinicEvo = isset($_GET['selectClinicEvo']) ? $_GET['selectClinicEvo'] : "";
$prontuario = (isset($_GET['regProntuary']) ? intval($_GET['regProntuary']) : "");
$tipoResumo = (isset($_GET['tipoResumo']) ? $_GET['tipoResumo'] : "");
$mae = (isset($_GET['mother']) ? $_GET['mother'] : "");
$aniversario = (isset($_GET['birthday']) ? $_GET['birthday'] : "");
$tipoPaciente = (isset($_GET['tipoPaciente']) ? $_GET['tipoPaciente'] : "");


if ($tipoResumo == "evolucao") {
	header("Location: findEvolution.php?regProntuary=$prontuario&resumeType=$tipoResumo&pacientType=$tipoPaciente&selectEvo=$selectEvo");

}elseif ($tipoResumo == "alta") {
	header("Location: findMedicalRealise.php?regProntuary=$prontuario&resumeType=$tipoResumo&pacientType=$tipoPaciente");
}elseif($tipoResumo == "cirurgia"){
	header("Location: findCirurgicalRealise.php?regProntuary=$prontuario&resumeType=$tipoResumo&pacientType=$tipoPaciente");
}elseif($tipoResumo == "imagem") {
	header("Location: findImageExame.php?regProntuary=$prontuario&resumeType=$tipoResumo&birthday=$aniversario&mother=$mae&pacientType=$tipoPaciente");
}elseif ($tipoResumo == "consultorio") {
	header("Location: findClinicEvolution.php?regProntuary=$prontuario&resumeType=$tipoResumo&pacientType=$tipoPaciente&selectClinicEvo=$selectClinicEvo");
}
