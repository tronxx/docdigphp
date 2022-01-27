<?php 
	session_start();
	unset($_SESSION['usuario']);
?>
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

<div class="container">
<div class="header"><div>Login</div>
<div class="body">
<form action="controller_login.php" method="post">
<div class="form-group">
    <label for="email">Usuario:</label>
    <input name="usuario" type="text" class="form-control" id="usuario">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pas" name="pas">
  </div>
  <input type="hidden" name="entrar" value="entrar">
  <button type="submit" class="btn btn-success">Entrar</button>
</form> 
</div>

<footer>
	<div class="container">
		<h4>Mis datos</h4>
	</div>
</footer>
</div>
</body>
</html>
