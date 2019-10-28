
<!DOCTYPE html>
<html>
<head>
	<title>Prontuário médico eletrônico</title>
	 <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../bootstrap/css/style.css">

     <!-- Bootstrap link -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

     <!-- Fontawesome link -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">
        
      <script type="text/javascript">
          function carregarLoad(){
            $.load()
          }
      </script>
</head>
	<body>

		<section class="main-section">
			<div class="card">
  				<h5 class="card-header card-titulo bg-dark text-light">Prontuário Médico Eletrônico</h5>
 					<div class="card-body">
    					<legend  class="card-title">Filtros para Localizar Paciente:</legend>
    						<form method="get" action="Actions/Pacient/findPacient.php">
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

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	</body>
</html>