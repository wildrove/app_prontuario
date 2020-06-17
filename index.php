
<!DOCTYPE html>
<htm>
  <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Consultar prontuário</title>
   
    <!-- Bootstrap Online -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Bootstrap Local -->  
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Link Personal style.css -->
    <link rel="stylesheet"  href="bootstrap/css/style.css">

   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">

   <script src="https://unpkg/@babel/standalone/babel.min.js">
    
   </script>
   <script language=javascript type="text/javascript">
      month = new Array ("Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
      now = new Date;
   </script>
 </head>
 <body class="body-index">  

   <div class="container shadow-lg p-3 mb-5 bg-white rounded login-principal">
    <form method="post" action="./Actions/User/validateUserSession.php">
     <div class="text-center p-5">
      <img src="img/hospital-header-logo.png" class="img-fluid">
    </div>
    <div class="input-group">
      <i class="fas fa-user fa-lg p-2 border rounded-left mb-3" style="color: #0364a7"></i>
      <input type="text" class="form-control mb-3" name="userName" placeholder="nome de usuário" required="" autocomplete="off">
    </div>
    <div class="input-group">
      <i class="fas fa-lock fa-lg p-2 border rounded-left mb-3" style="color: #0364a7	"></i>
      <input type="password" class="form-control mb-3" name="userPass" placeholder="senha" required="">
    </div>

        <?php if(isset($_GET['login']) && $_GET['login'] == 'erro') { ?>

            <div class="text-danger usuario-invalido ml-3 mb-2 text-center">
                    Usuário ou senha inválido(s).
            </div>

        <?php } ?>

        <?php if(isset($_GET['login']) && $_GET['login'] == 'erro2') { ?>

            <div class="text-danger usuario-invalido ml-5 mb-2">
                    Usuário deve logar-se para ter acesso!
            </div>

        <?php } ?>

        <?php if(isset($_GET['login']) && $_GET['login'] == 'erro3') { ?>
            <div class="text-danger usuario-invalido ml-5 mb-2">
                    Usuário não tem permissão para acessar!
            </div>

        <?php } ?>

        <?php if(isset($_GET['login']) && $_GET['login'] == 'erro4') { ?>
          <div class="text-danger usuario-invalido ml-5 mb-2">
              Sessão encerrada automaticamente!
          </div>

        <?php } ?>

        
    <button type="submit" class="btn btn-primary btn-block mb-3">Entrar</button>
  </form>

</div>

<!-- Footer -->
<footer class="page-footer font-small blue">

 <!-- Copyright -->
 <div class="footer-copyright text-center py-3">© 2019 Todos direitos reservados.<br>

 <script language=javascript type="text/javascript">
    document.write(now.getDate() + " de " + month[now.getMonth()]  +  " de " + now.getFullYear());
 </script>

 <p id="real-clock"></p>

 <script type="text/javascript">
    var clock = document.getElementById('real-clock');
    setInterval(function () {
      clock.innerHTML = ((new Date).toLocaleString().substr(11, 8));  
    }, 1000);
 </script>
 </div>
 <!-- Copyright -->

</footer>
<!-- Footer -->  	

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>