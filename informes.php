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
<? 	echo "USUARIO REGISTRADO: ",$_SESSION['user'];
if (isset($_SESSION["user"]))
{ 
$sql_munis = "select * from muni;";
$res_munis = mysql_query($sql_munis) or die (mysql_error());
	if (($_POST["informes"]) or ($_SESSION["volver_informe"]))
	{	
		unset($_SESSION["volver_informe"]);
		 ?><form action="informes.php" name="informes2" method="post">
		<table align="center">
		<tr align="center"><td><span class="Estilo1">CRITERIOS DEL INFORME:</span></td>
		</tr>
		</table>

		<table align="center">
		<tr><td>
			<table align="center" border="1">
			<tr>
			  <td colspan="2"><strong>¿Qué estados desea incluir en el informe?:</strong></td>
			</tr>
			<tr><td>Expedientes en trámite:</td><td><input type="checkbox" name="tramite" /></td></tr>
			<tr><td>Expedientes en ejecución:</td><td><input type="checkbox" name="ejecucion" /></td></tr>
			<tr><td>Expedientes terminados:</td><td><input type="checkbox" name="terminados" /></td></tr>
			</table>
		
		<table align="center" border="1">
			<tr><td>Expedientes de Empresas:</td><td><input type="checkbox" name="emp" /></td></tr>
			<tr><td>Expedientes de Municipalidades:</td><td><input type="checkbox" name="munis" /></td></tr>
		</table>
		
		<table align="center" border="1">
		<tr><td colspan="2">¿Sólo Expedientes de aborígenes? Sí<input type="radio" name="ab" value="si" /> - No<input type="radio" name="ab" value="no" />
		</td></tr>
		</table>
		</td>

		<td>
			<table align="center" border="1">
			<tr align="center"><td colspan="2"><strong>¿Qué Operatorias desea incluir?</strong></td></tr>
			<tr><td><input type="checkbox" name="ptodas" /><strong>TODAS</strong></td>
				<td><input type="checkbox" name="p5" value="5" />Dormitorios</td></tr>
			<tr><td><input type="checkbox" name="p1" value="1" />Plan Techo</td>
				<td><input type="checkbox" name="p6" value="6" />Baño y Lavadero</td></tr>
			<tr><td><input type="checkbox" name="p2" value="2" />Plan Cerramientos</td>
				<td><input type="checkbox" name="p7" value="7" />Baño para Aula Satélite</td></tr>
			<tr><td><input type="checkbox" name="p3" value="3" />Viv. Tipo Misionera</td>
				<td><input type="checkbox" name="p8" value="8" />Letrina Ecológica</td></tr>
			<tr><td><input type="checkbox" name="p4" value="4" />Pisos</td>
				<td><input type="checkbox" name="p9" value="9" />Letrina con pozo ventilado</td></tr>
			</table>

	<table align="center" border="1">
		<tr><td>Desde:</td><td><input type="text" size="1" name="desde_d" />/
								<input type="text" size="1" name="desde_m" />/<input type="text" size="3" name="desde_a" /></td></tr>
		<tr><td>Hasta:</td><td><input type="text" size="1" name="hasta_d" />/
								<input type="text" size="1" name="hasta_m" />/<input type="text" size="3" name="hasta_a" /></td></tr>
	</table>

		</td></tr>
		</table>
		</table>
		<br />
		<table align="center">
		<tr><td colspan="3"><strong>Indique qué Municipios desea incluir en el informe:</strong></td>
		</tr>
		<tr align="center"><td colspan="3" bgcolor="#CCCCCC"><strong>TODOS</strong> LOS MUNICIPIOS: 
		  <input type="checkbox" name="todos" /></td></tr>			
		<td bgcolor="#CCCCCC"></td><td bgcolor="#CCCCCC"></tr>
  </table>
		<?
		$sql = "select * from muni;";
		$res = mysql_query($sql) or die (mysql_error());
		?>
		<table align="center" bgcolor="#CCCCCC">
		<tr><td>
		<table bgcolor="#CCCCCC">
<?		while ($row= mysql_fetch_row($res))
		{  ?>
			<tr><td><input type="checkbox" name="<? echo $row[0];?>" /><? echo $row[1];?></td></tr>
<?			if (($row[0]==25) || ($row[0]==50))
			{ ?>
		  </table></td><td><table bgcolor="#CCCCCC">
<?			} 
		}
		?>
		</table></td></tr>
  </table>
		<table align="center">
		<tr align="center"><td><input type="submit" name="informe2" value="Generar Informe" /></td></tr>
		</table>
		</form>
<?	} // informe

	else if ($_POST["informe2"]) 
	{
		?><br /><?
	
	$ok_muni=false;
	$ok_estado=false;
	$ok_plan=false;
	$ok_aborigen=false;
	
		//////////////// verificar si se tildo algo: incluir solo exptes de aborigenes o no		$_POST["ab"]
		if ($_POST["ab"]=='si')
		{$ab=' and e.aborigen=1'; 	
		$ok_aborigen=true;
		}
		else
		{$ab='';
		}
		//////////// fin verificar si se tildo aborigen

		//////////////// verifico si se tildo algun estado, o todos
		if (($_POST["tramite"]) or ($_POST["ejecucion"]) or ($_POST["terminados"]))
		{$ok_estado=true;
			if (
					((isset($_POST["tramite"]))==true) and 
					((isset($_POST["ejecucion"]))==true) and 
					((isset($_POST["terminados"]))==true)
				)
			{$est=" "; $titulo_estado="EXPEDIENTES EN TRAMITE, EN EJECUCION Y TERMINADOS";}
			else 
			{
			if (
					((isset($_POST["tramite"]))==false) and 
					((isset($_POST["ejecucion"]))==false) and 
					((isset($_POST["terminados"]))==true)
				)
				{$titulo_estado="EXPEDIENTES TERMINADOS";
				$est=" and (e.f_inicio<>0000-00-00 and e.f_termino<>0000-00-00)";
				}
			if (
					((isset($_POST["tramite"]))==false) and 
					((isset($_POST["ejecucion"]))==true) and 
					((isset($_POST["terminados"]))==false)
				)
				{$titulo_estado="EXPEDIENTES EN EJECUCION";
				$est=" and (e.f_inicio<>0000-00-00 and e.f_termino=0000-00-00)";
				}
			if (
					((isset($_POST["tramite"]))==false) and 
					((isset($_POST["ejecucion"]))==true) and 
					((isset($_POST["terminados"]))==true)
				)
				{$titulo_estado="EXPEDIENTES EN EJECUCION Y TERMINADOS";
				$est=" and (e.f_inicio<>0000-00-00)";
				}
			if (
					((isset($_POST["tramite"]))==true) and 
					((isset($_POST["ejecucion"]))==false) and 
					((isset($_POST["terminados"]))==false)
				)
				{$titulo_estado="EXPEDIENTES EN TRAMITE";
				$est=" and (e.f_inicio=0000-00-00 and e.f_termino=0000-00-00)";
				}
			if (
					((isset($_POST["tramite"]))==true) and 
					((isset($_POST["ejecucion"]))==false) and 
					((isset($_POST["terminados"]))==true)
				)
				{$titulo_estado="EXPEDIENTES EN TRAMITE Y TERMINADOS";
				$est=$est." and ((e.f_inicio=0000-00-00 and e.f_termino=0000-00-00) or 
							(e.f_inicio<>0000-00-00 and e.f_termino<>0000-00-00))";
				}
			if (
					((isset($_POST["tramite"]))==true) and 
					((isset($_POST["ejecucion"]))==true) and 
					((isset($_POST["terminados"]))==false)
				)
				{$titulo_estado="EXPEDIENTES EN TRAMITE Y EN EJECUCION";
				$est=" and (e.f_inicio=0000-00-00 or e.f_termino=0000-00-00)";
				}
			}
		} 
		else
		{
		echo " <script languaje=javascript>alert ('Debe seleccionar al menos un estado. Recuerde que un expediente puede encontrarse en trámite, en ejecución, o terminado.');</script> ";
		}
		////////////// fin verificar estado
		
		////////////// verificar si se tildo algun plan, o todos
		if($_POST["ptodas"])
		{$ok_plan=true;		$opes="";
		}
		else
		{	$opes=" and (";
			$a=0;
			for ($p=1;$p<10;$p++)
			{	$r= "p".$p; 
				if ($_POST[$r]) 
				{ $a++;
				$ok_plan=true;
					if ($a=='1')
					{}
					else 
					{$opes=$opes." or ";
					}
				$opes=$opes."i.cod_plan=".$p;
				}
			}
			$opes=$opes.") ";
		} 
		if (!$ok_plan)
		{ echo " <script languaje=javascript>alert ('Seleccione al menos una Operatoria.');</script> "; 
		}
		////////////// fin verificar plan

		/////////////// verifico si se tildo un munic o la casilla "todos", y hago la consulta
	?> <table align="center" border="1">
				<tr align="center"><td colspan="4"><strong><? echo $titulo_estado; ?></strong></td></tr>
				<tr align="center">
				  <td>Nº</td>
				  <td>MUNICIPIO</td>
				  <td>CANTIDAD</TD>
				  <td>OPERATORIA</TD>
			  </tr>
	<?	$a=1; $total =0;
		if ($_POST["todos"])
		{$ok_muni=true; 
			$sql = "select 	m.desc_muni as muni, 
							SUM(i.cant) as cant, 
							p.desc_plan as plan
					from	muni m, expte e, incluye i, plan p
					where	m.cod_muni=e.cod_muni and
							p.cod_plan=i.cod_plan and
							e.num_expte=i.num_expte and
							e.letra_expte=i.letra_expte and
							e.anio_expte=i.anio_expte".$est.$ab.$opes."
					group by muni, plan
					order by muni, plan;";
					
			$res = mysql_query($sql) or die (mysql_error());
			while ($row= mysql_fetch_array($res))
			{
			?> <TR><TD align="center"><? echo $a; ?></TD>
			<TD align="left"><? echo $row["muni"]; ?></TD>
			<TD align="right"><? echo $row["cant"]; ?></TD>
			<TD align="left"><? echo $row["plan"]; ?></TD>
			</TR>
<?			$a++; $total=$total + $row["cant"];
			}	?>
			<tr><td colspan="2" align="center"><strong>TOTAL</strong></td><td align="right"><strong><? echo $total; ?></strong></td></tr>
<?		}
		else
		{ 	$b=1; $total =0;
			for ($a=1;$a<76;$a++)
			{	
				if ($_POST[$a])
				{ $ok_muni=true; 
			$sql = "select 	m.desc_muni as muni, 
							SUM(i.cant) as cant, 
							p.desc_plan as plan
					from	muni m, expte e, incluye i, plan p
					where	m.cod_muni=e.cod_muni and
							e.cod_muni=".$a." and
							p.cod_plan=i.cod_plan and
							e.num_expte=i.num_expte and
							e.letra_expte=i.letra_expte and
							e.anio_expte=i.anio_expte".$est.$ab.$opes."
					group by muni, plan
					order by muni, plan;";
					$res=mysql_query($sql) or die (mysql_error());
					if(!$res)
					{}
					else
					{	
						while ($row= mysql_fetch_array($res))
						{
						?> <TR><TD align="center"><? echo $b; ?></TD>
						<TD align="left"><? echo $row["muni"]; ?></TD>
						<TD align="right"><? echo $row["cant"]; ?></TD>
						<TD align="left"><? echo $row["plan"]; ?></TD>
						</TR>
			<?			$b++; $total=$total + $row["cant"];
						}	?>
<?					}
				} // if $_POST[$a]
			} // for 75
?>				<tr><td colspan="2" align="center"><strong>TOTAL</strong></td><td align="right"><strong><? echo $total; ?></strong></td></tr>
	<?	} // else

		?></table><?
		
		if ($ok_muni)
		{}
		else
		{echo " <script languaje=javascript>alert ('Seleccione al menos un municipio.');</script> ";
		}
		///////////////// fin verificar muni
		
		if ((!$res) or (!$ok_muni) or (!$ok_estado) or (!$ok_plan))
		{
			if (!$res)
			{echo " <script languaje=javascript>alert ('La búsqueda no ha producido ningún resultado. Intente nuevamente');</script> ";			}
		$_SESSION["volver_informe"]=true;
		echo "<script>window.location.href = \"informes.php\"</script>";
		}
	} // else informe2
	else if ($_POST["totalxaño"]) 
	{
		echo "<script>window.location.href = \"totales.php\"</script>";
	}
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
