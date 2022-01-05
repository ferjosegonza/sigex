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
.Estilo1 {
	font-size: 24px;
	font-weight: bold;
}
body,td,th {
	font-family: Calibri;
}
-->
</style>
</head>

<body>
<BR />
<? 	echo "MUNICIPIO REGISTRADO: ",$_SESSION['muni'];
if (isset($_SESSION["muni"]))
{ 
	// TOTAL EN LA PCIA
?>
	<table align="center">
	<tr><td align="center"><strong>TOTAL DE SOLUCIONES IMPLEMENTADAS EN <? echo $_SESSION['muni']; ?></strong></td></tr>
	</table>
	<table align="center" border="1">
<?	$sql_total="select p.desc_plan as ope, SUM(i.cant) as cant 
				from plan p, incluye i, muni m, expte e
				where i.cod_plan = p.cod_plan and
				m.cod_muni = e.cod_muni and
				e.num_expte = i.num_expte and
				e.letra_expte = i.letra_expte and
				e.anio_expte = i.anio_expte and
				m.desc_muni = '".$_SESSION["muni"]."'
				group by p.cod_plan;";
	$res_total= mysql_query($sql_total) or die (mysql_error());
	$a=1; $total=0;
?>	<tr align="center"><td>Nº</td><td>OPERATORIA</td><td>CANTIDAD</td></tr> <?
	while ($row_total=mysql_fetch_array($res_total))
	{	?>
	<tr><td align="center"><? echo $a; ?></td>
		<td><? echo $row_total["ope"]; ?></td>
		<td align="right"><? echo $row_total["cant"]; ?></td></tr>
      <?	$a++; 
	$total=$total + $row_total["cant"];
	}
?>	<tr><td align="center" colspan="2"><strong>TOTAL</strong><td align="right"><strong><? echo $total; ?></strong></td></td>
	</table>	<?	
	// FIN TOTAL muni
	
	// TOTAL X ANIO
?>	

    <p>&nbsp;  </p>
    <table align="center">
	<tr><td colspan="3" align="center"><strong>CRONOLOGIA DE SOLUCIONES IMPLEMENTADAS</strong></td></tr>
	</table>
	<table align="center" border="1">
	<tr align="center"><td>Nº</td><td>OPERATORIA</td>
<?	$sql_anios= "select e.anio_expte from expte e, muni m 
				where e.cod_muni = m.cod_muni and
				m.desc_muni='".$_SESSION["muni"]."'
				group by e.anio_expte;";
	$res_anios=mysql_query($sql_anios) or die (mysql_error());
	while ($row_anios=mysql_fetch_array($res_anios))
	{	?>
	<td align="center"><? echo $row_anios["anio_expte"]; ?></td>
<?	}
?>	<td align="center">TOTALES</td>
	</tr>
	
<?	$sql_ope="select * from plan;";
	$res_ope=mysql_query($sql_ope) or die (mysql_error());
	$a=1;
	while ($row_ope=mysql_fetch_array($res_ope))
	{	?>
	<tr><td align="center"><? echo $a; ?></td>
		<td><? echo $row_ope["desc_plan"]; ?></td>
<?		$sql_anios= "select e.anio_expte as anio_expte 
				from expte e, muni m 
				where e.cod_muni = m.cod_muni and
				m.desc_muni='".$_SESSION["muni"]."'
				group by e.anio_expte;";
		$res_anios=mysql_query($sql_anios) or die (mysql_error());
		$total=0;
		while ($row_anios=mysql_fetch_array($res_anios))
		{	?>
		<td align="right"><?
			$sql_cant="select SUM(i.cant) as cant from incluye i, expte e, muni m
						where 	m.cod_muni=e.cod_muni and
								e.num_expte=i.num_expte and
								e.letra_expte=i.letra_expte and
								e.anio_expte=i.anio_expte and
								e.anio_expte=".$row_anios["anio_expte"]." and
								i.cod_plan=".$row_ope["cod_plan"]." and
								m.desc_muni='".$_SESSION["muni"]."'
								group by i.anio_expte;";
			$res_cant=mysql_query($sql_cant) or die (mysql_error());
			$row_cant=mysql_fetch_array($res_cant);
			if (!$res_cant)
			{echo "-";}
			else
			{echo $row_cant["cant"];}
			$total=$total + $row_cant["cant"];
?>		</td>
<?		}	?>		
		<td align="right"><? echo $total;?></td>
	</tr>
<?	$a++;
	}
?>	</table>
	
<?	// TOTAL X ANIO

} else { echo " <script languaje=javascript>alert ('Usuario no identificado.');</script> "; 
			echo "<script>window.location.href = \"munis.php\"</script>";}
?>
<table align="center">
<tr><td>
<form method="post" action="menu_muni.php" name="menu">
<input type="submit" name="menu" value="Volver al Menu" />
</form>
</td></tr>
</table>
</body>
</html>
