<?php
	
	session_start();
	// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
	}
	
	require '../../vendor/autoload.php';
	require('../../RtfCleanText/cleanRtf.php');

	use Classes\Pacient\PacientEvolution\PacientEvolution;
	use RtfHtmlPhp\Document;
	use RtfHtmlPhp\Html\HtmlFormatter;
	use PhpOffice\PhpWord\PhpWord; //usando a classe PhpWord
	use PhpOffice\PhpWord\IOFactory; //usando a classe IOFactory
	use PhpOffice\PhpWord\TemplateProcessor;
	use PhpOffice\PhpWord\Shared\Html;
	

	$pacientEvolution = new PacientEvolution();
	$rtf = null;
	$assinged = null;
	$rtfDoc = null;

/* ================== Declaração de variaveis para atribuir valores do Form ========== */
	// variavel para validar o link de redirecionar para o inicio;
	$redirect = $_SESSION['usuario_nivel_acesso'];
	$pacientProntuary = intval($_GET['regProntuary']);
	$pacientRegistry = (isset($_GET['regPacient']) ? intval($_GET['regPacient']) : "");
	$hourEvo = $_GET['hourEvolution'];
	$dateEvo = $_GET['dateEvolution'];
	$pacientName = (isset($_GET['pacientName']) ? $_GET['pacientName'] : "");
	$mother = (isset($_GET['mother']) ? $_GET['mother'] : "");
	$birthday = (isset($_GET['birthday']) ? date('d/m/Y', strtotime($_GET['birthday'])) : "");
	$type = (isset($_GET['type']) ? $_GET['type'] : "");
	$resumeType = (isset($_GET['resumeType']) ? $_GET['resumeType'] : "");

	
	// Procura a evolução do paciente na tabela PEP_EVOLUCAO_MEDICA OU EVOLUCAO_WARELINE (SISTEMA ANTIGO)
	$pacientEvo = $pacientEvolution->pacientEvo($pacientProntuary,$dateEvo,$hourEvo);
	
/*=========== Atribuição de variáveis para criação do texto e documento ================*/

foreach ($pacientEvo as $key => $value) {
	$rtf = $pacientEvo[$key]['EVOLUCAO'];
	$rtfDoc = $pacientEvo[$key]['EVOLUCAO'];
	$assinged = isset($pacientEvo[$key]['DESCRICAO_CERTIFICADO']) ? $pacientEvo[$key]['DESCRICAO_CERTIFICADO'] : "não existe";
}


/* ====== Valida se alguma evolução foi criada sem ser preenchida. ===== */

if (strlen($rtf) <= 0) {
	header('Location: ../../AlertsHTML/alertNoneEvolutionFound.html');
}

