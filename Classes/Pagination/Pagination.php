<?php
namespace Classes\Pagination;
use Classes\FirebirdConnection\FirebirdConnection;
use PDO;
//=====================\
//[ INICIO DA CLASSE ] |
//=====================/
class Pagination {
	var $maximo; 							  //variavel de número de itens por página;
	var $pagina;							  //controle do número da página;
	var $mat;								  //variavel para calculo de páginas;
	var $inicio;							  //controle de exibição de itens inicio;
	var $paginas;							  //variavel para calculo de páginas;
	var $linhas;							  //número total de itens;
	var $anterior;							  //controle de página anterior;
	var $proximo;							  //controle de proxima página;
	var $result;							  //result do sql;
	var $nPaginas 			= 0;			  //número total de páginas;
	var $btn_primeiro 		= "<< Primeiro";	//texto do botão com o link para a primeiro página;
	var $btn_anterior 		= "< Anterior";	 //texto do botão com o link para página anterior;
	var $btn_proximo		= "Próximo >";	 //texto do botão com o link para próxima página;
	var $btn_ultimo			= "Último >>";	//texto do botão com o link para a última página;
	var $sp					= "/;\\";		  //separa botões de nº pg. OBS: use ;(ponto e virgula para separar os lados);
	var $btn_primeiro_on	= true;			  //ativa e desativa o botão primeiro (true|false);
	var $btn_ultimo_on		= true;			  //ativa e desativa o botão último (true|false);
	var $estilo				= 2;			  //define estilo de paginação;

	/* CONSTRUTOR */
	function Paginacao(){ }

	/* SETA O NUMERO DE ITENS POR PÁGINA */
	function setMaximo($var){
		$this->maximo = $var;
	}

	/* SETA SEPARADORES DE BOTÕES DE NÚMERO DE PÁGINAS */
	function setSP($var){
		$this->sp = $var;
	}

	/* SETA O TEXTO DO BOTÃO PRIMEIRO */
	function setBtnPrimeiro($var){
		$this->btn_primeiro = $var;
	}

	/* SETA O TEXTO DO BOTÃO ANTERIOR */
	function setBtnAnterior($var){
		$this->btn_anterior = $var;
	}

	/* SETA O TEXTO DO BOTÃO PROXIMO */
	function setBtnProximo($var){
		$this->btn_proximo = $var;
	}

	/* SETA O TEXTO DO BOTÃO ÚLTIMO */
	function setBtnUltimo($var){
		$this->btn_ultimo = $var;
	}

	/* DEFINE SE O BOTÃO PRIMEIRO VAI SER EXIBIDO */
	function setBtnPrimeiroOn($var){
		$this->btn_primeiro_on = $var;
	}

	/* DEFINE SE O BOTÃO ÚLTIMO VAI SER EXIBIDO */
	function setBtnUltimoOn($var){
		$this->btn_ultimo_on = $var;
	}

	/* DEFINE O ESTILO DE PAGINAÇÃO */
	function setEstilo($var){
		$this->estilo = $var;
	}

	/* INICIALIZAÇÃO DO OBJETO */
	function __start($db, $sql){
		if($this->maximo == ""){ //se não for setado número de itens por página pega o padrão;
			$this->maximo = 10;
		}
		if($_REQUEST["pagina"] == "") {
			$this->pagina = "1"; //se página igual a branco seta página = 1;
		}else{
			$this->pagina = $_REQUEST["pagina"]; //pega o número da página passada por parâmetro ex:?pagina=2;
		}
		$this->mat = $this->pagina - 1; //inicia com a linha zero do banco;
		$this->inicio = $this->mat * $this->maximo; //calcula o valor de inicio da lista de acordo com a página;

		$limita = $sql." LIMIT ".$this->inicio.",".$this->maximo; //gera o sql para pesquisa no banco com a limitação;
		$this->result = $db->Execute($limita); //executa sql com a limitação;

		$result = $db->Execute($sql); //executa sql sem a limitação;
		$this->linhas = $result->RecordCount(); //pega valor total de itens do banco;

		$this->paginas = ceil($this->linhas / $this->maximo) - 1; //pega número total de páginas pela quantidade máxima de itens;
		$this->nPaginas = $this->paginas; //guarda valor na variavel;

		$this->anterior = $this->pagina - 1; //informa o a página anterior;
		$this->proximo = $this->pagina + 1; //informa a próxima página;
	}

	/* RETORNA O RESULTADO DO SQL COM O LIMITE DE ITENS POR LINHA */
	function getResult(){
		return $this->result;
	}

