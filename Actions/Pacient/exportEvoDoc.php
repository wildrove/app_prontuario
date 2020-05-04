<?php
    session_start();
    // valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
    if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
        header('Location: ../../index.php?login=erro2');
        exit();
    }elseif(isset($_SESSION['usuario_nivel_acesso']) && $_SESSION['usuario_nivel_acesso'] != 'Administrador'){
        header('Location: ../../index.php?login=erro3');
        session_destroy();
        exit();
    }

    // parametros para função
    $pacientProntuary = (isset($_GET['regProntuary']) ? intval($_GET['regProntuary']) : "");
    $hourEvo = isset($_GET['hourEvolution']) ? $_GET['hourEvolution'] : "";
    $dateEvo = isset($_GET['dateEvolution']) ? $_GET['dateEvolution'] : "";
    $medicalDate = isset($_GET['medicalDate']) ? $_GET['medicalDate'] : "";
    $medicalHour = isset($_GET['medicalHour']) ? $_GET['medicalHour'] : "";
    $resumeType = isset($_GET['resumeType']) ? $_GET['resumeType'] : "";
    $cirurgicalDate = isset($_GET['cirurgicalDate']) ? $_GET['cirurgicalDate'] : "";
    $regPacient = isset($_GET['regPacient']) ? intval($_GET['regPacient']) : "";

    $result;
    $pacientEvo;
    $arquivo;

    //declaramos uma variavel para monstarmos a tabela
    $dadosWord  = "";
    
    require '../../vendor/autoload.php';
    use Classes\Pacient\PacientEvolution\PacientEvolution;

    //instanciamos
    $pacientEvo = new PacientEvolution();

    // Validar o tipo de resumo antes de realizar a consulta no banco.
    if ($resumeType == 'evolucao') {
        $result = $pacientEvo->pacientEvo($pacientProntuary, $dateEvo, $hourEvo);
        // Definimos o nome do arquivo que será exportado  
        $arquivo = "Paciente Evolução.doc";
        //varremos o array com o foreach para pegar os dados de acordo com o tipo de resumo.
        foreach($result as $res){
            $dadosWord .= $res['EVOLUCAO'];       
        }

    }elseif($resumeType == 'alta'){
        $result = $pacientEvo->pacientMedicalRealiseResume($pacientProntuary, $medicalDate, $medicalHour);
        // Definimos o nome do arquivo que será exportado  
        $arquivo = "Resumo Alta.doc";
        //varremos o array com o foreach para pegar os dados de acordo com o tipo de resumo.
        foreach($result as $res){
            $dadosWord .= $res['DIAGNOSTICO_ALTA'];    
        }

    }elseif ($resumeType = 'cirurgia') {
        $result = $pacientEvo->pacientCirurgicalRealiseResume($regPacient, $cirurgicalDate);
        // Definimos o nome do arquivo que será exportado  
        $arquivo = "Resumo Cirurgia.doc";
        foreach ($result as $res) {
            $dadosWord .= $res['TEXTO'];
        }
    }
    
 
    
    // Configurações header para forçar o download  
    header('Content-Type: application/vnd.ms-doc');
    header('Content-Disposition: attachment;filename="'.$arquivo.'"');
    header('Cache-Control: max-age=0');
    // Se for o IE9, isso talvez seja necessário
    header('Cache-Control: max-age=1');
       
    // Envia o conteúdo do arquivo 
    echo  $dadosWord;  
    exit;
?>