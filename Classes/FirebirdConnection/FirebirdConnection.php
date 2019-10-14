<?php
namespace Classes\FirebirdConnection;
use PDO;

	class FirebirdConnection {
		public $conn = null;

		public function __construct()
		{
			$this->createConnection('firebird', 'localhost:/BancoFirebird/SGH.FDB', 'SYSDBA', 'masterkey');
		}

		private function createConnection($driverName, $hostName, $user, $pass)
		{
			try{

				$this->conn = new \PDO("$driverName:dbname=$hostName", $user, $pass);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				echo '<h1>Conectado com sucesso!</h1>';

			}catch(PDOException $e){
				echo 'Não foi possível conectar!' . $e->getMessage();
			}
		}

	/*
		$hostName = "localhost:/BancoFirebird/SGH.FDB";
		$user = "SYSDBA";
		$pass = "masterkey";

		$conn = ibase_connect( $hostName, $user, $pass );

		try{
			if($conn){
				echo "<h1>Conectado com sucesso!</h1>";
			}
		}catch(Execption $e){
			echo "Não foi possível conectar" . $e->getMessage();
		}
	*/
		
	}


	


