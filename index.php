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
</style></head>
<body>
 
      <p>&nbsp;</p>

<? if ($_POST["again"])
	{
	session_destroy();
	}
?>
<form action="validar.php" method="post" name="validar">
<table align="center" border="1">
<tr align="center">
	<td>USUARIO:</td><td><input name="user" type="text" /></td>
</tr>
<tr>
	<td>CONTRASEÑA:</td><td><input name="pass" type="password" /></td>
</tr>
<tr>
	<td colspan="2" align="center"><input name="entrar" value="ENTRAR" type="submit" /></td>
</tr>
</table>
</form>

</body>
</html>
