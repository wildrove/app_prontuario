
  <nav class="navbar navbar-expand-lg fixed-top navbar-header">
    <div class="navbar-brand img-fluid img-nav">
      <img src="../../img/hospital-header-logo.png" width="" height="">
    </div>
    <ul class="navbar-nav ml-auto nav-items">
      <li class="nav-item bem-vindo-nav">
        <span class="nav-link">
          <?php 
            date_default_timezone_set('America/Sao_Paulo');
            $date = date('H:i:s', strtotime("-1 Hours"));
            $currentDate = null;
            if($date >= '00:00:00' && $date <= '11:59:59'){
              echo 'Bom dia, ' . ucfirst(strtoupper($_SESSION['nome_usuario'])); 
            }elseif($date >= '12:00:00' && $date <= '18:59:59' ){
              echo 'Boa tarde, ' . ucfirst(strtoupper($_SESSION['nome_usuario'])); 
            }elseif($date >= '19:00:00' && $date <= '23:59:59'){
              echo 'Boa noite, ' . ucfirst(strtoupper($_SESSION['nome_usuario'])); 
            }   
          ?>
            
        </span>
      </li>
      <div class="divisor-nav"></div>
      <li class="nav-item logout-nav">
        <a href="../../Actions/User/logout.php" class="nav-link logout-text">Sair</a>
      </li>
    </ul>
  </nav>

      <?php
        session_start();
        // valida se o usuário está logado no sistema antes de permitir acesso aos arquivos .php
        if(!isset($_SESSION['usuario_autenticado']) || $_SESSION['usuario_autenticado'] != 'SIM') {
          header('Location: ../index.php?login=erro2');
          exit();
        }elseif(isset($_SESSION['usuario_nivel_acesso']) && $_SESSION['usuario_nivel_acesso'] != 'Administrador'){
        header('Location: ../index.php?login=erro3');
        session_destroy();
        exit();
        }

      ?>