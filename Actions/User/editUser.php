<?php
	require '../../vendor/autoload.php';
	require 'validateAccessFile.php';
	use Classes\Users\Users;

	$idUser = intval($_GET['idUser']);

	$editUser = new Users();

	$user = $editUser->getUser($idUser);


?>


<!DOCTYPE html>
<html>
<head>
	<title>Prontuário médico eletrônico</title>
	 <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Online -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Bootstrap Local -->  
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!-- Link Personal style.css -->
    <link rel="stylesheet"  href="../../bootstrap/css/style.css">

     <!-- Fontawesome link -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">
        
</head>
	<body>
  		<div class="container">
  			<?php
  				session_start();
  				require '../../forms/header-admin-edit.php';
  			?>
  			<?php foreach ($user as $rowUser) { ?>

  			<form style="margin-top: 150px;" action="validateSaveUser.php" method="post">
  				<h1 class="text-center mb-3">Editar usuário</h1>
  				  <div class="form-group">
  				  	<input type="hidden" class="form-control" name="userId" value="<?php echo $rowUser['CODIGO_USUARIO']; ?>">
  				  </div>	
				  <div class="form-row font-weight-bold">
				    <div class="form-group col-md-6">
				      <label for="inputEmail4">Nome completo:</label>
				      <input type="text" class="form-control" maxlength="30" name="userName" id="inputName" value="<?php echo $rowUser['NOME_COMPLETO']; ?>" required="">
				    </div>
				    <div class="form-group col-md-6">
				      <label for="inputPassword4">Usuário:</label>
				      <input type="text" class="form-control" maxlength="10" name="user" id="inputUser" value="<?php echo $rowUser['NOME']; ?>" required="">
				    </div>
				  </div>
				  <div class="form-group font-weight-bold">
				    <label for="inputAddress">CPF:</label>
				    <input type="text" class="form-control" maxlength="11" name="userCpf" id="inputCpf" value="<?php echo $rowUser['CPF']; ?>" required="">
				  </div>
				  <div class="form-group font-weight-bold">
				    <label for="inputAddress2">Senha:</label>
				    <input type="text" class="form-control" maxlength="10" name="userPass" id="inputPass" value="<?php echo $rowUser['SENHA']; ?>" required="">
				  </div>
				  <div class="form-row">
				    <div class="form-group col-md-6 font-weight-bold">
				      <label for="inputCity">Tipo usuário:</label>
				      <select name="userType" class="form-control">
				      	<option value="Usuário comum" selected="">Usuário comum</option>
				      	<option value="Administrador">Administrador</option>
				      	<option value="Médico">Médico</option>
				      </select>
				    </div>
				  </div>
				  <button type="submit" class="btn btn-primary">Salvar</button>
				  <a class="btn btn-primary ml-3" href="javascript:history.back()">Voltar</a>
			</form>
  		</div>
  	<?php }
  	 ?>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>
