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
			$sql = "SELECT TIPO, REGISTRO_PRONTUARIO, REGISTRO_PACIENTE, DATA_EVOLUCAO, EVOLUCAO FROM PEP_EVOLUCAO_MEDICA WHERE  REGISTRO_PRONTUARIO = ?";

			$data = $this->connection->conn->prepare($sql);
			$data->bindParam(1, $regProntuary);
			//$data->bindParam(2, $regProntuary);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);


			return $result;

		}




	}