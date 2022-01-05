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
<title>SIGEX - Sistema de Gestión de Expedientes.</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Calibri;
}
-->
</style></head>

<body>
<BR />
<? 	echo "USUARIO REGISTRADO: ",$_SESSION['user'];

if (isset($_SESSION["user"]))
{ 
	if (($_POST["borrar"]) or ($_SESSION["volver"]))
	{ 
$sql_munis = "select * from muni;";
$res_munis = mysql_query($sql_munis) or die (mysql_error());
 ?>
 		<form action="mostrar_uno.php" name="borrar_paso1" method="post">
			<table align="center">
			<tr align="center"><td><strong>BUSQUEDA POR EXPEDIENTE:</strong></td></tr>
			</table>
			<table align="center">
			<tr><td>Expediente Nº: <input type="text" size="1" name="num_expte"/> - 
	Letra: <select name="letra_expte">
				<option value="A">A</option>
				<option value="B">B</option>
				<option value="C">C</option>
				<option value="D">D</option>
				<option value="E">E</option>
				<option value="F">F</option>
				<option value="G">G</option>
				<option value="H">H</option>
				<option value="I">I</option>
				<option value="J">J</option>
				<option value="K">K</option>
				<option value="L">L</option>
				<option value="M">M</option>
				<option value="N">N</option>
				<option value="O">O</option>
				<option value="P">P</option>
				<option value="Q">Q</option>
				<option value="R">R</option>
				<option value="S">S</option>
				<option value="T">T</option>
				<option value="U">U</option>
				<option value="V">V</option>
				<option value="W">W</option>
				<option value="X">X</option>
				<option value="Y">Y</option>
				<option value="Z">Z</option>
			</select>
	 - 
	Año: <input type="text" size="2" name="anio_expte"/>.</td></tr>
			<tr align="center"><td><input type="submit" name="borrar_paso1" value="Siguiente" /></td></tr>
			</table>
			</form>
<?	unset($_SESSION["volver"]);
	}
	else if ($_POST["borrar_paso2"]) 
	{

	// borra en tabla expte
	$sql_exp = "delete from expte where 
				num_expte='".$_POST["n_exp"]."' and
				letra_expte='".$_POST["l_exp"]."' and
				anio_expte='".$_POST["a_exp"]."';";
	$res_exp = mysql_query($sql_exp) or die (mysql_error());
	// borra en tabla incluye
	$sql_inc = "delete from incluye where 
				num_expte='".$_POST["n_exp"]."' and
				letra_expte='".$_POST["l_exp"]."' and
				anio_expte='".$_POST["a_exp"]."';";
	$res_inc = mysql_query($sql_inc) or die (mysql_error());
	// borra en tabla desem
	$sql_des = "delete from desem where 
				num_expte='".$_POST["n_exp"]."' and
				letra_expte='".$_POST["l_exp"]."' and
				anio_expte='".$_POST["a_exp"]."';";
	$res_des = mysql_query($sql_des) or die (mysql_error());
	
	// carga en la tabla utilizo
	$sql_usu = "select * from usuario where user = '".$_SESSION["user"]."';";
	$res_usu = mysql_query($sql_usu) or die (mysql_error());
	$row_usu = mysql_fetch_row($res_usu);
	$cod_usu = $row_usu[0];
	
	$anio = date("Y"); 
	$mes = date("m"); 
	$dia = date("d");
	$fecha = $anio.$mes.$dia;

	$hora = date("H:i:s");

	$sql_bor = "insert into utilizo (
	cod_usu,
	num_expte,
	letra_expte,
	anio_expte,
	fecha,
	hora,
	borro) 
	values (
'".$cod_usu."',
'".$_POST["n_exp"]."',
'".$_POST["l_exp"]."',
'".$_POST["a_exp"]."',
".$fecha.",
'".$hora."',
1);";
	$res_bor = mysql_query($sql_bor) or die (mysql_error());
	
		if (($res_exp) and ($res_inc) and ($res_des))
		{
		echo " <script languaje=javascript>alert ('El Expediente se ha borrado con éxito.');</script> ";
?>		<table align="center">
		<tr><td>
		<form method="post" action="borrar.php" name="modif">
		<input type="submit" name="borrar" value="Borrar otro" />
		</form>
		</td></tr></table>
<?
		}
	}
} 
else 
{ echo " <script languaje=javascript>alert ('Usuario no identificado.');</script> "; 
	echo "<script>window.location.href = \"index.php\"</script>";
}

?>
<table align="center">
<tr><td>
<form method="post" action="menu.php" name="menu">
<input type="submit" name="menu" value="Volver al Menu" />
</form>
</td></tr></table>
</body>
</html>
