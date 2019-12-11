<?php
    //declaramos uma variavel para monstarmos a tabela
    $dadosXls  = "";
    $dadosXls .= "  <table border='1' >";
    $dadosXls .= "      <tr>";
    $dadosXls .= "        <th style='background-color: rgb(0,51,153);color: #fff; text-align: center;padding: 5px;'>ID</th>";
    $dadosXls .= "        <th style='background-color: rgb(0,51,153);color: #fff; text-align: center;padding: 5px;'>NOME COMPLETO</th>";
    $dadosXls .= "        <th style='background-color: rgb(0,51,153);color: #fff; text-align: center;padding: 5px;'>USUÁRIO</th>";
    $dadosXls .= "        <th style='background-color: rgb(0,51,153);color: #fff; text-align: center;padding: 5px;'>CPF</th>";
    $dadosXls .= "        <th style='background-color: rgb(0,51,153);color: #fff; text-align: center;padding: 5px;'>SENHA</th>";
    $dadosXls .= "        <th style='background-color: rgb(0,51,153);color: #fff; text-align: center;padding: 5px;'>TIPO USUÁRIO</th>";
    $dadosXls .= "      </tr>";


    require '../../vendor/autoload.php';
    use Classes\Users\Users;
    //instanciamos
    $user = new Users();
    $result = $user->test();
    //varremos o array com o foreach para pegar os dados
    
    foreach($result as $res){
        $dadosXls .= "      <tr>";
        $dadosXls .= "          <td>".$res['CODIGO_USUARIO']."</td>";
        $dadosXls .= "          <td>".$res['NOME_COMPLETO']."</td>";
        $dadosXls .= "          <td>".$res['NOME']."</td>";
        $dadosXls .= "          <td>".$res['CPF']."</td>";
        $dadosXls .= "          <td>".$res['SENHA']."</td>";
         $dadosXls .= "         <td>".$res['TIPO_USUARIO']."</td>";
        $dadosXls .= "      </tr>";
    }
    $dadosXls .= "  </table>";
 
    // Definimos o nome do arquivo que será exportado  
    $arquivo = "Lista usuarios.xls";  
    // Configurações header para forçar o download  
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$arquivo.'"');
    header('Cache-Control: max-age=0');
    // Se for o IE9, isso talvez seja necessário
    header('Cache-Control: max-age=1');
       
    // Envia o conteúdo do arquivo  
    echo  utf8_decode($dadosXls);  
    exit;
?>