	/* RETORNA O BOTÃO PRIMEIRO E O ANTERIOR */
	function getAnterior($on, $off){
		if($this->btn_primeiro_on == true && $this->estilo == 2){ //se botão primeiro ativado;
			if($this->pagina == 1){ //se é primeira página;
				echo "<span class=\"".$off."\">".$this->btn_primeiro."</span> "; //botão off
			}else{
				echo "<span class=\"".$on."\"><a href=\"?pagina=1\">".$this->btn_primeiro."</a></span> "; //botão on
			}
		}
		if($this->anterior > 0){ //se anterior maior que 0;
			echo "<span class=\"".$on."\"><a href=\"?pagina=".$this->anterior."\">".$this->btn_anterior."</a></span> "; //botão on
		}else{
			echo "<span class=\"".$off."\">".$this->btn_anterior."</span> "; //botão off
		}
	}

	/* RETORNA O NÚMERO DE PÁGINAS PARA NAVEGAÇÃO */
	function getPaginas($on){
		$sp = explode(";", $this->sp); //pega variaves de separação de botões de nº de pg;

		//===============================================================\
		//[ EXIBE PAGINAÇÂO NO ESTILO                                  ] |
		//[ < Anterior 1 2 3 4 [5] 6 7 8 Próximo >                     ] |
		//[ < Anterior 1 2 3 4 5 [6] 7 8 Próximo >                     ] |
		//[ o número de páginas total é mostrado . . .                 ] |
		//===============================================================|
		if($this->estilo == 1){
			echo" <b>".$sp[0]."</b> ";
			for($i=0; $i <= $this->nPaginas; $i++){
				$pag =  $i +1;
				echo " <span class=\"".$on."\"><a href=\"?pagina=".$pag."\">";
				if($pag == $this->pagina){
					echo "[<b>".$pag."</b>]";
				}else{
					echo $pag;
				}
				echo "</a></span> ";
			}
			echo" <b>".$sp[1]."</b> ";
		}
		//===============================================================|
		//[ FIM PG 01 ]                                                  |
		//===============================================================/

		//===============================================================\
		//[ EXIBE PAGINAÇÂO NO ESTILO                                  ] |
		//[ << Primeiro < Anterior 1 2 3 [4] 5 6 7 Próximo > Último >> ] |
		//[ << Primeiro < Anterior 2 3 4 [5] 6 7 8 Próximo > Último >> ] |
		//===============================================================|
		if($this->estilo == 2){
			echo" <b>".$sp[0]."</b> "; //separador
			if($this->pagina < 5){
				$i = 0;
				if($this->nPaginas > 5){
					$j = 6;
				}else{
					$j = $this->nPaginas;
				}
			}else{
				if($this->pagina == 5 && $this->nPaginas <= 5){
					$i = 0;
					$j = $this->pagina - 1;
				}else{
					if($this->pagina <= ($this->nPaginas + 1)){
						$i = ($this->pagina - 4);
						$j = $this->pagina + 2;
						if($j > $this->nPaginas){
							if($this->pagina == ($this->nPaginas+1)){
								$j = $this->pagina - 1;
								$teste = ($this->nPaginas + 3) - $j;
								$i = $i - $teste;
							}else{
								if($this->pagina == 6){
									$j = $this->pagina + 1;
								}else{
									$i = ($this->pagina - 5);
									if($j > $this->nPaginas){
										$j = $this->nPaginas;
										if(($this->pagina+1) == ($this->nPaginas+1)){
											$teste = ($this->nPaginas + 1) - $j;
											$i = $i - $teste;
										}
									}
								}
							}
						}
					}else{
						$i = 0;
						$j = $this->nPaginas;
					}
				}
			}
			for($i; $i <= $j; $i++){
				$pag =  $i +1;
				echo " <span class=\"".$on."\"><a href=\"?pagina=".$pag."\">";
				if($pag == $this->pagina){
					echo "[<b>".$pag."</b>]";
				}else{
					echo $pag;
				}
				echo "</a></span> ";
			}
			echo" <b>".$sp[1]."</b> "; //separador;
		}
		//===============================================================|
		//[ FIM PG 02 ]                                                  |
		//===============================================================/
	}

	/* RETORNA O BOTÃO PROXIMO E O ÚLTIMO */
	function getProximo($on, $off){
		if($this->pagina <= $this->paginas){ //se página menor ou igual a numero total de páginas;
			echo "<span class=\"".$on."\"><a href=\"?pagina=".$this->proximo."\">".$this->btn_proximo."</a></span> "; //botão on
		}else{
			echo "<span class=\"".$off."\">".$this->btn_proximo."</span> "; //botão off
		}
		if($this->btn_ultimo_on == true  && $this->estilo == 2){ //se botão último ativado
			if($this->pagina > $this->nPaginas){ //se página maior que número total de páginas;
				echo "<span class=\"".$off."\">".$this->btn_ultimo."</span> "; //botão off;
			}else{
				echo "<span class=\"".$on."\"><a href=\"?pagina=".($this->nPaginas+1)."\">".$this->btn_ultimo."</a></span> "; //botão on
			}
		}
	}
}
//==================\
//[ FIM DA CLASSE ] |
//==================//