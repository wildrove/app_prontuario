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
			}

			return $arrayText;
		}
	}

	//$arrayText[$key][$columnName] = str_replace("", "", $arrayText[$key][$columnName]);