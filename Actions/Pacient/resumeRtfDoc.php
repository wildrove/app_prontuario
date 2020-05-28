<?php
	
	//Esta função como se pode ver, recebe como argumento o nome do arquivo RTF, o abre e armazena o conteúdo na variável de texto $todo. Esta função portanto, devolve o conteúdo de um arquivo.

	function leef($ficheiro) 
	{
		$texto = file($ficheiro);
		$tamleef = sizeof($texto);

		for($n=0; $n<$tamleef; $n++){
			$todo = $todo . $texto[$n];
		}

		return $todo;
	}

	function rtf($sql, $planilha, $fsaida, $matequivalencias)
	{
		$pre = time();
		$fsaida = "evolução" . $pre . $fsaida;

		//Passo 1º ler a planilha rtf
		$txtplanilha = leef($planilha);

		//Passo 2º 
		$matriz = explode("sectd", $txtplanilha);
		$cabecalho = $matriz[0] . "sectd";
		$inicio = strlen($cabecalho);
		$final = strrpos($txtplanilha,"}");
		$largo = $final - $inicio;
		$corpo = substr($txtplanilha, $inicio, $largo);

		// Passo 3º escrever o ficheiro
		$punt = fopen($fsaida, "w");
		fputs($punt, $cabecalho);
		$result = mysql("base_dados", $sql);
		while ($row = mysql_fetch_object($result)) {
			$depois = $corpo;
			foreach ($matequivalencias as $dado) {
				$dadosql = $row->$dado[1];
				$dadosql = stripslashes($dadosql);
				$dadortf = $dado[0];
				$depois = str_replace($dadortf, $dadosql, $depois);
			}
			fputs($punt, $depois);
			$saltopag = "\par \page \par";
			fputs($punt, $saltopag);
		}
		fputs($punt, "}");
		fclose($punt);

		return $fsaida;
	}