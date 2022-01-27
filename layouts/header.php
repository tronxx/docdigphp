<?php
    $misdatfiscal_z = json_decode(file_get_contents("datosfiscales.json"), true);
    $nemp_z = $misdatfiscal_z["nombre"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>
  <?php    echo $nemp_z; ?>
  </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<img src="imagenes/cintillo.jpg" >
<?php
    echo $nemp_z;
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Facturacion</a>
    </div>
    <ul class="nav navbar-nav">
        <?php 
                 $menus_z = '[
                      {"titulo":"Consulta de Facturas","destino":"consultafac.php"},
                      {"titulo":"Descarga Facturas","destino":"descarga.php"},
                      {"titulo":"Enviar Facturas","destino":"envia.php"},
                      {"titulo":"Cancelar Factura","destino":"cancelafac.php"},
                      {"titulo":"Generar Password","destino":"genpwd.php"}
                 ]';
                 $mismenus_z =  json_decode($menus_z);
                 foreach ($mismenus_z as $mimenu_z) {
                      $opcion_z = '<li><a href="'. $mimenu_z->destino . '">'.$mimenu_z->titulo . '</a></li>';
                      echo $opcion_z;
                 }
        ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="login/login.php"><span class="glyphicon glyphicon-log-in"></span> Salir</a></li>
    </ul>
  </div>
</nav>
