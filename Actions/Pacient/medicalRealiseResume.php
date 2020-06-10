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

	
	$pacientProntuary = intval($_GET['regProntuary']);
	$pacientRegistry = (isset($_GET['regPacient']) ? intval($_GET['regPacient']) : "");
	$medicalHour = $_GET['medicalHour'];
	$medicalDate = $_GET['medicalDate'];
	$pacientName = (isset($_GET['pacientName']) ? $_GET['pacientName'] : "");
	$mother = (isset($_GET['mother']) ? $_GET['mother'] : "");
	$birthday = (isset($_GET['birthday']) ? date('d/m/Y', strtotime($_GET['birthday'])) : "");
	$doctor = (isset($_GET['doctor']) ? $_GET['doctor'] : "");
	$resumeType = (isset($_GET['resumeType']) ? $_GET['resumeType'] : "");
	

	$pacientEvolution = new PacientEvolution();
	$rtf = null;

	// Procura a alta do paciente na tabela PEP_RESUMO_ALTA 
	$pacientEvo = $pacientEvolution->pacientMedicalRealiseResume($pacientProntuary, $medicalDate, $medicalHour);


	/*=========== Atribuição de variáveis para criação do texto e documento ================*/

	foreach ($pacientEvo as $key => $value) {
		$rtf = $pacientEvo[$key]['DIAGNOSTICO_ALTA'];
		$rtfDoc = $pacientEvo[$key]['DIAGNOSTICO_ALTA'];
		$assinged = $pacientEvo[$key]['DESCRICAO_CERTIFICADO'];
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
	$textrun->addText('Dt. Alta: ', ['size' => 12, 'bold' => true, 'name' => 'Arial']);
	$textrun->addText(date('d/m/Y', strtotime($medicalDate)) . '   ');
	$textrun->addTextBreak(2);
	$textrun->addText('                    Resumo de Alta', ['bold' => true, 'size' => 15, 'name' => 'Arial']);// 20 Space.
	$section->addText('_________________________'); //25
	$textrun->addTextBreak(2);
	$section->addText('Assinado digitalmente por:', ['size' => 10]);
	//$textrun->addTextBreak(1);
	$section->addText($assinged, ['bold' => true]);
	$textrun->addText($rtfDoc);
	$textrun->addTextBreak(5);
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'RTF');
	ob_start();
	$objWriter->save('../../file/resumo alta.rtf');
	$file_path = '../../file/resumo alta.rtf';

	/*========== Instancia o objeto que convert o RTF ============= */
	$rtf = trim($rtf);
	$document = new Document($rtf);
	$formatter = new HtmlFormatter('UTF-8');

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<link rel="stylesheet"  href="../../bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet"  href="../../css/estilo.css">
	<link rel="stylesheet"  href="../../css/print.css" media="print">
	<script type="text/javascript">
		function printPage(){
			window.print();
		}
	</script>
</head>
<body>
	<div class="container p-3 mt-3 shadow shadow-lg font-pacient-type">
		<section class="border-section"><!-- Sessão Paciente -->
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
				<h4 class="">Resumo de Alta</h4>
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
					<label class="col-form-label">Dt. Alta:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="dtEvo" value="<?php echo date('d/m/Y', strtotime($medicalDate)) ?>" disabled="">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Profissional:</label>
					<input class="form-control-plaintext input-pacient-names" type="text" name="tipoEvo" value="<?php echo $doctor ?>" disabled="">
				</div>
			</div><!-- Fim Linha 1 -->
			<!-- Div com borda Divisória -->
			<div class="row pacient-border-divisor"></div>
			<div class="row container pacient-discription resume-print"><!-- Inicio Texto descrição -->
				<span class="rtf-evo">
					<?php 
						echo $formatter->Format($document) . '<br>';
						echo '___________________________' . '<br>';	
						echo 'Assinado digitalmente por: ' . '<br>';
						echo '<strong>' . $assinged . '</strong>';			
					?>	
				</span>			
			</div><!-- Fim texto Descrição -->	
		</section><!-- Fim Sessão Paciente -->
	</div>
	<div class="container">
		<div class="botoes-imprimir botoes-imprimir-evolucao">
			<button class="btn btn-primary mt-5 mb-5" type="button" name=""onclick="goBack()">Voltar</button>
			<button class="btn btn-primary mt-5 mb-5" type="button" onclick="imprimir();">Imprimir</button>
			<a href="exportEvoDoc.php?regProntuary=<?php echo $pacientProntuary  . '&medicalDate=' . $medicalDate  . '&medicalHour=' . $medicalHour . '&resumeType=' . $resumeType;  ?>" class="btn btn-primary">Download</a>
			<a type="button" class="btn btn-primary" href="<?php echo $file_path ; ?>">Baixar Resumo</a>
		</div>
	</div>
	<script type="text/javascript">
		function goBack(){
			window.history.go(-1);
		}
	</script>

	<script>
		function imprimir(){
			window.print();
		}
	</script>
</body>
</html>







