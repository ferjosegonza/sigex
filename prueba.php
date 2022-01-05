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
<?	if (($_SESSION["criterio"]='muni') and (!$_POST["buscar_paso3"]))
	{
		 ?><form action="prueba.php" name="buscar_paso3" method="post">
<? /*		<table align="center">
		<tr align="center"><td><strong>CRITERIOS DE BUSQUEDA:</strong></td></tr>
		</table>
		<table align="center">
		<tr><td>
		<table align="center" border="1">
		<tr><td colspan="2"><strong>¿Qué estados desea incluir en la búsqueda?:</strong></td></tr>
		<tr><td>Expedientes en trámite:</td><td><input type="checkbox" name="tramite" /></td></tr>
		<tr><td>Expedientes en ejecución:</td><td><input type="checkbox" name="ejecucion" /></td></tr>
		<tr><td>Expedientes terminados:</td><td><input type="checkbox" name="terminados" /></td></tr>
		</table>
*/ ?>		<br />
		<table align="center" border="1">
		<tr align="center"><td><strong>Elija el orden deseado:</strong></td></tr>
		<tr><td>
		<select name="orden" >
			<option value="muni">Municipio</option>
			<option value="a_exp,l_exp,n_exp">Expediente</option>
			<option value="conv">Convenio</option>
			<option value="f_ini">Fecha de inicio</option>
			<option value="f_ter">Fecha de cierre</option>
		</select>
		</td></tr>
		</table>
		<br />
		<table align="center" border="1">
		<tr><td>¿Sólo Expedientes de aborígenes? Sí<input type="radio" name="ab" value="si" /> - No<input type="radio" name="ab" value="no" />
		</td></tr>
		</table>
<? /*		</td>
		<td>
		<table align="center" border="1">
		<tr align="center"><td><strong>¿Qué Operatorias desea incluir?</strong></td></tr>
		<tr><td><input type="checkbox" name="1" value="1" />Plan Techo</td></tr>
		<tr><td><input type="checkbox" name="2" value="2" />Plan Cerramientos</td></tr>
		<tr><td><input type="checkbox" name="3" value="3" />Viv. Tipo Misionera</td></tr>
		<tr><td><input type="checkbox" name="4" value="4" />Pisos</td></tr>
		<tr><td><input type="checkbox" name="5" value="5" />Dormitorios</td></tr>
		<tr><td><input type="checkbox" name="6" value="6" />Baño y Lavadero</td></tr>
		<tr><td><input type="checkbox" name="7" value="7" />Baño para Aula Satélite</td></tr>
		<tr><td><input type="checkbox" name="8" value="8" />Letrina Ecológica</td></tr>
		<tr><td><input type="checkbox" name="9" value="9" />Letrina con pozo ventilado</td></tr>
		<tr><td><input type="checkbox" name="ptodas" />TODAS</td></tr>
		</td></tr>
		</table>
		</table>
		<table align="center">
		<tr><td colspan="3"><strong>Indique qué Municipios desea incluir en la búsqueda:</strong></td></tr>
		<tr align="center"><td colspan="3">TODOS LOS MUNICIPIOS: <input type="checkbox" name="todos" /></td></tr>			
		</td></tr>
		</table>
		<?
*/		$sql = "select * from muni;";
		$res = mysql_query($sql) or die (mysql_error());
		?>
		<table align="center">
		<tr><td>
		<table>
<?		while ($row= mysql_fetch_row($res))
		{  ?>
			<tr><td><input type="checkbox" name="<? echo $row[0];?>" value="<? echo $row[0];?>" /><? echo $row[1];?></td></tr>
<?			if (($row[0]==25) || ($row[0]==50))
			{ ?>
				</table></td><td><table>
<?			} 
		}
		?>
		</table></td></tr>
		</table>
 		<table align="center">
		<tr align="center"><td><input type="submit" name="buscar_paso3" value="Siguiente" /></td></tr>
		</table>
<?	unset($_SESSION["criterio"]); ?>
		</form>
<?	
	} // session criterio muni

	else if ($_POST["buscar_paso3"]) 
	{

		//////////////// verificar si se tildo algo: incluir solo exptes de aborigenes o no		$_POST["ab"]
		if ($_POST["ab"]=='si')
		{$ab=' and e.aborigen=1 '; 
		}
		else
		{$ab='';
		}
		//////////// fin verificar si se tildo aborigen
	?> <table align="center" border="1">
		<tr><td>MUNI</td><TD>EXPTE</TD><TD>CONV</TD><TD>EXTRACTO</TD><TD>F_INI</TD><TD>F_TER</TD><TD>MONTO</TD><TD>OBSERV</TD></tr>
	<?

			for ($a=1;$a<76;$a++)
			{
				if ($_POST[$a])
				{ $ok_muni=true; echo "entro al if del muni: $a, el post es $_POST[$a], lo de aborigen es $ab";
					$sql = "select 	m.desc_muni as muni,
					e.num_expte as n_exp,
					e.letra_expte as l_exp,
					e.anio_expte as a_exp,
					e.conv as conv,
					e.extracto as extr,
					e.f_inicio as f_ini,
					e.f_termino as f_ter,
					e.monto_total as m_total,
					e.observ as observ
					from	muni m, expte e
					where	m.cod_muni=e.cod_muni".$ab." and
							e.cod_muni='".$_POST[$a]."'
					order by ".$_POST['orden'].";";
?> <BR /> <?				echo "el SSSSQQQLLL:".$sql;?> <BR /> <?
					$res = mysql_query($sql) or die (mysql_error()); 
						while ($row= mysql_fetch_array($res))
						{
						?> <TR><TD><? echo $row["muni"]; ?></TD>
						<TD><? echo $row["n_exp"]."-".$row["l_exp"]."-".$row["a_exp"]; ?></TD>
						<TD><? echo $row["conv"]; ?></TD>
						<TD><? echo $row["extr"]; ?></TD>
						<TD><? echo $row["f_ini"]; ?></TD>
						<TD><? echo $row["f_ter"]; ?></TD>
						<TD><? echo $row["m_total"]; ?></TD>
						<TD><? echo $row["observ"]; ?></TD>
						</TR>
				<?		}
				} // if $_POST[$a]
			} // for 75
?> </table> <?
	
/*	$sql = "select 	m.desc_muni as muni,    
					e.num_expte as n_exp,
					e.letra_expte as l_exp,
					e.anio_expte as a_exp,
					e.conv as conv,
					e.extracto as extr,
					e.f_inicio as f_ini,
					e.f_termino as f_ter,
					e.monto_total as m_total,
					e.observ as observ
			from	muni m, expte e
			where	m.cod_muni=e.cod_muni".$ab."
			order by ".$_POST['orden'].";";
	$res = mysql_query($sql) or die (mysql_error()); */

/*		?><br /><?
	
	$ok_muni=false;
	$ok_estado=false;
	$ok_plan=false;
	

		/////////////// verifico si se tildo un munic o la casilla "todos", y hago la consulta
		if ($_POST["todos"])
		{$ok_muni=true;
		$sql = "select m.desc_muni as desc_muni, 
					e.num_expte as num_expte,
					e.letra_expte as letra_expte,
					e.anio_expte as anio_expte,
					e.conv as conv,
					e.aborigen as aborigen,
					e.cant_desem as cant_desem,
					e.extracto as extracto,
					e.f_inicio as f_inicio,
					e.f_termino as f_termino,
					e.monto_total as monto_total,
					e.observ as observ
				from 
					muni m, expte e
				where
					m.cod_muni=e.cod_muni;";
				//	m.cod_muni=e.cod_muni'".$ab."';";
		}
		else
		{
			for ($a=1;$a<76;$a++)
			{
				if ($_POST[$a])
				{ $ok_muni=true; 
				$sql = "select m.desc_muni as desc_muni, 
							e.num_expte as num_expte,
							e.letra_expte as letra_expte,
							e.anio_expte as anio_expte,
							e.conv as conv,
							e.aborigen as aborigen,
							e.cant_desem as cant_desem,
							e.extracto as extracto,
							e.f_inicio as f_inicio,
							e.f_termino as f_termino,
							e.monto_total as monto_total,
							e.observ as observ
						from 
							muni m, expte e
						where
							m.cod_muni=e.cod_muni and
							m.cod_muni='".$a."';";
						//	m.cod_muni='".$a."''".$ab."';";							
				} // if $_POST[$a]
			} // for 75
		} // else

		if ($ok_muni)
		{$res = mysql_query($sql) or die (mysql_error());
		}
		else
		{echo " <script languaje=javascript>alert ('Seleccione al menos un municipio.');</script> ";
		}
		///////////////// fin verificar muni
		
		//////////////// verifico si se tildo algun estado, o todos
		if (($_POST["tramite"]) or ($_POST["ejecucion"]) or ($_POST["terminados"]))
		{$ok_estado=true;
		}
		else
		{
		echo " <script languaje=javascript>alert ('Debe seleccionar al menos un estado. Recuerde que un expediente puede encontrarse en trámite, en ejecución, o terminado.');</script> ";
		}
		////////////// fin verificar estado
		
		////////////// verificar si se tildo algun plan, o todos
		if($_POST["ptodas"])
		{$ok_plan=true;
		}
		else
		{	for ($p=1;$p<10;$p++)
			{
				if ($_POST[$p]) $ok_plan=true;
			}
		}
		
		////////////// fin verificar plan
		
		if (($res=false) or (!$ok_muni) or (!$ok_estado) or (!$ok_plan))
		{
			if ($res=false)
			{echo " <script languaje=javascript>alert ('La búsqueda no ha producido ningún resultado. Intente nuevamente');</script> ";			}
		$_SESSION["criterio"]='muni';
		echo "<script>window.location.href = \"mostrar_munis.php\"</script>";
		}*/
	} // else buscar_paso3
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
