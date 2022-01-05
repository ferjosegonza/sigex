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
.style2 {font-size: 18px; font-weight: bold; }
-->
</style>
</head>

<body>
<BR />
<? 	echo "MUNICIPIO REGISTRADO: ",$_SESSION['muni'];
if (isset($_SESSION["muni"]))
{ 
$sql_munis = "select * from muni;";
$res_munis = mysql_query($sql_munis) or die (mysql_error());
	if (($_SESSION["criterio"]='muni') and (!$_POST["buscar_paso3"]))
	{
		 ?><form action="mostrar_munis_muni.php" name="buscar_paso3" method="post">
		<table align="center">
		<tr align="center"><td><span class="Estilo1">MUNICIPALIDAD DE <? echo $_SESSION["muni"]; ?></span></td></tr>
		<tr align="center"><td><span class="style2">FILTROS DE BUSQUEDA:</span></td>
		</tr>
		</table>

		<table align="center">
		<tr><td>
			<table align="center" border="1">
			<tr><td colspan="2"><strong>¿Qué estados desea incluir en la búsqueda?:</strong></td></tr>
			<tr><td>Expedientes en trámite:</td><td><input type="checkbox" name="tramite" /></td></tr>
			<tr><td>Expedientes en ejecución:</td><td><input type="checkbox" name="ejecucion" /></td></tr>
			<tr><td>Expedientes terminados:</td><td><input type="checkbox" name="terminados" /></td></tr>
			</table>
			<br />
	 		<table align="center" border="1">
			<tr align="center"><td><strong>Elija el orden deseado:</strong></td></tr>
			<tr><td>
			<select name="orden" >
				<option value="a_exp,l_exp,n_exp">Expediente</option>
				<option value="conv">Convenio</option>
				<option value="f_ini">Fecha de inicio</option>
				<option value="f_ter">Fecha de cierre</option>
			</select>
			</td></tr>
			</table> 
		</td>
		<td>
			<table align="center" border="1">
			<tr><td colspan="2">¿Sólo Expedientes de aborígenes? Sí<input type="radio" name="ab" value="si" /> - No<input type="radio" name="ab" value="no" />
			</td></tr>
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
		</td></tr>
		</table>

<br />	<table align="center">
		<tr align="center"><td><input type="submit" name="buscar_paso3" value="Siguiente" /></td></tr>
		</table>
<?	unset($_SESSION["criterio"]); ?>
		</form>
<?	
	} // session criterio muni

	else if ($_POST["buscar_paso3"]) 
	{
		?><br /><?
	
	$ok_estado=false;
	$ok_plan=false;
	
		//////////////// verificar si se tildo algo: incluir solo exptes de aborigenes o no		$_POST["ab"]
		if ($_POST["ab"]=='si')
		{$ab=' and e.aborigen=1'; 
		}
		else 
		{$ab=' ';
		}
		//////////// fin verificar si se tildo aborigen

		//////////////// verifico si se tildo algun estado, o todos
		if (isset($_POST["tramite"]) or (isset($_POST["ejecucion"])) or (isset($_POST["terminados"])))
		{$ok_estado=true;
			if ((isset($_POST["tramite"])) and (isset($_POST["ejecucion"])) and (isset($_POST["terminados"])))
			{$est=" ";}
			else 
			{$est=" and (";
				if (
						((isset($_POST["tramite"]))==false) and 
						((isset($_POST["ejecucion"]))==false) and 
						((isset($_POST["terminados"]))==true)
					)
				{
				$est=$est."e.f_inicio<>0000-00-00 and e.f_termino<>0000-00-00";
				}
				if (
						((isset($_POST["tramite"]))==false) and 
						((isset($_POST["ejecucion"]))==true) and 
						((isset($_POST["terminados"]))==false)
					)
				{
				$est=$est."e.f_inicio<>0000-00-00 and e.f_termino=0000-00-00";
				}
				if (
						((isset($_POST["tramite"]))==false) and 
						((isset($_POST["ejecucion"]))==true) and 
						((isset($_POST["terminados"]))==true)
					)
				{
				$est=$est."e.f_inicio<>0000-00-00";
				}
				if (
						((isset($_POST["tramite"]))==true) and 
						((isset($_POST["ejecucion"]))==false) and 
						((isset($_POST["terminados"]))==false)
					)
				{
				$est=$est."e.f_inicio=0000-00-00 and e.f_termino=0000-00-00";
				}
				if (
						((isset($_POST["tramite"]))==true) and 
						((isset($_POST["ejecucion"]))==false) and 
						((isset($_POST["terminados"]))==true)
					)
				{
				$est=$est."(e.f_inicio=0000-00-00 and e.f_termino=0000-00-00) or 
							(e.f_inicio<>0000-00-00 and e.f_termino<>0000-00-00) ";
				}
				if (
						((isset($_POST["tramite"]))==true) and 
						((isset($_POST["ejecucion"]))==true) and 
						((isset($_POST["terminados"]))==false)
					)
				{
				$est=$est."e.f_inicio=0000-00-00 or e.f_termino=0000-00-00";
				}

				$est=$est.")";
			}
		} 
		else
		{
		echo " <script languaje=javascript>alert ('Debe seleccionar al menos un estado. Recuerde que un expediente puede encontrarse en trámite, en ejecución, o terminado.');</script> ";
		}
		////////////// fin verificar estado
		
		////////////// verificar si se tildo algun plan, o todos
		$opes="(";
		if (isset($_POST["ptodas"]))
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
				$opes=$opes."i.cod_plan=".$p; ?><br /><? echo $opes;?><br /><? 
				}
			}
			$opes=$opes.") ";
		} 
		if (!$ok_plan)
		{ echo " <script languaje=javascript>alert ('Seleccione al menos una Operatoria.');</script> "; 
		}
		////////////// fin verificar plan

		/////////////// verifico si se tildo al menos una operatoria o un estado, realizo la busqueda, sino mando de vuelta a buscar_muni
		if (($ok_plan) and ($ok_estado))
		{
	?> <table align="center" border="1">
				<tr align="center">
				  <TD rowspan="2">EXPEDIENTE</TD>
				  <TD rowspan="2">CONVENIO</TD>
				  <TD rowspan="2">EXTRACTO</TD>
				  <TD colspan="5">DESEMBOLSOS<br />(Fecha de certificaci&oacute;n) </TD>
				  <TD rowspan="2">CANT. DESEMB. </TD>
				  <TD rowspan="2">FECHA DE TERMINO</TD>
				  <TD rowspan="2">MONTO TOTAL</TD>
				  <TD rowspan="2">ESTADO</TD>
				  <TD rowspan="2">OBSERVACIONES</TD>
  </tr>
				<tr align="center"><TD>FECHA DE INICIO<br />1º</TD>
							<TD>2&ordm;</TD>
							<TD>3&ordm;</TD>
							<TD>4&ordm;</TD>
							<TD>5&ordm;</TD>
				</tr>
	<?

			$sql = "select 	e.num_expte as n_exp,
							e.letra_expte as l_exp,
							e.anio_expte as a_exp,
							e.conv as conv,
							e.cant_desem as cant_des,
							e.extracto as extr,
							e.f_inicio as f_ini,
							e.f_termino as f_ter,
							e.monto_total as m_total,
							e.observ as observ
					from	muni m, expte e, incluye i
					where	m.cod_muni=e.cod_muni and
							m.desc_muni='".$_SESSION["muni"]."' and
							e.num_expte=i.num_expte and
							e.letra_expte=i.letra_expte and
							e.anio_expte=i.anio_expte".$est.$ab.$opes."
					group by ".$_POST['orden'].", e.conv
					order by ".$_POST['orden'].", e.conv;";
//			echo "est:".$est."fin est. ab:".$ab."fin ab. opes:".$opes."fin opes";
			$res = mysql_query($sql) or die (mysql_error());
			while ($row= mysql_fetch_array($res))
			{
			?> <TR><TD align="right"><? echo $row["n_exp"]."-".$row["l_exp"]."-".$row["a_exp"]; ?></TD>
			<TD align="center"><? echo $row["conv"]; ?></TD>
			<TD align="left"><? echo $row["extr"]; ?></TD>
			<?	for ($x=1;$x<6;$x++)
				{ ?>	<TD align="right">	<?
				$sql_des="select * from desem where num_expte=".$row["n_exp"]." and
													letra_expte='".$row["l_exp"]."' and
													anio_expte=".$row["a_exp"]." and
													num_des=".$x.";";
				$res_des = mysql_query($sql_des);
				$row_des=mysql_fetch_array($res_des);
					if ($row_des["f_cert"])
					{ 
					echo $row_des["f_cert"];
					} else
					{ echo ""; }
				?> </TD> <?
				} ?>
			<TD align="center"><? echo $row["cant_des"]; ?></TD>
			<TD align="right"><? echo $row["f_ter"]; ?></TD>
			<TD align="right">$ <? echo $row["m_total"]; ?></TD>
			<TD align="left"><? 
				if (($row["f_ini"]<>0000-00-00) and ($row["f_ter"]<>0000-00-00))
				{echo "Terminado";}
				if (($row["f_ini"]==0000-00-00) and ($row["f_ter"]==0000-00-00))
				{echo "En trámite";}
				if (($row["f_ini"]<>0000-00-00) and ($row["f_ter"]==0000-00-00))
				{echo "En ejecución";}
?>			</TD>
			<TD align="left"><? echo $row["observ"]; ?></TD>
			</TR>
	<?		}
		} // (($ok_plan) and ($ok_estado))
		if (($res=false) or (!$ok_estado) or (!$ok_plan))
		{
			if ($res=false)
			{echo " <script languaje=javascript>alert ('La búsqueda no ha producido ningún resultado. Intente nuevamente');</script> ";			}
		$_SESSION["criterio"]='muni';
		echo "<script>window.location.href = \"mostrar_munis_muni.php\"</script>";
		}

	} 	// fin buscar_paso3

	if (($_SESSION["criterio"]='muni') and (!$_POST["buscar_paso3"]))
	{} else {	?> </table>
		<table align="center">
		<tr><td>
		<form method="post" action="mostrar_munis_muni.php" name="menu">
		<? $_SESSION["criterio"]='muni';?>
		<input type="submit" name="wep" value="Iniciar otra búsqueda" />
		</form>
		</td></tr> </table><? 
	}
		

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
