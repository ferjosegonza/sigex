<?php
session_start();
include ('conexion.php');
conectar();

if (conectar())
{

// INSERTS DE LA TABLA EXPTE
$sql_expte = "select * from expte;";
$res_expte = mysql_query($sql_expte) or die (mysql_error());
$exp=0;
?>	<table align="center">
<?	while ($row_expte = mysql_fetch_array($res_expte))
	{$exp++;
?>	<tr><td><? echo "insert into expte values (".$row_expte["num_expte"].",
			'".$row_expte["letra_expte"]."',".$row_expte["anio_expte"].",
			".$row_expte["conv"].",
			".$row_expte["aborigen"].",
			".$row_expte["cant_desem"].",
			'".$row_expte["extracto"]."',
			'".$row_expte["f_inicio"]."',
			'".$row_expte["f_termino"]."',
			".$row_expte["cod_muni"].",
			".$row_expte["monto_total"].",
			'".$row_expte["observ"]."');"; ?></td></tr>
<?	} 
mysql_free_result($res_expte);

// INSERTS DE LA TABLA DESEM
$sql_des = "select * from desem;";
$res_des = mysql_query($sql_des) or die (mysql_error());

?>	<table align="center">
<?	while ($row_des = mysql_fetch_array($res_des))
	{
?>	<tr><td><? echo "insert into desem values (
			".$row_des["num_expte"].",
			'".$row_des["letra_expte"]."',
			".$row_des["anio_expte"].",
			".$row_des["num_des"].",
			".$row_des["monto"].",
			'".$row_des["f_cert"]."');"; ?></td></tr>
<?	}
mysql_free_result($res_des);

// INSERTS DE LA TABLA UTILIZO
$sql_uti = "select * from utilizo;";
$res_uti = mysql_query($sql_uti) or die (mysql_error());

?>	<table align="center">
<?	while ($row_uti = mysql_fetch_array($res_uti))
	{
?>	<tr><td><? echo "insert into utilizo values (
			".$row_uti["cod_usu"].",
			".$row_uti["num_expte"].",
			'".$row_uti["letra_expte"]."',
			".$row_uti["anio_expte"].",
			'".$row_uti["fecha"]."',
			'".$row_uti["hora"]."',
			".$row_uti["creo"].",
			".$row_uti["modif"].",
			".$row_uti["borro"].");"; ?></td></tr>
<?	}
mysql_free_result($res_uti);

// INSERTS DE LA TABLA INCLUYE
$sql_inc = "select * from incluye;";
$res_inc = mysql_query($sql_inc) or die (mysql_error());

?>	<table align="center">
<?	while ($row_inc = mysql_fetch_array($res_inc))
	{
?>	<tr><td><? echo "insert into incluye values (
			".$row_inc["cod_plan"].",
			".$row_inc["num_expte"].",
			'".$row_inc["letra_expte"]."',
			".$row_inc["anio_expte"].",
			".$row_inc["cant"].");"; ?></td></tr>
<?	}
mysql_free_result($res_inc);
}	
mysql_close();
?>	</table>
