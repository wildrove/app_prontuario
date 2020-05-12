<?php
namespace Classes\AbstractModel;

	use FirebirdConnection\FirebirdConnection;
	use PDO;

	abstract class AbstractModel{
		private $connection = null;

		public function convertCaractereToLetter($arrayText, $columnName)
		{
			foreach ($arrayText as $key => $value) {
				$arrayText[$key][$columnName] = str_replace("212;", "ô", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("193;", "á", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("Arial;", " ", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("Courier New;", "", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("Times New Roman;", "", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("Calibri;", "", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("MS Sans Serif;", "", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("Arial Narrow;", "", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("{{{", "", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("{ ", "", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace(";;", "", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("193;", "á", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("e1; ", "á", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("224;", "á", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("225;", "á", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("195;", "ã", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("e3; ", "ã", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("227;", "ã", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("226;", "â", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("201;", "é", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("e9; ", "é", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("233;", "é", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("202;", "ê", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("234;", "ê", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("205;", "í", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("237;", "í", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("ed; ", "í", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("213;", "õ", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("244;", "ô", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("245;", "õ", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("f5; ", "õ", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("212;", "ô", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("211;", "ó", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("243;", "ó", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("f3; ", "ó", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("250;", "ú", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("199;", "ç", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("e7;", "ç", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("231;", "ç", $arrayText[$key][$columnName]);

			}

			return $arrayText;
		}

		public function validateResumeType($resumeType, $page, $limit)
		{
			$selectType;
			if ($resumeType == 'evolucao') {
				$selectType = 
						"SELECT FIRST $limit SKIP $page PEP.REGISTRO_PRONTUARIO, PEP.DATA_EVOLUCAO, PEP.HORA_EVOLUCAO, PEP.REGISTRO_PACIENTE, PEP.TIPO, US.NOME_COMPLETO FROM PEP_EVOLUCAO_MEDICA PEP
						INNER JOIN PRONTUARIO P
						ON PEP.REGISTRO_PRONTUARIO = P.REGISTRO_PRONTUARIO INNER JOIN USUARIO US
						ON PEP.CODIGO_USUARIO = US.CODIGO_USUARIO
						WHERE PEP.REGISTRO_PRONTUARIO = ?

						UNION ALL

						SELECT FIRST $limit SKIP $page EW.REGISTRO_PRONTUARIO, EW.DATAEVOLUCAO, EW.HORAEVOLUCAO, EW.NROATEND,
							 EW.TIPOATEND, EW.PRESTADOR FROM EVOLUCAO_WARELINE EW
						INNER JOIN PRONTUARIO P
						ON EW.REGISTRO_PRONTUARIO = P.REGISTRO_PRONTUARIO
						WHERE EW.REGISTRO_PRONTUARIO = ?
						ORDER BY 2 DESC";

				return $selectType;
			}else {
				return $selectType = 'Olá Mundo';
			}

			
		}
	}

	