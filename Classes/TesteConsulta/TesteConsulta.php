<?php
namespace Classes\TesteConsulta;
	use Classes\FirebirdConnection\FirebirdConnection;
	use PDO;

	class TesteConsulta{

		public function testeConsulta()
		{
			$connection = new FirebirdConnection();

			$sql = "SELECT * FROM PEP_EVOLUCAO_MEDICA WHERE ID = 29";

			$data = $connection->conn->query($sql);

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		}
	}