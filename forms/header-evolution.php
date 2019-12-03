
	<nav class="navbar navbar-expand-lg fixed-top navbar-header">
		<div class="navbar-brand img-fluid img-nav">
			<img src="../../img/hospital-header-logo.png" width="" height="">
		</div>
		<ul class="navbar-nav ml-auto nav-items">
			<li class="nav-item bem-vindo-nav">
				<span class="nav-link"><?php echo ucfirst(strtolower($_SESSION['nome_usuario'])); ?></span>
			</li>
			<div class="divisor-nav"></div>
			<li class="nav-item logout-nav">
				<a href="../../Actions/User/logout.php" class="nav-link logout-text">Sair</a>
			</li>
		</ul>
	</nav>
