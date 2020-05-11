<?php
namespace Classes\Pacient\PacientEvolution;

	use Classes\FireBirdConnection\FireBirdConnection;
	use Classes\AbstractModel\AbstractModel;
	use PDO;

	class PacientEvolution extends AbstractModel {

		private $connection = null;
		private $regProntuary = null;

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
			$this->regProntuary = $regProntuary;
			$sql = "SELECT TIPO, REGISTRO_PRONTUARIO, REGISTRO_PACIENTE, DATA_EVOLUCAO, EVOLUCAO FROM PEP_EVOLUCAO_MEDICA WHERE  REGISTRO_PRONTUARIO = ?";

			$data = $this->connection->conn->prepare($sql);
			$data->bindParam(1, $this->regProntuary, PDO::PARAM_INT);
			//$data->bindParam(2, $regProntuary);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			return $result;

		}


		public function findEvolutionDate($regProntuary, $selectEvoType, $page, $limit)
		{
			try{

				if ($selectEvoType == 'TODOS') {
						$this->regProntuary = $regProntuary;

					$sql = "
							SELECT FIRST $limit SKIP $page PEP.REGISTRO_PRONTUARIO, PEP.DATA_EVOLUCAO, PEP.HORA_EVOLUCAO, PEP.REGISTRO_PACIENTE, PEP.TIPO, US.NOME_COMPLETO FROM PEP_EVOLUCAO_MEDICA PEP
							INNER JOIN PRONTUARIO P
							ON PEP.REGISTRO_PRONTUARIO = P.REGISTRO_PRONTUARIO INNER JOIN USUARIO US
							ON PEP.CODIGO_USUARIO = US.CODIGO_USUARIO
							WHERE PEP.REGISTRO_PRONTUARIO = ?

							UNION ALL

							SELECT FIRST $limit SKIP $page EW.REGISTRO_PRONTUARIO, EW.DATAEVOLUCAO, EW.HORAEVOLUCAO, EW.NROATEND,
							 EW.TIPOATEND, EW.PRESTADOR FROM EVOLUCAO_WARELINE EW
							 INNER JOIN PRONTUARIO P
							 ON EW.REGISTRO_PRONTUARIO = P.REGISTRO_PRONTUARIO
							 WHERE EW.REGISTRO_PRONTUARIO = ?
							 ORDER BY 2 DESC;

							";

					$data = $this->connection->conn->prepare($sql);
					$data->bindParam(1, $this->regProntuary, PDO::PARAM_INT);
					$data->bindParam(2, $this->regProntuary, PDO::PARAM_INT);
					
					$data->execute();
					$result = $data->fetchAll(PDO::FETCH_ASSOC);

					return $result;
					}
					$this->regProntuary = $regProntuary;

					$sql = "
							SELECT FIRST $limit SKIP $page PEP.REGISTRO_PRONTUARIO, PEP.DATA_EVOLUCAO, PEP.HORA_EVOLUCAO, PEP.REGISTRO_PACIENTE, PEP.TIPO, US.NOME_COMPLETO FROM PEP_EVOLUCAO_MEDICA PEP
							INNER JOIN PRONTUARIO P
							ON PEP.REGISTRO_PRONTUARIO = P.REGISTRO_PRONTUARIO INNER JOIN USUARIO US
							ON PEP.CODIGO_USUARIO = US.CODIGO_USUARIO
							WHERE PEP.REGISTRO_PRONTUARIO = ?
							AND PEP.TIPO = ?

							UNION ALL

							SELECT FIRST $limit SKIP $page EW.REGISTRO_PRONTUARIO, EW.DATAEVOLUCAO, EW.HORAEVOLUCAO, EW.NROATEND,
							 EW.TIPOATEND, EW.PRESTADOR FROM EVOLUCAO_WARELINE EW
							 INNER JOIN PRONTUARIO P
							 ON EW.REGISTRO_PRONTUARIO = P.REGISTRO_PRONTUARIO
							 WHERE EW.REGISTRO_PRONTUARIO = ?
							 ORDER BY 2 DESC;

							";

					$data = $this->connection->conn->prepare($sql);
					$data->bindParam(1, $this->regProntuary, PDO::PARAM_INT);
					$data->bindParam(2, $selectEvoType, PDO::PARAM_STR);
					$data->bindParam(3, $this->regProntuary, PDO::PARAM_INT);
					
					$data->execute();
					$result = $data->fetchAll(PDO::FETCH_ASSOC);

					return $result;

			}catch(Exception $e){
					throw new Exception("Erro ao realizar a consulta", $e);
				
			}
		}

		
		public function findMedicalRealise($regProntuary, $page, $limit)
		{
			try {
					
				$this->regProntuary = $regProntuary;

				$sql = "
						SELECT FIRST $limit SKIP $page RA.DATA_ALTA, RA.DATA_DIGITACAO,RA.HORA_DIGITACAO, TA.NOME, U.NOME_COMPLETO, RA.REGISTRO_PRONTUARIO, RA.REGISTRO_PACIENTE FROM PEP_RESUMO_ALTA RA
						INNER JOIN USUARIO U ON RA.CODIGO_USUARIO = U.CODIGO_USUARIO
						INNER JOIN TIPO_ALTA TA ON RA.TIPO_ALTA = TA.CODIGO_TIPO_ALTA
						WHERE RA.REGISTRO_PRONTUARIO = ? 
						ORDER BY RA.DATA_ALTA DESC";

				$data = $this->connection->conn->prepare($sql);
				$data->bindParam(1, $this->regProntuary, PDO::PARAM_INT);
				$data->execute();
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;	

			} catch (Exception $e) {
				throw new Exception("Erro ao realizar a consulta", $e);
			}
		}

		public function findCirurgicalRealise($regProntuary, $page, $limit)
		{
			try {
				$this->regProntuary = $regProntuary;

				$sql = "
						SELECT FIRST $limit SKIP $page RC.REGISTRO_PACIENTE, RC.DATA_INC, U.NOME_COMPLETO, CC.NOME, RC.CODIGO_CIRURGIA FROM CC_RESUMO_CIRURGIA RC
						INNER JOIN USUARIO U ON RC.CODIGO_USUARIO = U.CODIGO_USUARIO
						INNER JOIN CADASTRO_CIRURGIA CC ON RC.CODIGO_CIRURGIA = CC.CODIGO_CIRUR 
						INNER JOIN PEP_EVOLUCAO_MEDICA EV ON RC.REGISTRO_PACIENTE = EV.REGISTRO_PACIENTE
						WHERE EV.REGISTRO_PRONTUARIO = ?
						GROUP BY RC.REGISTRO_PACIENTE, RC.DATA_INC, CC.NOME, U.NOME_COMPLETO, RC.CODIGO_CIRURGIA
						ORDER BY RC.DATA_INC DESC ";

				$data = $this->connection->conn->prepare($sql);
				$data->bindParam(1, $this->regProntuary, PDO::PARAM_INT);
				$data->execute();
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;	

												
			} catch (Exception $e) {
				throw new Exception("Erro ao realizar a consulta", $e);
			}
		}

		public function findImageExame($regProntuary,$pacientName, $page, $limit)
		{
			$this->regProntuary = $regProntuary;

			$sql = "SELECT FIRST $limit SKIP $page RX.REG_PACIENTE,RX.DATA_REALIZ,RX.NLAUDO,R.CODIGO_EXAME,E.NOME,U.NOME_COMPLETO FROM EXAMES_RX RX
					INNER JOIN RAIRES R ON RX.NLAUDO = R.NLAUDO
					INNER JOIN CADASTRO_EXAMES E ON R.CODIGO_EXAME = E.CODIGO_EXAME
					INNER JOIN USUARIO U ON RX.CODIGO_USUARIO = U.CODIGO_USUARIO
					INNER JOIN PRONTUARIO P ON RX.NOME_PAC = P.NOME
					WHERE P.REGISTRO_PRONTUARIO = ?
					AND P.NOME = ?
					GROUP BY RX.NLAUDO,RX.REG_PACIENTE,RX.DATA_REALIZ,R.CODIGO_EXAME,E.NOME,U.NOME_COMPLETO
					ORDER BY RX.DATA_REALIZ DESC";


			$data = $this->connection->conn->prepare($sql);
			$data->bindParam(1, $this->regProntuary, PDO::PARAM_INT);
			$data->bindParam(2, $pacientName, PDO::PARAM_STR);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			return $result;	
				
		}	


		public function findTotalDate($regProntuary)
		{
			$this->regProntuary = $regProntuary;

			$sql = "SELECT PEP.REGISTRO_PRONTUARIO, PEP.DATA_EVOLUCAO, PEP.HORA_EVOLUCAO, PEP.REGISTRO_PACIENTE, PEP.TIPO, US.NOME_COMPLETO FROM PEP_EVOLUCAO_MEDICA PEP
					INNER join PRONTUARIO P
					ON PEP.REGISTRO_PRONTUARIO = P.REGISTRO_PRONTUARIO INNER JOIN USUARIO US
					ON PEP.CODIGO_USUARIO = US.CODIGO_USUARIO
					WHERE PEP.REGISTRO_PRONTUARIO = ?
					UNION ALL
					SELECT EW.REGISTRO_PRONTUARIO, EW.DATAEVOLUCAO, EW.HORAEVOLUCAO, EW.NROATEND,
						EW.TIPOATEND, EW.PRESTADOR FROM EVOLUCAO_WARELINE EW
					INNER JOIN PRONTUARIO P
					ON EW.REGISTRO_PRONTUARIO = P.REGISTRO_PRONTUARIO
					WHERE EW.REGISTRO_PRONTUARIO = ?
					ORDER BY 2 DESC ";

				$data = $this->connection->conn->prepare($sql);
				$data->bindParam(1, $this->regProntuary, PDO::PARAM_INT);
				$data->bindParam(2, $this->regProntuary, PDO::PARAM_INT);
				$data->execute();
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result = count($result);	
		}

		public function totalMedicalRealise($regProntuary)
		{
			try {
				$this->regProntuary = $regProntuary;

					$sql = "
							SELECT RA.DATA_ALTA, RA.DATA_DIGITACAO, RA.HORA_DIGITACAO, TA.NOME, U.NOME_COMPLETO, RA.REGISTRO_PRONTUARIO FROM PEP_RESUMO_ALTA RA
							INNER JOIN USUARIO U ON RA.CODIGO_USUARIO = U.CODIGO_USUARIO
							INNER JOIN TIPO_ALTA TA ON RA.TIPO_ALTA = TA.CODIGO_TIPO_ALTA
							WHERE RA.REGISTRO_PRONTUARIO = ?
							ORDER BY RA.DATA_ALTA DESC ";

					$data = $this->connection->conn->prepare($sql);
					$data->bindParam(1, $this->regProntuary, PDO::PARAM_INT);
					$data->execute();
					$result = $data->fetchAll(PDO::FETCH_ASSOC);

					return count($result);	
			} catch (Exception $e) {
				throw new Exception("Erro ao realizar a consulta", $e);
			}
		}

		public function TotalCirurgicalRealise($regProntuary)
		{
			try {
				$this->regProntuary = $regProntuary;

				$sql = "
						SELECT RC.REGISTRO_PACIENTE, RC.DATA_INC, U.NOME_COMPLETO, CC.NOME
						FROM CC_RESUMO_CIRURGIA RC
						INNER JOIN USUARIO U ON RC.CODIGO_USUARIO = U.CODIGO_USUARIO
						INNER JOIN CADASTRO_CIRURGIA CC ON RC.CODIGO_CIRURGIA = CC.CODIGO_CIRUR 
						INNER JOIN PEP_EVOLUCAO_MEDICA EV ON RC.REGISTRO_PACIENTE = EV.REGISTRO_PACIENTE
						WHERE EV.REGISTRO_PRONTUARIO = ?
						GROUP BY RC.REGISTRO_PACIENTE, RC.DATA_INC, CC.NOME, U.NOME_COMPLETO ";

				$data = $this->connection->conn->prepare($sql);
				$data->bindParam(1, $this->regProntuary, PDO::PARAM_INT);
				$data->execute();
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return count($result);
				
			} catch (Exception $e) {
				
			}
		}

		public function totalImageExame($regProntuary)
		{
			try {
				$sql = "SELECT RX.NLAUDO, RX.REG_PACIENTE FROM EXAMES_RX RX
					INNER JOIN RAIRES R ON RX.NLAUDO = R.NLAUDO
					INNER JOIN CADASTRO_EXAMES E ON R.CODIGO_EXAME = E.CODIGO_EXAME
					INNER JOIN USUARIO U ON RX.CODIGO_USUARIO = U.CODIGO_USUARIO
					INNER JOIN PRONTUARIO P ON RX.NOME_PAC = P.NOME
					WHERE P.REGISTRO_PRONTUARIO = ?
					GROUP BY RX.NLAUDO,RX.REG_PACIENTE";

				$data = $this->connection->conn->prepare($sql);
				$data->bindParam(1, $regProntuary, PDO::PARAM_INT);
				$data->execute();
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result = count($result);
					
			} catch (Exception $e) {
				throw new Exception("Erro ao realizar a consulta", $e);
			}
		}

		public function pacientEvo($regProntuary,$dateEvo,$hourEvo)
		{	

			try {

				$sql = "SELECT PEP.REGISTRO_PRONTUARIO, PEP.EVOLUCAO FROM PEP_EVOLUCAO_MEDICA PEP 
						WHERE PEP.REGISTRO_PRONTUARIO = ? 
						AND PEP.DATA_EVOLUCAO = ?
						AND PEP.HORA_EVOLUCAO = ?
						";

						$data = $this->connection->conn->prepare($sql);
						$data->bindParam(1, $regProntuary, PDO::PARAM_INT);
						$data->bindParam(2, $dateEvo, PDO::PARAM_STR);
						$data->bindParam(3, $hourEvo, PDO::PARAM_STR);
						$data->execute();
						$result = $data->fetchAll(PDO::FETCH_ASSOC);

						if(count($result) == 0){
							$sql = "SELECT EW.REGISTRO_PRONTUARIO, EW.EVOLUCAO FROM EVOLUCAO_WARELINE EW  
							WHERE EW.REGISTRO_PRONTUARIO = ? 
							AND EW.DATAEVOLUCAO = ?
							AND EW.HORAEVOLUCAO = ?
							";

							$data = $this->connection->conn->prepare($sql);
							$data->bindParam(1, $regProntuary, PDO::PARAM_INT);
							$data->bindParam(2, $dateEvo, PDO::PARAM_STR);
							$data->bindParam(3, $hourEvo, PDO::PARAM_STR);
							$data->execute();
							$result = $data->fetchAll(PDO::FETCH_ASSOC);

							return $result;
						}

						return $result;

			}catch(Exception $e){

				echo $e . getMessage();
			}
		}

		// Função para encontrar o Resumo de Alta do Paciente
		public function pacientMedicalRealiseResume($regProntuary, $medicalDate, $medicalHour)
		{
			$sql = "SELECT RA.REGISTRO_PRONTUARIO, RA.DIAGNOSTICO_ALTA FROM PEP_RESUMO_ALTA RA
					WHERE RA.REGISTRO_PRONTUARIO = ?
					AND RA.DATA_ALTA = ?
					AND RA.HORA_DIGITACAO = ?";

			$data = $this->connection->conn->prepare($sql);
			$data->bindParam(1, $regProntuary, PDO::PARAM_INT);
			$data->bindParam(2, $medicalDate, PDO::PARAM_STR);
			$data->bindParam(3, $medicalHour, PDO::PARAM_STR);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		}

		public function pacientCirurgicalRealiseResume($regPacient, $cirugicalDate)
		{
			$sql = "
					SELECT RC.TEXTO FROM CC_RESUMO_CIRURGIA RC
					WHERE RC.REGISTRO_PACIENTE = ?
					AND RC.DATA_INC = ? ";

			$data = $this->connection->conn->prepare($sql);
			$data->bindParam(1, $regPacient, PDO::PARAM_INT);
			$data->bindParam(2, $cirugicalDate, PDO::PARAM_STR);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			return $result;
		}

		public function pacientImageExameResume($regPacient, $nLaudo, $exameCode, $exameDate)
		{

			$sql = " SELECT R.RESULTADO FROM RAIRES R
					INNER JOIN EXAMES_RX RX ON R.NLAUDO = RX.NLAUDO
					WHERE RX.REG_PACIENTE = ?
					AND RX.NLAUDO = ?
					AND R.CODIGO_EXAME = ?
					AND RX.DATA_REALIZ = ? ";
					 
					 

			$data = $this->connection->conn->prepare($sql);
			$data->bindParam(1, $regPacient, PDO::PARAM_INT);
			$data->bindParam(2, $nLaudo, PDO::PARAM_INT);
			$data->bindParam(3, $exameCode, PDO::PARAM_STR);
			$data->bindParam(4, $exameDate, PDO::PARAM_STR);
			$data->execute();
			$result = $data->fetchAll(PDO::FETCH_ASSOC);

			return $result;					
			
		}


		public function convertEvoLetter($arrayEvo, $columnName)
		{
			return $this->convertCaractereToLetter($arrayEvo, $columnName);
		}
		

		public function changeColumnValue($arrayColumn, String $columnName)
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
					
				}elseif ($arrayColumn[$key][$columnName] == 'A') {
					$arrayColumn[$key][$columnName] = 'AMBULATÓRIO';

				}elseif ($arrayColumn[$key][$columnName] == 'E') {
					$arrayColumn[$key][$columnName] = 'EXTERNO';

				}elseif ($arrayColumn[$key][$columnName] == 'I') {
					$arrayColumn[$key][$columnName] = 'INTERNO';
				}
			}

			return $arrayColumn;
		}

		public function findPacientHeader($regProntuary)
		{
			try {

				$sql = "SELECT NOME, NOME_MAE, DATA_NASCIMENTO, REGISTRO_PRONTUARIO FROM PRONTUARIO P
						WHERE P.REGISTRO_PRONTUARIO = ?";
						
				$data = $this->connection->conn->prepare($sql);
				$data->bindParam(1, $regProntuary, PDO::PARAM_INT);
				$data->execute();
				$result = $data->fetchAll(PDO::FETCH_ASSOC);

				return $result;

			} catch (Exception $e) {
				echo $e . getMessage();
			}
		}
	}