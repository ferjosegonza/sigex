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
<title>SIGEX - Sistema de Gesti�n de Expedientes.</title>
</head>
<body>
<br /><?
echo "MUNICIPIO REGISTRADO: ".$_SESSION['muni'];
if (isset($_SESSION["muni"]))
{	
	if ($_POST["conv"])
	{ 
		if (isset($_POST['conv']))
		{ 
			if (is_numeric($_POST["conv"]))
			{			
			// selecciono expte
			$sql_expte = "select * from expte e, muni m where
					e.cod_muni = m.cod_muni and
					e.conv='".$_POST["conv"]."' and
					m.desc_muni='".$_SESSION['muni']."';";
			$res_expte = mysql_query($sql_expte) or die (mysql_error());
			$row_expte = mysql_fetch_row($res_expte);
			$ok = true;
			} // si es numerico
			else
			{
			echo " <script languaje=javascript>alert ('Debe ingresar un n�mero entero.');</script> " ;
			$_SESSION["volver"]=true;
			echo "<script>window.location.href = \"buscar_muni.php\"</script>";
			} // else numerico
		} // (isset($_POST['conv']))
	}  // if ($_POST['conv'])
	
	else if (($_POST["num_expte"]) and ($_POST["letra_expte"]) and ($_POST["anio_expte"]))
	{
		$ok=true;
		if (is_numeric($_POST["num_expte"]))
		{}
		else
		{$ok=false; 
		$nan="n�mero de expediente, ";}

		if (is_numeric($_POST["anio_expte"]))
		{}
		else
		{$ok=false;
		$nan1="a�o de expediente, ";
		$nan=$nan.$nan1;}

		if ($ok)
		{}
		else
		{$cargo_mal=1;
		echo " <script languaje=javascript>alert ('En: ".$nan." debe ingresar n�meros enteros.');</script> " ;
		}
		
		if (strlen($_POST["letra_expte"])==1)
		{
			if ($ok)
			{
				$sql_expte = "select * from expte e, muni m where
							e.cod_muni = m.cod_muni and
							m.desc_muni='".$_SESSION['muni']."' and	
							num_expte='".$_POST["num_expte"]."' and
							letra_expte='".$_POST["letra_expte"]."' and
							anio_expte='".$_POST["anio_expte"]."';";
				$res_expte = mysql_query ($sql_expte) or die (mysql_error());
				$row_expte = mysql_fetch_row($res_expte);
			}
		}
		else
		{ 
		$ok=false;
		echo "<script languaje=javascript>alert ('En el campo \"Letra de expte\" debe ingresar UNA sola letra .');</script> " ;
		}
	} // else if expte
	else 
	{	$ok = false;
		echo "<script languaje=javascript>alert ('Datos no v�lidos, ingrese nuevamente.');</script> " ;
		$_SESSION["volver"]='conv';
		echo "<script>window.location.href = \"buscar_muni.php\"</script>";
	}

	if ($ok)
	{
			$sql_muni = "select * from muni where
						cod_muni = '".$row_expte[9]."';";
			$res_muni = mysql_query($sql_muni) or die (mysql_error());
			$row_muni = mysql_fetch_row ($res_muni);

			// ver planes
			$sql_planes = "select i.cant as cant, p.desc_plan as desc_plan 
							from 
							plan p, incluye i
							where
							p.cod_plan=i.cod_plan and
							num_expte='".$row_expte[0]."' and
							letra_expte='".$row_expte[1]."' and
							anio_expte='".$row_expte[2]."';";
			$res_planes = mysql_query ($sql_planes) or die (mysql_error());

			// ver desembolsos
			$sql_desem = "select * from desem where
							num_expte='".$row_expte[0]."' and
							letra_expte='".$row_expte[1]."' and
							anio_expte='".$row_expte[2]."';";
			$res_desem = mysql_query($sql_desem) or die (mysql_error());
	} // ok		
	else
	{
	$_SESSION["volver"]=true;
	echo "<script>window.location.href = \"buscar_muni.php\"</script>";
	}			
				if ($row_expte)
				{ ?>
					<table align="center">
					<tr align="center"><td><strong>EXPEDIENTE N� <? echo $row_expte[0]."-"
					.$row_expte[1]."-".$row_expte[2];
				?>	</strong></td></tr>
					<tr><td>Convenio N�: <? echo $row_expte[3]; ?></td></tr>
					<tr><td>Fecha de Inicio (aaaa-mm-dd): <? echo $row_expte[7]; ?></td></tr>
					<tr><td>Fecha de T�rmino (aaaa-mm-dd): <? echo $row_expte[8]; ?></td></tr>
					<tr><td>Municipio: <? echo $row_muni[1]; ?></td></tr>
					<tr><td>Cantidad de desembolsos: <? echo $row_expte[5]; ?></td></tr>
					<tr><td>Monto total: $ <? echo $row_expte[10]; ?></td></tr>
					<tr><td>Extracto: <? echo $row_expte[6]; ?></td></tr>
					<tr><td>Observaciones: <? echo $row_expte[7]; ?></td></tr>
					<tr><td>Aborigen: <? if ($row_expte[4]) { echo "S�.";} else {echo "No.";} ?></td></tr>
					<tr align="center"><td><strong>OPERATORIAS:</strong> </td></tr>
				<?	while ($row_planes = mysql_fetch_array($res_planes))
					{
				?><tr><td><? echo $row_planes["desc_plan"]."- Cantidad: ".$row_planes["cant"];?></td></tr>
					<? } ?>
</table>
					<table align="center" border="1">
				 	<tr align="center"><td colspan="3"><strong>DETALLE DESEMBOLSOS:</strong> </td></tr>
					<tr align="center"><td>Desembolso N�</td><td>Monto</td><td>Fecha de Certificaci�n</td></tr>
				<?	while ($row_desem = mysql_fetch_array($res_desem))
					{
				?><tr align="center">
				<td><? echo $row_desem["num_des"]?></td><td>$ <? echo $row_desem["monto"];?></td>
				<td><? echo $row_desem["f_cert"]; ?></td>
				</tr>
					<? } ?>
				</table>
<?				} //if ($row_expte)
				else
				{echo " <script languaje=javascript>alert ('No se ha encontrado ning�n expediente.');</script> "; 
				$_SESSION["volver"]='conv';
				echo "<script>window.location.href = \"buscar_muni.php\"</script>";
?>				<table align="center">
				<tr><td>
				<?	if (!$_POST["borrar_paso1"])
					{
				?>
				<form action="buscar_muni.php" method="post" name="buscar_paso1">
				<input type="submit" name="buscar_paso1" value="Volver a buscar" />
				</form>
				<?	}	?>
				</td></tr>
				</table>
<?
				} // else
?>
<table align="center">
<tr><td>
<form method="post" action="menu_muni.php" name="menu">
<input type="submit" name="menu" value="Volver al Menu" />
</form>
</td></tr>
</table>
<?


} else { 
		echo " <script languaje=javascript>alert ('Usuario no identificado.');</script> "; 
		echo "<script>window.location.href = \"munis.php\"</script>";
		}  
?> 
</body>
</html>
