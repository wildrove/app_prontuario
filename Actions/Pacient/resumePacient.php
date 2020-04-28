<?php

session_start();
require '../../vendor/autoload.php';

echo "<pre>";
print_r($_GET);

$prontuario = (isset($_GET['regProntuary']) ? intval($_GET['regProntuary']) : "");
$tipoResumo = (isset($_GET['tipoResumo']) ? $_GET['tipoResumo'] : "");

if ($tipoResumo == "evolucao") {
	header("Location: findProntuaryDate.php?regProntuary=$prontuario");

}elseif ($tipoResumo == "alta") {
	header("Location: findMedicalRealise.php?regProntuary=$prontuario");
}
