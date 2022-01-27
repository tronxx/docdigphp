<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<header>
	<nav class="navbar navbar-inverse">
	<p class="navbar-text">BIENVENIDO</p>
	</nav>
	</header>

	<div class="panel panel-default">
		<div class="panel-heading">
	  		<?php echo $_GET['mensaje'];?>
		</div>

		<div class="panel-body">
			<a href="../index.php">
			<button  class="btn btn-danger">Volver a ingresar</button>
			</a>
		</div>
	</div>
</body>
</html>
