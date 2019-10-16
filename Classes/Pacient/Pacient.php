<?php
namespace Classes\Pacient;
	use Classes\FirebirdConnection\FirebirdConnection;
	use PDO;

	class Pacient{

		private $nomePaciente = null;
		private $dataNascimento = null;

		public function __construct()
		{

		}

		public function __get($atribute)
		{
			return $this->$atribute;
		}

		public function __set($atribute, $value)
		{
			$this->$atribute = $value;
		}

		public function findPacient($nome)
		{
			$connection = new FirebirdConnection();

			$this->nomePaciente = $nome;
			//$this->dataNascimento = $dataNasc;

			$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,TELEFONE FROM PRONTUARIO WHERE NOME LIKE '%".$this->nomePaciente."%' ";

			$data = $connection->conn->query($sql);

			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		}
	}