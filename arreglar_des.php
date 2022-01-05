<?php
session_start();
include ('conexion.php');
conectar();

if (conectar())
{
$sql_expte = "select * from expte;";
$res_expte = mysql_query($sql_expte) or die (mysql_error());
$a=0;
?>	<table align="center" border="1">
	<tr><td>EXPEDIENTE</td><td>CANT. DES. (EXP)</td><td>CANT. DES. (DES)</td><td>¿IGUAL?</td></tr>
<?	while ($row_expte = mysql_fetch_array($res_expte))
	{
	$sql_des = "select COUNT(num_des) as cant_des from desem
				where num_expte = ".$row_expte["num_expte"]." and 
						letra_expte = '".$row_expte["letra_expte"]."' and 
						anio_expte = ".$row_expte["anio_expte"].";";
	$res_des= mysql_query($sql_des) or die (mysql_error());
		while ($row_des = mysql_fetch_array($res_des))
		{
?>		<tr align="center"><td><? echo $row_expte["num_expte"]."-".$row_expte["letra_expte"]."-".$row_expte["anio_expte"]; ?></td>
			<td><? echo $row_expte["cant_desem"]; ?></td>
			<td><? echo $row_des["cant_des"]; ?></td>
			<td><? if ($row_expte["cant_desem"]==$row_des["cant_des"])
					{ echo "okk";} else { echo "nooooooooo"; } ?></td>
		</tr>
<?			if ($row_expte["cant_desem"]!=$row_des["cant_des"])
			{
			$sql = "update expte set cant_desem=".$row_des["cant_des"]." 
					where num_expte=".$row_expte["num_expte"]." and
						letra_expte='".$row_expte["letra_expte"]."' and
						anio_expte=".$row_expte["anio_expte"].";";
			$res = mysql_query($sql) or die (mysql_error());
			}
		}
	}
?>	</table>	<?
}

//////////// otra vez para ver si corrigio todo

$sql_expte = "select * from expte;";
$res_expte = mysql_query($sql_expte) or die (mysql_error());
$a=0;
?>	<table align="center" border="1">
	<tr><td>EXPEDIENTE</td><td>CANT. DES. (EXP)</td><td>CANT. DES. (DES)</td><td>¿IGUAL?</td></tr>
<?	while ($row_expte = mysql_fetch_array($res_expte))
	{
	$sql_des = "select COUNT(num_des) as cant_des from desem
				where num_expte = ".$row_expte["num_expte"]." and 
						letra_expte = '".$row_expte["letra_expte"]."' and 
						anio_expte = ".$row_expte["anio_expte"].";";
	$res_des= mysql_query($sql_des) or die (mysql_error());
		while ($row_des = mysql_fetch_array($res_des))
		{
?>		<tr align="center"><td><? echo $row_expte["num_expte"]."-".$row_expte["letra_expte"]."-".$row_expte["anio_expte"]; ?></td>
			<td><? echo $row_expte["cant_desem"]; ?></td>
			<td><? echo $row_des["cant_des"]; ?></td>
			<td><? if ($row_expte["cant_desem"]==$row_des["cant_des"])
					{ echo "okk";} else { echo "nooooooooo"; } ?></td>
		</tr>
<?		}
	}
?>	</table>	<?
?>
</body>
</html>
