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

		public function findPacient($nome, $dataNasc, $page, $limite)
		{

			$connection = new FirebirdConnection();

			$this->nomePaciente = $nome;
			$this->dataNascimento = $dataNasc;

			//if($this->dataNascimento == ''){
				$teste = $page * $limite;
				$sql = "SELECT FIRST $limite SKIP $teste REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$this->nomePaciente."%' ORDER BY NOME ASC";

				$data = $connection->conn->query($sql);
				$result = $data->fetchAll(PDO::FETCH_ASSOC);
				
				return $result;
			

			/*} elseif ($this->nomePaciente == '') {

				$sql = "SELECT FIRST $page SKIP $limite REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE DATA_NASCIMENTO = '".$this->dataNascimento."' ORDER BY NOME ASC";

				$data = $connection->conn->query($sql);
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;
				exit;

			}
				$sql = "SELECT FIRST $page SKIP $limite REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$this->nomePaciente."%' AND DATA_NASCIMENTO = '".$this->dataNascimento."' ORDER BY NOME ASC";

				$data = $connection->conn->query($sql);
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;
				exit;*/


		}

		public function getTotalPacient($nome, $dtNasc)
		{
			try {
					$connection = new FirebirdConnection();

					if ($dtNasc == '') {
					
						$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$nome."%' ";

						$data = $connection->conn->prepare($sql);
						$data->execute();
				
						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						return $result = count($result);
						exit;
					}

					if ($nome == '') {
					
						$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE,TELEFONE FROM PRONTUARIO WHERE DATA_NASCIMENTO = '".$dtNasc."' ";

						$data = $connection->conn->prepare($sql);
						$data->execute();
				
						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						return $result = count($result);
						exit;
					}

					if ($dtNasc == '') {
					
						$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$nome."%' ";

						$data = $connection->conn->prepare($sql);
						$data->execute();
				
						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						return $result = count($result);
						exit;
					}

					if ($dtNasc == '' && $nome == '') {
					
						echo "<div class='container text-center m-auto'>Nenhum dado encontrado!</div>";
						exit;
					}

					$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$nome."%' AND DATA_NASCIMENTO = '".$dtNasc."' ";

					$data = $connection->conn->prepare($sql);
						$data->execute();
				
					$result = $data->fetchAll(PDO::FETCH_ASSOC);

					return $result = count($result);
					exit;

			}catch(PDOException $e){

				echo $e . getMessage();
			}		
		}
	}	