/* ========= Cria um novo documento e salva na pasta File. ========= */
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection();
$section->addImage('../../img/hospital-logo.jpg',array('width' => 75, 'height' => 75, 'alignment'=> \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$textrun = $section->addTextRun();
$textrun->addText('               HOSPITAL E MATERNIDADE SÃO LUCAS', ['size' => 15, 'bold' => true, 'name' => 'Arial']); // 15 de espaço
$textrun->addTextBreak(1);
$textrun->addText('                    Rua: Mauri Bueno de Andrade Nº 101 - Extrema/MG - Fone: (35) 3100 - 9550', array('align' => 'center')); //29 space.
$textrun->addTextBreak(2);
$textrun->addText('Paciente: ', ['size' => 12, 'bold' => true, 'name' => 'Arial']);
$textrun->addText($pacientName . '   ');
$textrun->addText('Dt. Nasc: ', ['size' => 12, 'bold' => true, 'name' => 'Arial']);
$textrun->addText($birthday . '   ');
$textrun->addText('Nº Porntuário: ', ['size' => 12, 'bold' => true, 'name' => 'Arial']);
$textrun->addText($pacientProntuary);
$textrun->addTextBreak(1);
$textrun->addText('Mãe: ', ['size' => 12, 'bold' => true, 'name' => 'Arial']);
$textrun->addText($mother . '   ');
$textrun->addText('Dt. Evolução: ', ['size' => 12, 'bold' => true, 'name' => 'Arial']);
$textrun->addText(date('d/m/Y', strtotime($dateEvo)) . '   ');
$textrun->addTextBreak(2);
$textrun->addText('                    EVOLUÇÃO MÉDICA', ['bold' => true, 'size' => 15, 'name' => 'Arial']);// 20 Space.
if($assinged != "não existe"){
	$section->addText('_________________________'); //25
	$textrun->addTextBreak(2);
	$section->addText('Assinado digitalmente por:', ['size' => 10]);
	$section->addText($assinged, ['bold' => true]);
}else{
	$textrun->addTextBreak(2);
}
$textrun->addText($rtfDoc);
$textrun->addTextBreak(4);
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'RTF');
ob_start();
$objWriter->save('../../file/evolucao medica.rtf');
$file_path = '../../file/evolucao medica.rtf';

/*============= Pegar a Idade atual ====================*/

$birthdayDate = str_replace("-", "", $_GET['birthday']);
$birthdayDate = new DateTime($birthdayDate);
$currentYear = new DateTime('today');
$age = $birthdayDate->diff($currentYear)->y . " anos";

/* =========== Separar o nome do paciente ======================== */
$pacientN = explode(" ", $pacientName);

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet"  href="../../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet"  href="../../css/estilo.css">
	<link rel="stylesheet"  href="../../css/print.css" media="print">
	<script src="../../js/jquery.js"></script>
	<script type="text/javascript">
		function printPage(){
			window.print();
		}
	</script>
</head>
<body>
	<div class="row"><!-- Div de loading -->
		<div class="load" style="top: 30%; left: 43%; position: fixed;">
         	<img class="loading-img" src="../../img/load.gif">
         	<h6 class="text-dark font-weight-bold">Aguarde...</h6>
      	</div>
	</div><!-- Fim Div de loading -->
	<div class="container p-3 mt-2 shadow shadow-lg font-pacient-type">
		<section class=" border-section"><!-- Sessão Paciente -->
			<div class="row"><!-- Cabeçalho Hospital -->
				<div class="col-sm">
					<img class="p-2" src="../../img/hospital-header-logo.png">
				</div>
				<div class="col-sm p-3">
					<div>
						<h3 style="font-size: 25px;">HOSPITAL MATERNIDADE SÃO LUCAS</h3>
						<h6>Rua: Mauri Bueno de Andrade Nº 101 - Extrema / MG</h6>
						<h6 class="float-center">Fone: (35) 3100-9550</h6>			
					</div>
				</div>
			</div><!-- Fim linha cabeçalho Hospital -->
			<div class="row d-flex justify-content-center">
				<h4 class="">Resumo de Evolução</h4>
			</div>
			<!-- Div com borda Divisória -->
			<div class="row pacient-border-divisor"></div>
			<div class="row m-2">
				<h4>Dados do Paciente</h4>
			</div>
			<div class="row pl-4"><!-- Linha 1 -->
				<div class="form-group pacient-group">
					<label class="col-form-label">Paciente:</label>
					<input class="form-control-plaintext input-pacient-names" type="text" name="nomePaciente" value="<?php echo $pacientName ?>"  disabled="">
				</div>
				<div class="form-group pacient-group pacient-header-input-width">
					<label class="col-form-label">Dt. Nasc:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="dtNascimento" value="<?php echo $birthday ?>" disabled="">
				</div>
				<div class="form-group pacient-group pacient-header-input-width">
					<label class="col-form-label">Idade:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="tipoEvo" value="<?php echo $age ?>" disabled="">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Mãe:</label>
					<input class="form-control-plaintext input-pacient-names" type="text" name="nomeMae" value="<?php echo $mother ?>" disabled="">
				</div>
				<div class="form-group pacient-group pacient-header-input-width">
					<label class="col-form-label">Prontuário:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="prontuario" value="<?php echo $pacientProntuary ?>" disabled="">
				</div>
				<div class="form-group pacient-group pacient-header-input-width">
					<label class="col-form-label">Reg. Paciente:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="regPaciente" value="<?php echo $pacientRegistry ?>" disabled="">
				</div>
				<div class="form-group pacient-group pacient-header-input-width">
					<label class="col-form-label">Dt. Evolução:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="dtEvo" value="<?php echo date('d/m/Y', strtotime($dateEvo)) ?>" disabled="">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Tipo Evolução:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="tipoEvo" value="<?php echo $type ?>" disabled="">
				</div>
			</div><!-- Fim Linha 1 -->
			<!-- Div com borda Divisória -->
			<div class="row pacient-border-divisor"></div>
			<div class="row container pacient-discription resume-print"><!-- Inicio Texto descrição -->
				<span class="rtf-evo">
					<?php
					// Verifica o valor da variável $assigned e aplica a formatação do rtf.
					
					if ($assinged == "não existe" and strlen($rtf) <= 500) {
						$rtf = rtf2text(utf8_encode($rtf));
						echo wordwrap($rtf) . '<br>';
					}else{
						$rtf = rtrim($rtf, "\0");
						$document = new Document($rtf);
						$formatter = new HtmlFormatter('UTF-8');
						echo $formatter->Format($document) . '<br>';
						if ($assinged == "não existe") {
							unset($assinged);
						}else{
							echo '___________________________' . '<br>';	
							echo 'Assinado digitalmente por: ' . '<br>';
							echo '<strong>' . $assinged . '</strong>';	
						}
						
					}
							
					?>	
				</span>			
			</div><!-- Fim texto Descrição -->	
		</section><!-- Fim Sessão Paciente -->
	</div>
	<div class="container">
		<div class="botoes-imprimir botoes-imprimir-evolucao">
			<a class="btn btn-primary mt-5 mb-5 back-filter" href="javascript:history.back()">Voltar</a>
			<button class="btn btn-primary  mt-5 mb-5" type="button" onclick="imprimir();">Imprimir</button>
			<a href="exportEvoDoc.php?regProntuary=<?php echo $pacientProntuary . '&hourEvolution=' . $hourEvo . '&dateEvolution=' . $dateEvo . '&resumeType=' . $resumeType;  ?>" class="btn btn-primary" style="display: none">Download Evolução</a>
			<a type="button" class="btn btn-primary" href="<?php echo $file_path ; ?>">Baixar Evolução</a>
		</div>
	</div>	
	<script>
		function imprimir(){
			window.print();
		}
		
		// Habilita o gif de loading da pagina
		$('.back-filter').click(function(){
			$('.load').show();
		});

		$('.back-filter').click(function(){
			$('html, body').css({
    			overflow:'hidden',
   				height:'100%'
			});
		});	
	</script>
</body>
</html>










