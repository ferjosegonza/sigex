<?php
session_start();
include ('encabezado.php');
//poner_encabezado();
include ('conexion.php');
conectar();
include ('funciones.php');
fecha();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SIGEX - Sistema de Gestión de Expedientes</title>

<style type="text/css">
<!--
body {
	background-image: url(operatorias.png);
}
-->
<!--
.Estilo1 {font-size: 9px}
.boton{
        font-size:10px;
        font-family:Verdana,Helvetica;
        font-weight:bold;
        color:white;
        background:#638cb5;
        border:0px;
        width:80px;
        height:19px}
body,td,th {
	font-family: Calibri;
}
-->
</style>

</head>
<body>
<br />
<? 	if ($_SESSION['usuario_autentificado'])
	{ 
	?><br /><? echo "MUNICIPIO REGISTRADO: ".$_SESSION['muni'];
	?>
<table align="center" border="1">
<tr><td>
	<table align="center">
	<tr align="center"><td><strong>GESTIÓN DE EXPEDIENTES</strong></td></tr>
	<form name="buscar_paso1" method="post" class="boton" action="buscar_muni.php">
	<tr align="center"><td><input type="submit" name="buscar_paso1" value="  Buscar Expediente/s  " /></td></tr></form>
	<form name="buscar_paso1" method="post" class="boton" action="informes_muni.php">
	<tr align="center"><td><input name="informes" value=" Totales por Operatoria " type="submit" /></td></tr></form>
	<form name="buscar_paso1" method="post" class="boton" action="totales_muni.php">
	<tr align="center"><td><input name="totalxaño" value="      Totales por Año      " type="submit" /></td></tr>
	</form>
	</table>
</td>
<td>
	<table align="center">	
	<tr align="center"><td><strong>GESTIÓN DE USUARIOS</strong></td></tr>
	<form name="muni" method="post" action="munis_clave.php">
	<tr align="center"><td><input type="submit" name="cambiar_clave" value="Cambiar clave del Municipio" /></td></tr>
	</form>
	<form name="again" method="post" action="munis.php">
	<tr align="center"><td><input type="submit" name="again" value="          Volver al Inicio          " /></td></tr>
	</form>
	<form name="tutorial" method="post" action="tutorial.php">
	<tr align="center"><td><a href="manual de municipio.doc">Descargar Manual de Usuario</a></td>
	</tr>
	</form>
	</table>
</td></tr>
</table>

<?	} 
	else 
	{ 
	echo " <script languaje=javascript>alert ('Ingrese con Usuario y Contraseña.');</script> "; 
	echo "<script>window.location.href = \"index.php\"</script>";
	}?>

</body>
</html>
