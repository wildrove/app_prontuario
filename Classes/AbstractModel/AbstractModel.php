<?php
namespace Classes\AbstractModel;

	use FirebirdConnection\FirebirdConnection;
	use PDO;

	abstract class AbstractModel{
		private $connection = null;

		public function convertCaractereToLetter($arrayText, $columnName)
		{
			foreach ($arrayText as $key => $value) {
<<<<<<< HEAD
				$arrayText[$key][$columnName] = str_replace("212;", "ô", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("193;", "á", $arrayText[$key][$columnName]);
=======
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
				$arrayText[$key][$columnName] = str_replace("193;", "Á", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("e1; ", "Á", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("225;", "Á", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("195;", "Ã", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("e3; ", "Ã", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("227;", "Ã", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("226;", "Â", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("201;", "É", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("e9; ", "É", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("233;", "É", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("202;", "Ê", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("234;", "Ê", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("205;", "Í", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("237;", "Í", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("ed; ", "Í", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("213;", "Õ", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("244;", "Ô", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("245;", "Õ", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("f5; ", "Õ", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("212;", "Ô", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("211;", "Ó", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("243;", "Ó", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("f3; ", "Ó", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("250;", "Ú", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("199;", "Ç", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("e7;", "Ç", $arrayText[$key][$columnName]);
				$arrayText[$key][$columnName] = str_replace("231;", "Ç", $arrayText[$key][$columnName]);

>>>>>>> MelhorarRTFtoHTML
			}

			return $arrayText;
		}
	}

	//$arrayText[$key][$columnName] = str_replace("", "", $arrayText[$key][$columnName]);