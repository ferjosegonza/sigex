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
<title>SIGEX - Sistema de Gesti�n de Expedientes</title>
<style type="text/css">
<!--
body {
	background-image: url(operatorias.png);
}
-->
</style></head>
<body>
 
      <p>&nbsp;</p>
<?	$sql_munis = "select * from muni;";
$res_munis = mysql_query($sql_munis) or die (mysql_error());
?>

<form action="validar_muni.php" method="post" name="validar">
<table align="center" border="1">
<tr align="center">
	<td>MUNICIPIO:</td><td><select name="muni">
	<? while ($row_munis = mysql_fetch_row($res_munis))
	{ ?>
		<option value="<? echo $row_munis[1]; ?>"><? echo $row_munis[1]; ?></option>
<?	} /* while */?>
	</select></td>
</tr>
<tr>
	<td>CONTRASE�A:</td><td><input name="pass" type="password" /></td>
</tr>
<tr>
	<td colspan="2" align="center"><input name="entrar" value="ENTRAR" type="submit" /></td>
</tr>
</table>
</form>

</body>
</html>
