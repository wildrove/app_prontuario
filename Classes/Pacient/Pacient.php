<?php
namespace Classes\Pacient;
	use Classes\FirebirdConnection\FirebirdConnection;
	use PDO;

	class Pacient{

		private $pacientName = null;
		private $pacientBirthday = null;

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

		public function findPacient($name, $birthDay, $page, $limit)
		{

			$connection = new FirebirdConnection();

			$this->pacientName = $name;
			$this->pacientBirthday = $birthDay;

			if(($this->pacientBirthday == '') && !empty($this->pacientName)){
				//$teste = $page * $limite;
				$likeString = '%' . $this->pacientName . '%';
				$sql = "SELECT FIRST $limit SKIP $page REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE ? ORDER BY NOME ASC";

				$data = $connection->conn->prepare($sql);
				$data->bindParam(1, $likeString, PDO::PARAM_STR);
				$data->execute();
				$result = $data->fetchAll(PDO::FETCH_ASSOC);
				
				return $result;		

			}

			if(($this->pacientName == '') && !empty($this->pacientBirthday)) {

				$likeString = $this->pacientBirthday;
				$sql = "SELECT FIRST $limit SKIP $page
				REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE DATA_NASCIMENTO = ? ORDER BY NOME ASC";

				$data = $connection->conn->prepare($sql);
				$data->bindParam(1, $likeString, PDO::PARAM_STR);
				$data->execute();
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;

			}

			if (!empty($this->pacientName) && !empty($this->pacientBirthday)) {

				$likeStringName = '%' . $this->pacientName . '%';
				$likeStringDate = "$this->pacientBirthday";

				$sql = "SELECT FIRST $limit SKIP $page
				REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE ? AND DATA_NASCIMENTO = ? ORDER BY NOME ASC";

				$data = $connection->conn->prepare($sql);
				$data->bindParam(1, $likeStringName, PDO::PARAM_STR);
				$data->bindParam(2, $likeStringDate, PDO::PARAM_STR);

				$data->execute();
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;
				exit;
			}
		}



		public function getTotalPacient($name, $birthDay)
		{
			try {
					$connection = new FirebirdConnection();

					if ($birthDay == '') {
					
						$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$name."%' ";

						$data = $connection->conn->prepare($sql);
						$data->execute();
				
						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						return $result = count($result);
						exit;
					}

					if ($name == '') {
					
						$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE,TELEFONE FROM PRONTUARIO WHERE DATA_NASCIMENTO = '".$birthDay."' ";

						$data = $connection->conn->prepare($sql);
						$data->execute();
				
						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						return $result = count($result);
						exit;
					}

					if ($birthDay == '' && $name == '') {
					
						echo "<div class='container text-center m-auto'>Nenhum dado encontrado!</div>";
						exit;
					}

					$sql = "SELECT REGISTRO_PRONTUARIO,NOME,DATA_NASCIMENTO,DOCUMENTO,NOME_MAE, TELEFONE FROM PRONTUARIO WHERE NOME LIKE '".$name."%' AND DATA_NASCIMENTO = '".$birthDay."' ";

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