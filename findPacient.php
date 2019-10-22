<?php
//inclui o arquivo config(arquivo de conexão com o banco de dados)
session_start();
require_once './forms/headerUserPacientList.php';
require './vendor/autoload.php';

use Classes\Pacient\Pacient;
$nome = strtoupper($_POST['paciente']);
$dataNasc = $_POST['dtNasc'];
//Limita o número de registros a serem mostrados por página
$limite = 10;
//Se pg não existe atribui 1 a variável pg
$pg = (isset($_GET['pg'])) ? (int)$_GET['pg'] : 1 ;
//Atribui a variável inicio o inicio de onde os registros vão ser mostrados por página, exemplo 0 à 10, 11 à 20 e assim por diante
$inicio = ($pg * $limite) - $limite;
 
//seleciona os registros do banco de dados pelo inicio e limitando pelo limite da variável limite
$sql = "SELECT FIRST $inicio SKIP $limite REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE,TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$nome."%' ORDER BY NOME ASC";
 
try{
  $query = $conecta->prepare($sql);  
  $query->execute();
   
  }catch(PDOexception $error_sql){
  echo 'Erro ao retornar os Dados.'.$error_sql->getMessage();
}
 
while($linha = $query->fetch(PDO::FETCH_ASSOC)){
      
     echo '<ul style="font:14px Verdana, Geneva, sans-serif; color:#333; list-style:none;">';
     echo '<li>'.$imovelID     = $linha["imovelID"].'</li>';
     echo '<li>'.$imovelTitulo = $linha["imovelTitulo"].'</li>';
     echo '</ul>';
 
}
//seleciona o total de registros  
  $sql_Total = 'SELECT imovelID FROM sr_imoveis';
   
 try{
  $query_Total = $conecta->prepare($sql_Total);  
  $query_Total->execute();
   
  $query_result = $query_Total->fetchAll(PDO::FETCH_ASSOC);
   
  //conta quantos registros tem no banco de dados
  $query_count =  $query_Total->rowCount(PDO::FETCH_ASSOC);
  
 //calcula o total de paginas a serem exibidas
  $qtdPag = ceil($query_count/$limite);
   
  }catch(PDOexception $error_Total){
  echo 'Erro ao retornar os Dados. '.$error_Total->getMessage();
}
 
//Cria os links para navegação das paginas
echo '  <a href="paginacao.php?pg=1">PRIMEIRA PÁGINA</a>   ';
       if($qtdPag > 1 && $pg<= $qtdPag){
         for($i=1; $i <= $qtdPag; $i++){
              
             if($i == $pg){
                  
                 echo $i;
             }else{
           
         echo "<a href='paginacao.php?pg=$i'>".$i."</a>";
           }
        }
 
       }
       echo "    <a href=\"paginacao.php?pg=$qtdPag\">ÚLTIMA PÁGINA</a>  ";
?>
