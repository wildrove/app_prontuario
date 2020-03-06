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
    //declaramos uma variavel para monstarmos a tabela
    $dadosWord  = "";
    $dadosWord = "<div>";


    require '../../vendor/autoload.php';
    use Classes\PacientEvolution\PacientEvolution;
    //instanciamos
    $pacientEvo = new PacientEvolution();
    $result = $pacientEvo->pacientEvo();
    //varremos o array com o foreach para pegar os dados
    
    foreach($result as $res){
        $dadosWord .= "      <tr>";
        $dadosWord .= "          <td>".$res['CODIGO_USUARIO']."</td>";
        $dadosWord .= "          <td>".$res['NOME_COMPLETO']."</td>";
        $dadosWord .= "          <td>".$res['NOME']."</td>";
        $dadosWord .= "          <td>".$res['CPF']."</td>";
        $dadosWord .= "          <td>".$res['SENHA']."</td>";
         $dadosWord .= "         <td>".$res['TIPO_USUARIO']."</td>";
        $dadosWord .= "      </tr>";
    }
    $dadosWord .= "  </div>";
 
    // Definimos o nome do arquivo que será exportado  
    $arquivo = "Paciente Evolução.doc";  
    // Configurações header para forçar o download  
    header('Content-Type: application/vnd.ms-word');
    header('Content-Disposition: attachment;filename="'.$arquivo.'"');
    header('Cache-Control: max-age=0');
    // Se for o IE9, isso talvez seja necessário
    header('Cache-Control: max-age=1');
       
    // Envia o conteúdo do arquivo  
    echo  utf8_decode($dadosWord);  
    exit;
?>