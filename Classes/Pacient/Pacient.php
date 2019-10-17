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

		public function findPacient($nome = 'wilder', $dataNasc = '1984-06-10')
		{
			$connection = new FirebirdConnection();

			$this->nomePaciente = $nome;
			$this->dataNascimento = $dataNasc;

			if($this->dataNascimento == ''){

				$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$this->nomePaciente."%'";

				$data = $connection->conn->query($sql);
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;

			} elseif ($this->nomePaciente == '') {

				$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE DATA_NASCIMENTO = '".$this->dataNascimento."'";

				$data = $connection->conn->query($sql);
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;

			}
				$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$this->nomePaciente."%' AND DATA_NASCIMENTO = '".$this->dataNascimento."'";

				$data = $connection->conn->query($sql);
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;
		}
	}