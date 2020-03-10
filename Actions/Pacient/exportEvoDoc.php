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
    $pacientRegistry = (isset($_GET['regProntuary']) ? intval($_GET['regProntuary']) : "");
    $hourEvo = isset($_GET['hourEvolution']) ? $_GET['hourEvolution'] : "";
    $dateEvo = isset($_GET['dateEvolution']) ? $_GET['dateEvolution'] : "";

    //declaramos uma variavel para monstarmos a tabela
    $dadosWord  = "";
    $dadosWord .= "<pre>";
    
    require '../../vendor/autoload.php';
    use Classes\Pacient\PacientEvolution\PacientEvolution;

    //instanciamos
    $pacientEvo = new PacientEvolution();
    $result = $pacientEvo->pacientEvo($pacientRegistry, $dateEvo, $hourEvo);
    //varremos o array com o foreach para pegar os dados
    
    foreach($result as $res){

        $dadosWord .= $res['EVOLUCAO'];
        
    }
 
    // Definimos o nome do arquivo que será exportado  
    $arquivo = "Paciente Evolução.rtf";  
    // Configurações header para forçar o download  
    header('Content-Type: application/vnd.ms-rtf');
    header('Content-Disposition: attachment;filename="'.$arquivo.'"');
    header('Cache-Control: max-age=0');
    // Se for o IE9, isso talvez seja necessário
    header('Cache-Control: max-age=1');
       
    // Envia o conteúdo do arquivo 
    echo  $dadosWord;  
    exit;
?>