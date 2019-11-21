<?php
namespace Classes\Users;

	use Classes\FirebirdConnection\FirebirdConnection;
	use PDO;

	class Users{
		
		private $connection = null;
		public $ibaseconn = null;
		private $name = null;
		private $user = null;
		private $pass = null;
		private $userType = null;

		public function __construct()
		{
			$this->connection = new FirebirdConnection();
		}

		public function __get($atribute)
		{
			return $this->$atribute;
		}

		public function __set($atribute, $value)
		{
			$this->$atribute = $value;
		}

		public function getLastId()
		{
			$sql = "SELECT FIRST 1 CODIGO_USUARIO FROM USUARIO ORDER BY CODIGO_USUARIO DESC";
			$data = $this->connection->conn->prepare($sql);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);
			$lastInsertId = null;

			foreach ($result as $value) {
				$lastInsertId = implode(",", $value);
				return $lastInsertId = intval($lastInsertId);
			}
		}

		public function insertNewUser($name, $user, $userCpf, $pass, $userType)
		{
			try {

				$id = $this->getLastId() + 1;
				$sql = " INSERT INTO USUARIO (CODIGO_USUARIO, NOME_COMPLETO, NOME, CPF, SENHA, TIPO_USUARIO) VALUES (?, ?, ?, ?, ?, ?) ";
				$data = $this->connection->conn->prepare($sql);
				$data->bindParam(1, $id, PDO::PARAM_INT);
				$data->bindParam(2, $name, PDO::PARAM_STR);
				$data->bindParam(3, $user, PDO::PARAM_STR);
				$data->bindParam(4, $userCpf, PDO::PARAM_STR);
				$data->bindParam(5, $pass, PDO::PARAM_STR);
				$data->bindParam(6, $userType, PDO::PARAM_STR);
				$result = $data->execute();
				$lastInsertId = $this->getLastId();

				return $lastInsertId;

			} catch (Exception $e) {
				echo  $e->getMessage();
			}
		}

		public function findUser($name, $user, $cpf, $pass, $userType)
		{
			$sql = "SELECT NOME_COMPLETO, NOME, CPF, SENHA, TIPO_USUARIO FROM USUARIO
						WHERE (NOME_COMPLETO = ?
						AND NOME = ?
						AND CPF = ?
						AND SENHA = ?
						AND TIPO_USUARIO = ? )
					";
			$data = $this->connection->conn->prepare($sql);
			$data->bindParam(1, $name, PDO::PARAM_STR);
			$data->bindParam(2, $user, PDO::PARAM_STR);
			$data->bindParam(3, $cpf, PDO::PARAM_STR);
			$data->bindParam(4, $pass, PDO::PARAM_STR);
			$data->bindParam(5, $userType, PDO::PARAM_STR);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			return $result;
					
		}

		public function findUserLogin($userName)
		{
			$sql = "SELECT NOME, SENHA, TIPO_USUARIO FROM USUARIO 
						WHERE NOME = ?
					";
			$data = $this->connection->conn->prepare($sql);
			$data->bindParam(1, $userName, PDO::PARAM_STR);
			//$data->bindParam(2, $pass, PDO::PARAM_STR);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);
			
			return $result;		
		}

		public function deleteUser()
		{
			$sql = "DELETE FROM USUARIO WHERE CODIGO_USUARIO > 733";
			$data = $this->connection->conn->prepare($sql);
			$data->execute();

			return '<h1>Dados removidos com sucesso</h1>';
		}

		public function test()
		{
			$sql = "SELECT FIRST 16 NOME_COMPLETO, NOME, CODIGO_USUARIO, TIPO_USUARIO, SENHA FROM USUARIO ORDER BY CODIGO_USUARIO DESC";
			$data = $this->connection->conn->prepare($sql);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}

	}