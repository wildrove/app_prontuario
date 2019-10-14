<?php

	
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
	
	//192.168.23.101