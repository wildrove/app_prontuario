<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../bootstrap/css/style.css">

     <!-- Bootstrap link -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

     <!-- Fontawesome link -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">
        
      </script>
</head>
<body>
	<nav class="navbar navbar-expand-lg fixed-top navbar-header">
		<div class="navbar-brand img-fluid img-nav">
			<img src="img/hospital-header-logo.png" width="" height="">
		</div>
		<ul class="navbar-nav ml-auto nav-items">
			<li class="nav-item bem-vindo-nav">
				<span class="nav-link"><?php echo 'Bem vindo ' . ucfirst($_POST['userName']) . ' !' ?></span>
			</li>
			<div class="divisor-nav"></div>
			<li class="nav-item logout-nav">
				<a href="Actions/User/logout.php" class="nav-link logout-text">Sair</a>
			</li>
		</ul>
	</nav>

	 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>