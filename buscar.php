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
</head>

<body>
<BR />
<? 	echo "USUARIO REGISTRADO: ",$_SESSION['user'];
if (isset($_SESSION["user"]))
{ 
$sql_munis = "select * from muni;";
$res_munis = mysql_query($sql_munis) or die (mysql_error());
	if (($_POST["buscar_paso1"]) or ($_POST["buscar_paso1"]=='Anterior') or  ($_SESSION["volver"]))
	{ 
 ?>
 	<form action="buscar.php" name="buscar_paso2" method="post">
	<table align="center">
	<tr align="center"><td><strong>CRITERIOS DE BUSQUEDA:</strong></td></tr>
	</table>
	<table align="center">
	<br />
	<tr><td>Por Convenio:</td><td><input type="radio" name="criterio" value="conv"/></td></tr>
	<tr><td>Por Expediente:</td><td><input type="radio" name="criterio" value="expte"/></td></tr>
	<tr><td>Por Municipio/s o estado del expediente:</td><td><input type="radio" name="criterio" value="muni"/></td></tr>
	<tr align="center"><td colspan="2"><input type="submit" name="buscar_paso2" value="Siguiente" /></td></tr>
	</table>
	</form>
<? 	
	unset($_SESSION["volver"]);
	} // buscar_paso1
	
	else if ($_POST["buscar_paso2"])
	{
		if ($_POST["criterio"]=='conv')
		{ ?><form action="mostrar_uno.php" method="post">
			<table align="center">
			<tr align="center"><td><strong>BUSQUEDA POR CONVENIO:</strong></td></tr>
			</table>
			<table align="center">
			<tr><td>Convenio Nº:<input type="text" name="conv" size="2" /></td></tr>
			<tr align="center"><td><input type="submit" name="buscar_paso3" value="Siguiente" /></td></tr>
			</table>
			</form>
			
<?		}
		else if ($_POST["criterio"]=='expte')
		{ ?><form action="mostrar_uno.php" name="buscar_paso3" method="post">
			<table align="center">
			<tr align="center"><td><strong>BUSQUEDA POR EXPEDIENTE:</strong></td></tr>
			</table>
			<table align="center">
			<tr><td>Por Expediente (nn/ll/aaaa): Nº: <input type="text" size="1" name="num_expte"/> - 
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
			<tr align="center"><td><input type="submit" name="buscar_paso3" value="Siguiente" /></td></tr>
			</table>
			</form>
<?		}
		else if ($_POST["criterio"]=='muni')
		{ 
		$_SESSION["criterio"]='muni';
		echo "<script>window.location.href = \"mostrar_munis.php\"</script>";
		} // criterio muni
	} // else buscar_paso2

} else { echo " <script languaje=javascript>alert ('Usuario no identificado.');</script> "; 
			echo "<script>window.location.href = \"index.php\"</script>";}
?>
<table align="center">
<tr><td>
<form method="post" action="menu.php" name="menu">
<input type="submit" name="menu" value="Volver al Menu" />
</form>
</td></tr>
</table>
</body>
</html>
