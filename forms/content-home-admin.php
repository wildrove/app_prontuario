
<!DOCTYPE html>
<html>
<head>
	<title>Prontuário médico eletrônico</title>
	 <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap Online -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Bootstrap Local -->  
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Link Personal style.css -->
    <link rel="stylesheet"  href="../bootstrap/css/style.css">

     <!-- Fontawesome link -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">
        
</head>
	<body>
    <div>
      <?php 
      session_start();
        require 'header-admin.php';
      ?>
      <?php
        // valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
        if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
          header('Location: ../index.php?login=erro2');
        }

      ?>
    </div>
  <div class="container">
    <section class="main-section" style="margin-bottom: -70px">
      <div class="card shadow-lg">
          <h5 class="card-header card-titulo bg-dark text-light">Prontuário Médico Eletrônico</h5>
          <div class="card-body">
              <legend  class="card-title">Filtros para Localizar Paciente:</legend>
                <form method="get" action="../Actions/Pacient/findPacient.php">
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="paciente">Paciente:</label>
                        <input type="text" class="form-control" name="paciente" placeholder="Nome Paciente" autocomplete="off">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="nascimento">Data Nascimento:</label>
                        <input type="date" min="1900-01-01" max="2200-01-01" class="form-control" name="dtNasc" placeholder="data nascimento" autocomplete="off">
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group mt-2">
                        <label for="pesquisar"></label>
                        <input type="submit" class="form-control btn btn-primary" value="Pesquisar">
                      </div>
                    </div>
                  </div>
                </form>
            </div>
      </div>
    </section>
    <section class="main-section mb-5">
      <div class="card shadow-lg">
          <h5 class="card-header card-titulo bg-dark text-light">Cadastrar Novo usuário</h5>
          <div class="card-body">
                <form method="post" action="../Actions/User/validateUser.php">
                  <div class="row"><!-- inicio linha 1 -->
                    <div class="col">
                      <div class="form-group">
                        <label for="name">Nome completo:</label>
                        <input type="text" maxlength="30" class="form-control" name="fullName" placeholder="nome completo" autocomplete="off" required="">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="usuer">Nome de usuário:</label>
                        <input type="text" maxlength="10" class="form-control" name="userName" placeholder="nome de usuário" autocomplete="off" required="">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="usuer">CPF:</label>
                        <input type="text" maxlength="11" class="form-control" name="userCPF" placeholder="cpf" autocomplete="off" required="">
                      </div>
                    </div>
                  </div><!-- fim linha 1 -->
                  <div class="row"><!-- Inicio linha 2 -->
                    <div class="col">
                      <div class="form-group">
                        <label for="pass">Senha:</label>
                        <input type="password" maxlength="10" class="form-control" name="userPass" placeholder="senha" autocomplete="off" required="">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="nascimento">Tipo usuário:</label><br>
                        <select class="form-group p-2" name="userType">
                          <option class="form-control" value="Administrador" selected="">Administrador</option>
                          <option class="form-control" value="Médico">Médico</option>
                          <option class="form-control" value="Usuário Comum">Usuário Comum</option>
                        </select>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group mt-2">
                        <label for="pesquisar"></label>
                        <input type="submit" class="form-control btn btn-primary" value="Cadastrar">
                      </div>
                    </div>
                  </div><!-- fim linha 2 -->     
                </form>
            </div>
      </div>
    </section> 
  </div>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>