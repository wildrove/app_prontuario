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
</body>
</html>