<?php
	
	session_start();
	// valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
	if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
		header('Location: ../../index.php?login=erro2');
		exit();
	}
	// variavel para validar o link de redirecionar para o inicio;
	$redirect = $_SESSION['usuario_nivel_acesso'];
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
	
	$pacientProntuary = intval($_GET['regProntuary']);
	$pacientRegistry = (isset($_GET['regPacient']) ? intval($_GET['regPacient']) : "");
	$exameDate = (isset($_GET['exameDate']) ? $_GET['exameDate'] : "");
	$pacientName = (isset($_GET['pacientName']) ? $_GET['pacientName'] : "");
	$mother = (isset($_GET['mother']) ? $_GET['mother'] : "");
	$birthday = (isset($_GET['birthday']) ? date('d/m/Y', strtotime($_GET['birthday'])) : "");
	$exameCode = (isset($_GET['exameCode']) ? $_GET['exameCode'] : "");
	$nLaudo = (isset($_GET['nLaudo']) ? intval($_GET['nLaudo']) : "");
	$doctor = (isset($_GET['doctor']) ? $_GET['doctor'] : "");
	$resumeType = (isset($_GET['resumeType']) ? $_GET['resumeType'] : "");


	// Procura a alta do paciente na tabela PEP_RESUMO_ALTA 
	$pacientEvo = $pacientEvolution->pacientImageExameResume($pacientRegistry, $nLaudo, $exameCode, $exameDate);

	// Função para substituir os caracteres especiais por letras com acento.
	$pacientEvo = $pacientEvolution->convertEvoLetter($pacientEvo, 'RESULTADO');

	/*=========== Atribuição de variáveis para criação do texto e documento ================*/

	foreach ($pacientEvo as $key => $value) {
		$rtf = utf8_encode($pacientEvo[$key]['RESULTADO']);
		$rtfDoc = $pacientEvo[$key]['RESULTADO'];
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
	$textrun->addText('Dt. Laudo: ', ['size' => 12, 'bold' => true, 'name' => 'Arial']);
	$textrun->addText(date('d/m/Y', strtotime($exameDate)) . '   ');
	$textrun->addTextBreak(2);
	$textrun->addText('                                       Exame Imagem', ['bold' => true, 'size' => 15, 'name' => 'Arial']);// 20 Space.
	$textrun->addTextBreak(2);
	$textrun->addText($rtfDoc);
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
	ob_start();
	$objWriter->save('../../file/laudo imagem.docx');
	$file_path = '../../file/laudo imagem.docx';

	/*============= Pegar a Idade atual ====================*/

	$birthdayDate = str_replace("-", "", $_GET['birthday']);
	$birthdayDate = new DateTime($birthdayDate);
	$currentYear = new DateTime('today');
	$age = $birthdayDate->diff($currentYear)->y . " anos";

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
<body class=".stop-scrolling">
	<div class="row"><!-- Div de loading -->
		<div class="load" style="top: 30%; left: 43%; position: fixed;">
         	<img class="loading-img" src="../../img/load.gif">
         		<h6 class="text-dark font-weight-bold">Aguarde...</h6>
      	</div>
	</div><!-- Fim Div de loading -->
	<div class="container mt-3 p-3 shadow shadow-lg font-pacient-type">
		<section class="" style="border: 1px solid #000000"><!-- Sessão Paciente -->
			<div class="row">
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
			</div>
			<div class="row d-flex justify-content-center">
				<h4 class="">Exame de Imagem</h4>
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
					<label class="col-form-label ">Dt. Nasc:</label>
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
					<label class="col-form-label">Dt. Exame:</label>
					<input class="form-control-plaintext input-pacient" type="text" name="dtEvo" value="<?php echo date('d/m/Y', strtotime($exameDate)) ?>" disabled="">
				</div>
				<div class="form-group pacient-group">
					<label class="col-form-label">Profissional:</label>
					<input class="form-control-plaintext input-pacient-names" type="text" name="tipoEvo" value="<?php echo $doctor ?>" disabled="">
				</div>
			</div><!-- Fim Linha 1 -->
			<!-- Div com borda Divisória -->
			<div class="row pacient-border-divisor"></div>
			<div class="row container pacient-discription resume-print"><!-- Inicio Texto descrição -->
				<span class="rtf-evo exibir-resumo print-resume-font">
					<?php 
						
					if(strlen($rtf) < 1500){
						echo wordwrap($rtf);
					}else{
						
						$rtf = trim($rtf);
						$document = new Document($rtf);
						$formatter = new HtmlFormatter('UTF-8');
						echo $formatter->Format($document) . '<br>';	
					}

					?>	
				</span>			
			</div><!-- Fim texto Descrição -->	
		</section><!-- Fim Sessão Paciente -->
	</div>
	<div class="container">
		<div class="botoes-imprimir botoes-imprimir-evolucao">
			<a class="btn btn-primary mt-5 mb-5 back-filter" href="javascript:history.back()">Voltar</a>
			<button class="btn btn-primary mt-5 mb-5" type="button" onclick="imprimir();">Imprimir</button>
			<a href="exportEvoDoc.php?regPacient=<?php echo $pacientRegistry  . '&exameDate=' . $exameDate  . '&resumeType=' . $resumeType . '&nLaudo=' . $nLaudo . '&exameCode=' . $exameCode;  ?>" class="btn btn-primary">Download</a>
			<a type="button" class="btn btn-primary" href="<?php echo $file_path ; ?>">Baixar Laudo</a>
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







