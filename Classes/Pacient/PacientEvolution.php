<?php
namespace Classes\Pacient\PacientEvolution;

	use Classes\FireBirdConnection\FireBirdConnection;
	use PDO;

	class PacientEvolution {

		private $connection = null;

		public function __construct()
		{
			$this->connection = new FireBirdConnection();
		}

		public function __get($atribute)
		{
			return $this->$atribute;
		}

		public function __set($atribute, $value)
		{
			$this->$atribute = $value;
		}

		public function findPacientEvolution($regProntuary)
		{
			$sql = "SELECT TIPO, REGISTRO_PRONTUARIO, REGISTRO_PACIENTE, DATA_EVOLUCAO, EVOLUCAO FROM PEP_EVOLUCAO_MEDICA WHERE  REGISTRO_PRONTUARIO = ? OR REGISTRO_PACIENTE = ?";

			$data = $this->connection->conn->prepare($sql);
			$data->bindParam(1, $regProntuary);
			$data->bindParam(2, $regProntuary);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);


			return $result;

		}

		public function changeColumnType($arrayColumn, String $columnName)
		{
			foreach ($arrayColumn as $key => $value) {

				if ($arrayColumn[$key][$columnName] == 'CRM') {
					$arrayColumn[$key][$columnName] = 'MÉDICO';

				}elseif ($arrayColumn[$key][$columnName] == 'CRN') {
					$arrayColumn[$key][$columnName] = 'NUTRICIONISTA';
					

				}elseif ($arrayColumn[$key][$columnName] == 'CRP ') {
					$arrayColumn[$key][$columnName] = 'PSICÓLOGO';
				

				}elseif ($arrayColumn[$key][$columnName] == 'COREN') {
					$arrayColumn[$key][$columnName] = 'ENFERMAGEM';
					

				}elseif ($arrayColumn[$key][$columnName] == 'CREFITO') {
					$arrayColumn[$key][$columnName] = 'FISIOTERAPEUTA';
					
				}
			}

			return $arrayColumn;
		}
	}