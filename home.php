<?php 

	require_once('Actions/User/validateAccessFile.php');

 ?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo 'Bem vindo ' . $_POST['userName'] . ' ! ' ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/style.css">

     <!-- Bootstrap link -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

     <!-- Fontawesome link -->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.9.0/css/v4-shims.css">

</head>
<body>
	<?php 

		require_once('forms/header.php');

		if(isset($_GET['invalid_search']) && $_GET['invalid_search'] == 'YES'){
			require_once('./Alerts/searchInvalid.html');
		}
		require_once('forms/content-home.php');
	?>
</body>
</html>