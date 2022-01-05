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
.Estilo1 {font-size: 9px}
body,td,th {
	font-family: Calibri;
}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</script>

<body>
<br />
<?
if (isset($_SESSION["user"]))
{
echo "USUARIO REGISTRADO: ",$_SESSION['user'];
			 if (($_POST["agregar"]) or ($_SESSION["volver"]))
			 {
			 unset($_SESSION["num_expte"]);
			 unset($_SESSION["letra_expte"]);
			 unset($_SESSION["anio_expte"]);
			 unset($_SESSION["conv"]);
			 unset($_SESSION["aborigen"]);
			 unset($_SESSION["cant_desem"]);
			 unset($_SESSION["monto_total"]);
			 unset($_SESSION["extracto"]);
			 unset($_SESSION["observ"]);
			 unset($_SESSION["muni"]);
			 unset($_SESSION["f_inicio"]);
			 unset($_SESSION["f_termino"]);
			 unset($_SESSION["cod_muni"]);
			 unset($_SESSION["techo"]);
			 unset($_SESSION["cerr"]);
			 unset($_SESSION["tipom"]);
			 unset($_SESSION["dig_piso"]);
			 unset($_SESSION["dig_dorm"]);
			 unset($_SESSION["dig_banio"]);
			 unset($_SESSION["dig_aula_sat"]);
			 unset($_SESSION["dig_let_eco"]);
			 unset($_SESSION["dig_let_vent"]);
			 unset($_SESSION["modif"]);
			 unset($_SESSION["n_exp_viejo"]);
 			 unset($_SESSION["l_exp_viejo"]);
			 unset($_SESSION["a_exp_viejo"]);
			 }
	 if (($_POST["agregar"]) or ($_POST["agregar_paso1"]) or ($_POST["agregar_paso2"]) or ($_SESSION["volver"]))
	 { ?><table align="center">
		<tr align="center"><td colspan="2"><strong>CARGA DE EXPEDIENTE</strong></td></tr>
<?	} ?></table>
<?	 if (($_POST["modif_paso3"]) or ($_POST["modif_paso2"]) or ($_POST["modif"]))
	 { ?><table align="center">
		<tr align="center"><td colspan="2"><strong>MODIFICACIÓN DE EXPEDIENTE:</strong></td></tr>
<?	} ?></table>

<?	 if ($_POST["modif"])
	{
$_SESSION["modif"]=1;
$sql_munis = "select * from muni;";
$res_munis = mysql_query($sql_munis) or die (mysql_error());
?>
<form action="agregar.php" name="modif_paso2" method="post">
			<table align="center">
			<tr><td>Expediente Nº: <input type="text" size="1" name="n_exp"/> - 
	Letra: <select name="l_exp">
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
	Año: <input type="text" size="2" name="a_exp"/>.</td></tr>
			<tr align="center"><td><input type="submit" name="modif_paso2" value="Siguiente" /></td></tr>
			</table>
			</form>
<? 	} // modif paso 1

	if (($_POST["modif_paso2"]) or ($_SESSION["volver"]))
	{
		if ((isset($_POST["n_exp"])) and (isset($_POST["l_exp"])) and (isset($_POST["a_exp"])))
		{
		$_SESSION["n_exp_viejo"]=$_POST["n_exp"];
		$_SESSION["l_exp_viejo"]=$_POST["l_exp"];
		$_SESSION["a_exp_viejo"]=$_POST["a_exp"];
		$sql_expte = "select * from expte where 
		num_expte='".$_SESSION["n_exp_viejo"]."' and
		letra_expte='".$_SESSION["l_exp_viejo"]."' and 
		anio_expte='".$_SESSION["a_exp_viejo"]."';";
		$res_expte = mysql_query ($sql_expte) or die (mysql_error());
		$row_expte = mysql_fetch_array($res_expte);
		if ($row_expte)
		{}
		else
		{echo " <script languaje=javascript>alert ('No se ha encontrado ningún expediente.');</script> "; 
					echo "<script>window.location.href = \"menu.php\"</script>";}
		
		$sql_muni = "select * from muni where cod_muni='".$row_expte["cod_muni"]."';";
		$res_muni = mysql_query($sql_muni) or die (mysql_error());
		$row_muni = mysql_fetch_array ($res_muni);
		$muni = $row_muni["desc_muni"];
?>		

<table align="center">
<tr><td colspan="2" align="center"><strong>DATOS ACTUALES DEL EXPEDIENTE</strong></td></tr>
<tr><td>
	<table border="1" align="center">
	<tr align="left"><td>Fecha de Inicio:</td><td align="left">
	<? echo $row_expte["f_inicio"]?></td></tr>
	<tr align="left"><td>Fecha de Término:</td><td align="left">
	<? echo $row_expte["f_termino"]?></td></tr>
	<tr align="left"><td>Municipio:</td>
	<td align="left"><? echo $muni; ?></td></tr>
	<tr align="left"><td>Expediente:</td>
	<td align="left"><? echo $row_expte["num_expte"]."-".$row_expte["letra_expte"]."-".$row_expte["anio_expte"]; ?></td></tr>
	<tr align="left">
	<td>Convenio número:</td>
	<td align="left"><? echo $row_expte["conv"]?></td></tr>
	<td align="left">Aborígen:</td>
	<td><? 
	if ($row_expte["aborigen"]==1)
	{echo " Sí.";}
	else
	{echo " No.";}
	?></td></tr>
	<tr align="left">
	<td>Cantidad de desembolsos:</td>
	<td align="left"><? echo $row_expte["cant_desem"];?></td></tr>
	<tr align="left"><td>Monto Total:</td>
	<td align="left">$ <? echo $row_expte["monto_total"]; ?></td></tr>
	<tr align="left"><td>Extracto:</td>
	<td align="left"><? echo $row_expte["extracto"]; ?></td></tr>
	<tr align="left">
	<td>Observaciones:</td>
	<td align="left"><? echo $row_expte["observ"]; ?></td></tr>
	</table>

</td><td>

<?
$sql_incluye = "select * from incluye where 
				num_expte='".$row_expte["num_expte"]."' and 
				letra_expte='".$row_expte["letra_expte"]."' and
				anio_expte='".$row_expte["anio_expte"]."';";
$res_incluye = mysql_query($sql_incluye) or die (mysql_error());
?>

	<table align="center" border="1">
	
	<tr align="center"><td colspan="2"><strong>OPERATORIAS</strong></td></tr>
	<tr align="left">
	<td>
	<? while ($row_incluye=mysql_fetch_row($res_incluye))
	{ 
		$sql_plan = "select * from plan where cod_plan = '".$row_incluye[0]."';";
		$res_plan = mysql_query ($sql_plan) or die (mysql_error());
		$row_plan = mysql_fetch_array ($res_plan);
		echo $row_plan["desc_plan"].": ".$row_incluye[4];
	?><br />
	<? } /* while del row de incluye */?>
	</td></tr></table>
</td></tr>
</table>


<?
$_SESSION["num_expte"]=$row_expte["num_expte"];
$_SESSION["letra_expte"]=$row_expte["letra_expte"];
$_SESSION["anio_expte"]=$row_expte["anio_expte"];
$_SESSION["conv"]=$row_expte["conv"];
$_SESSION["aborigen"]=$row_expte["aborigen"];
$_SESSION["cant_desem"]=$row_expte["cant_desem"];
$_SESSION["extracto"]=$row_expte["extracto"];
$_SESSION["f_inicio"]=$row_expte["f_inicio"];
$_SESSION["f_termino"]=$row_expte["f_termino"];
$_SESSION["cod_muni"]=$row_expte["cod_muni"];
$_SESSION["monto_total"]=$row_expte["monto_total"];
$_SESSION["observ"]=$row_expte["observ"];
/* $_SESSION["techo"]=
$_SESSION["cerr"]=
$_SESSION["tipom"]=
$_SESSION["dig_piso"]=
$_SESSION["dig_dorm"]=
$_SESSION["dig_banio"]=
$_SESSION["dig_aula_sat"]=
$_SESSION["dig_let_eco"]=
$_SESSION["dig_let_vent"]= */

		} // if del isset de num letra y anio de expte
		else
		{echo " <script languaje=javascript>alert ('Los tres campos son obligatorios.');</script> "; 
					echo "<script>window.location.href = \"menu.php\"</script>";}
	} // modif paso 2
	
	
 if (($_POST["agregar"]) or ($_POST["modif_paso2"]))
 { 
$sql_munis = "select * from muni;";
$res_munis = mysql_query($sql_munis) or die (mysql_error());
?>
	<form action="agregar.php" name="agregar_paso1" method="post">
	<table align="center">
	<tr><td></td></tr>	<tr><td align="left">* Campos obligatorios.</td></tr>
	</table>
<table align="center">
<tr><td>
	<table border="1" align="center">
	<tr align="left"><td>Fecha de Inicio (aaaa/mm/dd):</td><td align="left">
	<input type="text" size="2" name="f_ini_anio" /> /
	<input type="text" size="1" name="f_ini_mes" /> /
	<input type="text" size="1" name="f_ini_dia" /> 


	</td></tr>
	<tr align="left"><td>Fecha de Término (aaaa/mm/dd):</td><td align="left">
	<input type="text" size="2" name="f_ter_anio" /> /
	<input type="text" size="1" name="f_ter_mes" /> / 
	<input type="text" size="1" name="f_ter_dia" /> 
	</td></tr>
	<tr align="left"><td>* Municipio:</td><td align="left">
	<select name="muni">
	<? while ($row_munis = mysql_fetch_row($res_munis))
	{ ?>
		<option value="<? echo $row_munis[1]; ?>"><? echo $row_munis[1]; ?></option>
<?	} /* while */?>
	</select>
	</td></tr>
	<tr align="left"><td>* Expediente:</td><td align="left">
	<input name="num_expte" type="text" size="2" onblur="MM_validateForm('num_expte','','NisNum');return document.MM_returnValue" value="<? if (isset($_SESSION["num_expte"])) echo $_SESSION["num_expte"]; ?>"/> 
	- 
	<select name="letra_expte">
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
	/ 
	<input name="anio_expte" type="text" value="<? if (isset($_SESSION["anio_expte"])) echo $_SESSION["anio_expte"]; ?>" size="1"/></td></tr>
	
	<tr align="left">
	<td>* Convenio número:</td>
	<td align="left"><input name="conv" type="text" value="<? if (isset($_SESSION["conv"])) echo $_SESSION["conv"]; ?>" size="2"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aborígen:<input type="checkbox" name="aborigen" value="<? if (isset($_SESSION["aborigen"])) echo $_SESSION["aborigen"]; ?>"/></td></tr>

	<tr align="left">
	<td>* Cantidad de desembolsos:</td>
	<td align="left">	
	<select name="cant_desem">
		<? for ($d=1;$d<11;$d++)
			{ ?>
			<option value="<? echo $d; ?>"><? echo $d; ?></option>
		<?	}
		?>
	</select>
	</td></tr>

	<tr align="left">
	<td>* Monto Total:</td>
	<td align="left">$ <input name="monto_total" type="text" size="13" value="<? if (isset($_SESSION["monto_total"])) echo $_SESSION["monto_total"]; ?>"/> </td></tr>
	<tr align="left">
	<td>* Extracto:</td>
	<td align="left"><textarea name="extracto" cols="30"><? if (isset($_SESSION["extracto"])) echo $_SESSION["extracto"]; ?></textarea></td></tr>
	
	<tr align="left">
	<td>Observaciones:</td>
	<td align="left"><textarea name="observ" cols="30"><? if (isset($_SESSION["observ"])) echo $_SESSION["observ"]; ?></textarea></td></tr>
	</table>

</td><td>

	<table align="center" border="1">
	
	<tr align="center">
	<td colspan="2"><strong>* OPERATORIAS</strong> (marque al menos una):</td></tr>
	
	<tr align="left">
	<td>Plan Techo:<br />
	Plan Cerramiento:<br />
	Viviendas tipo Misionera:<br /></td>
	<td><input type="checkbox" name="techo" value="<? if (isset($_SESSION["techo"])) echo $_SESSION["techo"]; ?>"/><br />
	<input type="checkbox" name="cerr"  value="<? if (isset($_SESSION["cerr"])) echo $_SESSION["cerr"]; ?>"/><br />
	<input type="checkbox" name="tipom"  value="<? if (isset($_SESSION["tipom"])) echo $_SESSION["tipom"]; ?>"/><br />
</td></tr>
	
	<tr><td colspan="2" align="center">Dignidad Habitacional:</td></tr>
	<tr align="left">
	<td>Piso:<br />
	Dormitorio:<br />
	Baño con lavadero:<br />
	Baño para aula satélite:<br />
	Letrina Ecológica:<br />
	Letrina con ventilación:</td>
	<td><input type="checkbox" name="dig_piso" value="<? if (isset($_SESSION["dig_piso"])) echo $_SESSION["dig_piso"]; ?>"/><br />
	<input type="checkbox" name="dig_dorm"  value="<? if (isset($_SESSION["dig_dorm"])) echo $_SESSION["dig_dorm"]; ?>"/><br />
	<input type="checkbox" name="dig_banio"  value="<? if (isset($_SESSION["dig_banio"])) echo $_SESSION["dig_banio"]; ?>"/><br />
	<input type="checkbox" name="dig_aula_sat"  value="<? if (isset($_SESSION["dig_aula_sat"])) echo $_SESSION["dig_aula_sat"]; ?>"/><br />
	<input type="checkbox" name="dig_let_eco"  value="<? if (isset($_SESSION["dig_let_eco"])) echo $_SESSION["dig_let_eco"]; ?>"/><br />
	<input type="checkbox" name="dig_let_vent"  value="<? if (isset($_SESSION["dig_let_vent"])) echo $_SESSION["dig_let_vent"]; ?>"/></td></tr>
	
	</table>

</td></tr>

<tr align="center">
<td colspan="2">
<? 	if ($_POST["modif_paso2"])
	{ ?>	<input type="submit" name="modif" value="Anterior" />
			<input type="submit" name="agregar_paso1" value="Siguiente" />
			<input type="hidden" name="volver_modif" />
			</td></tr>
<?	}
	else
	{ ?>
<input type="submit" name="agregar_paso1" value="Siguiente" /></td></tr>
<?	} ?>

</table>
	</form>

<? 	
} // if agregar o modif_paso2

if ($_POST["agregar_paso1"])
{ 
	if (
		(($_POST["num_expte"])=='') or 
		(($_POST["letra_expte"])=='') or 
		(($_POST["anio_expte"])=='') or
		(!isset($_POST["num_expte"])) or 
		(!isset($_POST["letra_expte"])) or 
		(!isset($_POST["anio_expte"]))
	   )
		{ echo " <script languaje=javascript>alert ('Debe completar todos los campos de número de expediente.');</script> " ; $cargo_mal=1;
		}
		
		if (validar_fecha($_POST["f_ini_dia"],$_POST["f_ini_mes"],$_POST["f_ini_anio"]))
		{
		$f_ini = $_POST["f_ini_anio"]."-".$_POST["f_ini_mes"]."-".$_POST["f_ini_dia"];
		$f_ini_ok = true;
		}
		else
		{	$f_ter_ok = false; 
			if (fecha_en_blanco($_POST["f_ini_dia"],$_POST["f_ini_mes"],$_POST["f_ini_anio"]))
			{
			$f_ini = '0000-00-00';
			$f_ini_ok = true;
			}
		}


		if (validar_fecha($_POST["f_ter_dia"],$_POST["f_ter_mes"],$_POST["f_ter_anio"]))
		{
		$f_ter = $_POST["f_ter_anio"]."-".$_POST["f_ter_mes"]."-".$_POST["f_ter_dia"];
		$f_ter_ok = true;
		}
		else
		{	$f_ter_ok = false;
			if (fecha_en_blanco($_POST["f_ter_dia"],$_POST["f_ter_mes"],$_POST["f_ter_anio"]))
			{
			$f_ter = '0000-00-00';
			$f_ter_ok = true;
			}
		}

		
		if ((!$f_ini_ok) or (!$f_ter_ok))
		{
			if (!$f_ini_ok)
			{echo " <script languaje=javascript>alert ('Ingrese fecha válida como fecha de inicio.');</script> " ;}
			if (!$f_ter_ok)
			{echo " <script languaje=javascript>alert ('Ingrese fecha válida como fecha de término.');</script> " ;}
		}
		
		if (
		(($_POST["num_expte"])=='') or 
		(($_POST["letra_expte"])=='') or 
		(($_POST["anio_expte"])=='') or
		(!isset($_POST["num_expte"])) or 
		(!isset($_POST["letra_expte"])) or 
		(!isset($_POST["anio_expte"])) or
		(!$f_ini_num) or (!$f_ini_ok) or (!$f_ter_num) or (!$f_ter_ok)
	   )
		{
			if ($_POST["volver_modif"])
			{
	?>		<table align="center">
			<tr><td>
			<form action="agregar.php" method="post" name="agregar">
			<input type="submit" name="modif" value="Volver a Modificar"  />
			</form>
			</td></tr>
			</table>
	<?		}
		}
				
		$ok=true;
		if (is_numeric($_POST["num_expte"]))
		{}
		else
		{$ok=false; 
		$nan="número de expediente, ";}

		if (is_numeric($_POST["anio_expte"]))
		{}
		else
		{$ok=false;
		$nan1="año de expediente, ";
		$nan=$nan.$nan1;}

		if (is_numeric($_POST["conv"]))
		{}
		else
		{$ok=false;
		$nan1="número de convenio, ";
		$nan=$nan.$nan1;}

		if (is_numeric($_POST["monto_total"]))
		{}
		else
		{$ok=false;
		$nan1="monto total, ";
		$nan=$nan.$nan1;}

		if ($ok)
		{}
		else
		{$cargo_mal=1;
		echo " <script languaje=javascript>alert ('En: ".$nan." debe ingresar números enteros.');</script> " ;
		}
		
		if (strlen($_POST["letra_expte"])==1)
		{}
		else
		{ 
		$cargo_mal=1;
		echo "<script languaje=javascript>alert ('En el campo \"Letra de expte\" debe ingresar UNA sola letra .');</script> " ;
		}
	if (   (!isset($_POST["extracto"])) or (($_POST["extracto"])=='')   )
	{ echo " <script languaje=javascript>alert ('El campo \"Extracto\" es obligatorio.');</script> " ;$cargo_mal=1;
	}
	if (   (!isset($_POST["techo"])) and (!isset($_POST["cerr"])) and (!isset($_POST["tipom"])) and (!isset($_POST["dig_aula_sat"]))
	and (!isset($_POST["dig_piso"])) and (!isset($_POST["dig_dorm"])) and (!isset($_POST["dig_banio"])) and (!isset($_POST["dig_let_eco"])) and (!isset($_POST["dig_let_vent"]))   )
	{ echo " <script languaje=javascript>alert ('Debe indicar al menos UNA Operatoria.');</script> " ;$cargo_mal=1;
	}

if (($f_ini_ok) and ($f_ter_ok))
{
	if ($cargo_mal!=1)
	{ 
	?>
<table align="center">
<tr><td valign="top"><form method="post" name="asd" action="agregar.php">
	<table align="center">
	<tr align="left"><td>Fecha de Inicio (aaaa/mm/dd):</td><td align="left"><? echo $f_ini; ?></td></tr>
<?	$_SESSION["f_inicio"]=$f_ini; ?>
	<tr align="left"><td>Fecha de Término (aaaa/mm/dd):</td><td align="left"><? echo $f_ter; ?></td></tr>
<?	$_SESSION["f_termino"]=$f_ter; ?>
	<tr align="left"><td>Municipio:</td><td align="left"><? echo $_POST["muni"]; ?></td></tr>
<?	$_SESSION["muni"]=$_POST["muni"]; ?>
	<tr align="left"><td>Expediente:</td><td align="left"><? echo $_POST["num_expte"]."-".$_POST["letra_expte"]."-".$_POST["anio_expte"]; ?></td></tr>
<?	$_SESSION["num_expte"]=$_POST["num_expte"];
	$_SESSION["letra_expte"]=$_POST["letra_expte"];
	$_SESSION["anio_expte"]=$_POST["anio_expte"]; ?>
	<tr align="left"><td>Convenio:</td><td align="left"><? echo $_POST["conv"]; ?> - Aborigen: 
<?	if (isset($_POST["aborigen"]))  {	echo "Si"; 	} else { echo "No"; }
	$_SESSION["conv"]=$_POST["conv"]; 
	$_SESSION["aborigen"]=$_POST["aborigen"]; 
?>	</td></tr>
	<tr align="left"><td>Cantidad de desembolsos:</td><td align="left"><? echo $_POST["cant_desem"]; ?></td></tr>
	<tr align="left"><td>Monto Total:</td><td align="left">$ <? echo $_POST["monto_total"]; ?></td></tr>
<? $_SESSION["monto_total"]=$_POST["monto_total"]; ?>
	<tr align="left"><td>Extracto:</td><td align="left"><? echo $_POST["extracto"]; ?></td></tr>
<? $_SESSION["extracto"]=$_POST["extracto"]; ?>
	<tr align="left"><td>Observaciones:</td><td align="left"><? echo $_POST["observ"]; ?></td></tr>
<? $_SESSION["observ"]=$_POST["observ"]; ?>
	</table>
<? 
	if (($_POST["agregar_paso1"]) and ($_SESSION["n_exp_viejo"]) and ($_SESSION["l_exp_viejo"]) and ($_SESSION["a_exp_viejo"]))
	{ 
	$sql_des = "select * from desem where 
	num_expte='".$_SESSION["n_exp_viejo"]."' and
	letra_expte='".$_SESSION["l_exp_viejo"]."' and 
	anio_expte='".$_SESSION["a_exp_viejo"]."';";
	$res_des = mysql_query ($sql_des) or die (mysql_error());
?>	<table align="center" border="1">
	<tr><td>
		<table align="center" border="1">
		<tr align="center"><td align="center" colspan="3">DATOS <strong>ACTUALES</strong> DE LOS DESEMBOLSOS</td></tr>
		<tr align="center"><td>Desembolso nº</td><td>Monto</td><td>Fecha de certificación<br />(aaaa/mm/dd)</td></tr>
	<?	while ($row_des = mysql_fetch_array($res_des))
		{ ?>
		<tr align="center"><td><? echo $row_des["num_des"]; ?></td>
			<td><? echo "$ ".$row_des["monto"]; ?></td>
			<td><? echo $row_des["f_cert"]; ?></td></tr>
	<?	}	?>
		</table></td> <?
	}
	$_SESSION["cant_desem"]=$_POST["cant_desem"]; 
	$des=1;
?>	<td>
	<table align="center" border="1">
	<tr align="center"><td align="center" colspan="3">DATOS <strong>NUEVOS</strong> DE LOS DESEMBOLSOS</td></tr>
	<tr align="center"><td>Desembolso nº</td><td>Monto<br />(Obligatorio)</td><td>Fecha de certificación<br />(aaaa/mm/dd)</td></tr>
<?	while ($des<=$_SESSION["cant_desem"])
	{ $var_des = “des”.$des;
	?>
		<tr><td><? echo $des; ?>:</td>
			<td>$ <input type="text" size="5" name="<? echo $var_des;?>" /></td>
			<td><input type="text" size="2" name="<? echo "f_anio".$var_des; ?>" /> /
	<input type="text" size="1" name="<? echo "f_mes".$var_des; ?>" /> /
	<input type="text" size="1" name="<? echo "f_dia".$var_des; ?>" /> </td></tr>
<?		$des++; 
	}

?>	</table></td></tr>
</table>
	<table align="center">

<? 	$_SESSION["techo"]=$_POST["techo"]; 
	$_SESSION["cerr"]=$_POST["cerr"]; 
	$_SESSION["tipom"]=$_POST["tipom"]; 
	$_SESSION["dig_piso"]=$_POST["dig_piso"]; 
	$_SESSION["dig_dorm"]=$_POST["dig_dorm"]; 
	$_SESSION["dig_banio"]=$_POST["dig_banio"]; 
	$_SESSION["dig_aula_sat"]=$_POST["dig_aula_sat"]; 
	$_SESSION["dig_let_eco"]=$_POST["dig_let_eco"]; 
	$_SESSION["dig_let_vent"]=$_POST["dig_let_vent"]; ?>
	
	<td valign="top">
	<table border="1" align="center">
	<tr align="center"><td colspan="2"><strong>INDICAR CANTIDADES:</strong></td></tr>
	<tr><td align="center" colspan="2">Todos los campos son obligatorios.</td></tr>
<? if (isset($_POST["techo"])) 
	{ ?>
		<tr><td align="left">Techos:</td><td><input type="text" name="cant_techo" size="2" /></td></tr>
<?  } 
 if (isset($_POST["cerr"])) 
	{ ?>
		<tr><td align="left">Cerramientos:</td><td><input type="text" name="cant_cerr" size="2" /></td></tr>
<?  } 
 if (isset($_POST["tipom"])) 
	{ ?>
		<tr><td align="left">Viviendas Tipo Misionera:</td><td><input type="text" name="cant_tipom" size="2" /></td></tr>
<?  } 
 if (isset($_POST["dig_piso"])) 
	{ ?>
		<tr><td align="left">Dignidad - Pisos:</td><td><input type="text" name="cant_dig_piso" size="2" /></td></tr>
<?  } 
 if (isset($_POST["dig_dorm"])) 
	{ ?>
		<tr><td align="left">Dignidad - Dormitorios:</td><td><input type="text" name="cant_dig_dorm" size="2" /></td></tr>
<?  } 
 if (isset($_POST["dig_banio"])) 
	{ ?>
		<tr><td align="left">Dignidad - Baños con lavadero:</td><td><input type="text" name="cant_dig_banio" size="2" /></td></tr>
<?  } 
 if (isset($_POST["dig_aula_sat"])) 
	{ ?>
		<tr><td align="left">Núcleos Saniterios para Aula Sat.:</td><td><input type="text" name="cant_dig_aula_sat" size="2" /></td></tr>
<?  } 
 if (isset($_POST["dig_let_eco"])) 
	{ ?>
		<tr><td align="left">Dignidad - Letrina Ecologica:</td><td><input type="text" name="cant_dig_let_eco" size="2" /></td></tr>
<?  } 
 if (isset($_POST["dig_let_vent"])) 
	{ ?>
		<tr><td align="left">Dignidad - Letrina con ventilacion:</td><td><input type="text" name="cant_dig_let_vent" size="2" /></td></tr>
<?  } ?>
	</table>
	</td></tr>
<tr align="center"><td colspan="2">
<? 	// el "volver" en este if no tiene nada q ver con volver en sí, es sólo un swich q usé pa saber si estos datos están agregando o modificando un expte
	if ($_SESSION["modif"])
	{ ?>	<input type="submit" name="modif_paso2" value="Anterior" />
			<input type="hidden" name="volver_modif" />
			<input type="hidden" name="n_exp" value="<? echo $_SESSION["n_exp_viejo"]; ?>"/>
			<input type="hidden" name="l_exp" value="<? echo $_SESSION["l_exp_viejo"]; ?>"/>
			<input type="hidden" name="a_exp" value="<? echo $_SESSION["a_exp_viejo"]; ?>"/>
<?	}
	else
	{ ?>
<input type="submit" name="agregar" value="Anterior" />
<?	} ?>
	
<input type="submit" name="agregar_paso2" value="Siguiente" /></td></tr>	
</table>
</form>
<?	} else if ($cargo_mal==1)
	{ 
		echo "<script>window.location.href = \"menu.php\"</script>";		
	}
} //  if (($f_ini_ok) and ($f_ter_ok))
} //   else if ($_POST["agregar_paso1"])



  else if ($_POST["agregar_paso2"])
{ ?>
<? 

$ok=true;
 if (isset($_POST["cant_techo"])) 
	{ 
		if (is_numeric($_POST["cant_techo"]))
		{
		$cant_techo = $_POST["cant_techo"];
		}
		else
		{
		$ok=false; 
		$nan1="techos, ";
		$nan=$nan.$nan1;
		}
	} 
 if (isset($_POST["cant_cerr"])) 
	{ 
		if (is_numeric($_POST["cant_cerr"]))
		{
		$cant_cerr = $_POST["cant_cerr"];
		}
		else
		{
		$ok=false; 
		$nan1="cerramientos, ";
		$nan=$nan.$nan1;
		}
	} 
 if (isset($_POST["cant_tipom"])) 
	{ 
		if (is_numeric($_POST["cant_tipom"]))
		{
		$cant_tipom = $_POST["cant_tipom"];
		}
		else
		{
		$ok=false; 
		$nan1="viv. tipo misionera, ";
		$nan=$nan.$nan1;
		}
	} 
 if (isset($_POST["cant_dig_piso"])) 
	{ 
		if (is_numeric($_POST["cant_dig_piso"]))
		{
		$cant_dig_piso = $_POST["cant_dig_piso"];
		}
		else
		{
		$ok=false; 
		$nan1="pisos, ";
		$nan=$nan.$nan1;
		}
	} 
 if (isset($_POST["cant_dig_dorm"])) 
	{ 
		if (is_numeric($_POST["cant_dig_dorm"]))
		{
		$cant_dig_dorm = $_POST["cant_dig_dorm"];
		}
		else
		{
		$ok=false; 
		$nan1="dormitorios, ";
		$nan=$nan.$nan1;
		}
	} 
 if (isset($_POST["cant_dig_banio"])) 
	{ 
		if (is_numeric($_POST["cant_dig_banio"]))
		{
		$cant_dig_banio = $_POST["cant_dig_banio"];
		}
		else
		{
		$ok=false; 
		$nan1="baños, ";
		$nan=$nan.$nan1;
		}
	} 
if (isset($_POST["cant_dig_aula_sat"])) 
	{ 
		if (is_numeric($_POST["cant_dig_aula_sat"]))
		{
		$cant_dig_aula_sat = $_POST["cant_dig_aula_sat"];
		}
		else
		{
		$ok=false; 
		$nan1="Bº p/ aula satélite, ";
		$nan=$nan.$nan1;
		}
	} 
 if (isset($_POST["cant_dig_let_eco"])) 
	{ 
		if (is_numeric($_POST["cant_dig_let_eco"]))
		{
		$cant_dig_let_eco = $_POST["cant_dig_let_eco"];
		}
		else
		{
		$ok=false; 
		$nan1="letrina ecológica, ";
		$nan=$nan.$nan1;
		}
	} 
 if (isset($_POST["cant_dig_let_vent"])) 
	{ 
		if (is_numeric($_POST["cant_dig_let_vent"]))
		{
		$cant_dig_let_vent = $_POST["cant_dig_let_vent"];
		}
		else
		{
		$ok=false; 
		$nan1="letrina con ventilación, ";
		$nan=$nan.$nan1;
		}
	} 
	if ($ok)
	{}
	else
	{ 
		if ($nan!="")
		{
		echo " <script languaje=javascript>alert ('Las cantidades de ".$nan." debe rellenar con números enteros.');</script> " ;
		$_SESSION["volver"]=true;
		echo "<script>window.location.href = \"agregar.php\"</script>";
		}
	}

// verif si la suma de los desem es igual al monto total q figura en la tabla expte
$des=1;
$total = 0;
	while ($des<=$_SESSION["cant_desem"])
	{ 
	$var_des = “des”.$des;
	$total = $total+$_POST[$var_des];
	$des++;
	}

if ($total!=$_SESSION["monto_total"])
	{ $ok = false;
	echo " <script languaje=javascript>alert ('La suma de los desembolsos debe coincidir con el monto total de la obra.');</script> " ;
	}

// verifico q no haya otro expte con num, letra y anio iguales, o convenio igual
// la condicion "modif" es para q no largue el msj de conv o exp repetido si es una modificacion
if ($_SESSION["modif"])
{
	// comparo si los num letra y anio del nuevo expte son iguales a los del anterior, si no son: busco duplicado
	if (($_SESSION["n_exp_viejo"]!=$_SESSION["num_expte"]) or 
		($_SESSION["l_exp_viejo"]!=$_SESSION["letra_expte"]) or
		($_SESSION["a_exp_viejo"]!=$_SESSION["anio_expte"]))
	{
	$sql_dup = "select * from expte where
				num_expte='".$_SESSION["num_expte"]."' and
				letra_expte='".$_SESSION["letra_expte"]."' and
				anio_expte='".$_SESSION["anio_expte"]."';";
	$res_dup = mysql_query($sql_dup) or die (mysql_error());
	$row_dup = mysql_fetch_row($res_dup);
	}
	
	// busco el num de conv actual, y ...
	$sql_conv = "select * from expte where
				num_expte='".$_SESSION["n_exp_viejo"]."' and
				letra_expte='".$_SESSION["l_exp_viejo"]."' and
				anio_expte='".$_SESSION["a_exp_viejo"]."';";
	$res_conv = mysql_query($sql_conv) or die (mysql_error());
	$row_conv = mysql_fetch_array($res_conv);
	
	// ... comparo con el num q se quiere poner, si es igual to bien, y si son distintos: busco en la base de datos q no haya otro num de conv igual al q se quiere poner
	if ($row_conv["conv"]!=$_SESSION["conv"])
	{
	$sql_conv_dup = "select * from expte where
				conv=".$_SESSION["conv"].";";
	$res_conv_dup = mysql_query($sql_conv_dup);
	$row_conv_dup = mysql_fetch_row($res_conv_dup);
	}

	if ($row_dup)
	{
	echo " <script languaje=javascript>alert ('Ya existe un expediente con esos datos.');</script> " ; 
	?>
	<table align="center">
	<tr><td>
	<form action="agregar.php" name="agregar" method="post">
	<input type="submit" name="modif" value="Volver a intentar" />
	</form>
	</td></tr>
	</table>
	<? 
	}
	if ($row_conv_dup)
	{
	echo " <script languaje=javascript>alert ('Ya existe un expediente con ese número de convenio.');</script> " ; 
	?>
	<table align="center">
	<tr><td>
	<form action="agregar.php" name="agregar" method="post">
	<input type="submit" name="modif" value="Volver a intentar" />
	</form>
	</td></tr>
	</table>
	<? 
	}
}

if (($ok) and (!$row_conv_dup) and (!$row_dup))
{
	if (isset($_SESSION["aborigen"])) { $aborigen = 1; } else { $aborigen = 0; }
	
// verifico si estos datos q se ingresan son de modificacion de un expte, borro el registro del expte viejo
	if ($_SESSION["modif"])
	{
	$sql_exp_viejo="delete from expte where
					num_expte='".$_SESSION["n_exp_viejo"]."' and
					letra_expte='".$_SESSION["l_exp_viejo"]."' and
					anio_expte='".$_SESSION["a_exp_viejo"]."';";
	$res_exp_viejo= mysql_query($sql_exp_viejo) or die (mysql_error());
	
	$sql_desem_vjo="delete from desem where
					num_expte='".$_SESSION["n_exp_viejo"]."' and
					letra_expte='".$_SESSION["l_exp_viejo"]."' and
					anio_expte='".$_SESSION["a_exp_viejo"]."';";
	$res_desem_vjo= mysql_query($sql_desem_vjo) or die (mysql_error());
	
	$sql_incl_vjo="delete from incluye where
					num_expte='".$_SESSION["n_exp_viejo"]."' and
					letra_expte='".$_SESSION["l_exp_viejo"]."' and
					anio_expte='".$_SESSION["a_exp_viejo"]."';";
	$res_incl_vjo= mysql_query($sql_incl_vjo) or die (mysql_error());
	}


$sql_muni = "select * from muni where desc_muni='".$_SESSION["muni"]."';";
$res_muni = mysql_query($sql_muni) or die (mysql_error());
$row_muni = mysql_fetch_row($res_muni);
$cod_muni = $row_muni[0];
?> <br /> <?
// carga en la tabla EXPTE
$sql = "insert into expte (
	num_expte,
	letra_expte,
	anio_expte,
	conv,
	aborigen,
	cant_desem,
	extracto,
	f_inicio,
	f_termino,
	cod_muni,
	monto_total,
	observ) 
	values (
'".$_SESSION["num_expte"]."',
'".$_SESSION["letra_expte"]."',
'".$_SESSION["anio_expte"]."',
'".$_SESSION["conv"]."',
'".$_SESSION["aborigen"]."',
'".$_SESSION["cant_desem"]."',
'".$_SESSION["extracto"]."',
'".$_SESSION["f_inicio"]."', 
'".$_SESSION["f_termino"]."', 
'".$cod_muni."', 
'".$_SESSION["monto_total"]."',
'".$_SESSION["observ"]."');";

$res = mysql_query($sql) or die (mysql_error());


// carga en la tabla DESEM
$des=1;

	while ($des<=$_SESSION["cant_desem"])
	{ 
	$var_des = “des”.$des;
	$anio = "f_anio".$var_des; 		$mes = "f_mes".$var_des;		$dia = "f_dia".$var_des;
	$fecha = "'".$_POST[$anio]."-".$_POST[$mes]."-".$_POST[$dia]."'";
	echo $fecha;
	$sql = "insert into desem (
	num_expte,
	letra_expte,
	anio_expte,
	num_des,
	monto,
	f_cert)

	values (
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	'".$des."',
	'".$_POST[$var_des]."',
	".$fecha.");";
	$res = mysql_query($sql) or die (mysql_error());
	$des++;
	}

// carga en la tabla UTILIZO

$sql_usu = "select * from usuario where user = '".$_SESSION["user"]."';";
$res_usu = mysql_query($sql_usu) or die (mysql_error());
$row_usu = mysql_fetch_row($res_usu);
$cod_usu = $row_usu[0];

$anio = date("Y"); 
$mes = date("m"); 
$dia = date("d");
$fecha = $anio.$mes.$dia;

$hora = date("H:i:s");

	if ($_SESSION["modif"])
	{$modif=1; $creo=0;
	}else
	{$modif=0; $creo=1;
	}
	
$sql = "insert into utilizo (
	cod_usu,
	num_expte,
	letra_expte,
	anio_expte,
	fecha,
	hora,
	creo,
	modif) 
	values (
'".$cod_usu."',
'".$_SESSION["num_expte"]."',
'".$_SESSION["letra_expte"]."',
'".$_SESSION["anio_expte"]."',
".$fecha.",
'".$hora."',
'".$creo."',
'".$modif."');";
$res = mysql_query($sql) or die (mysql_error());

// carga en la tabla INCLUYE
	if ($cant_techo>0)
	{
	$sql = "insert into incluye
	values (
	1,
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	".$cant_techo."
	);";
	$res = mysql_query($sql) or die (mysql_error());
	}
	
	if ($cant_cerr>0)
	{
	$sql = "insert into incluye
	values (
	2,
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	".$cant_cerr."
	);";
	$res = mysql_query($sql) or die (mysql_error());
	}

	if ($cant_tipom>0)
	{
	$sql = "insert into incluye
	values (
	3,
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	".$cant_tipom."
	);";
	$res = mysql_query($sql) or die (mysql_error());
	}

	if ($cant_dig_piso>0)
	{
	$sql = "insert into incluye
	values (
	4,
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	".$cant_dig_piso."
	);";
	$res = mysql_query($sql) or die (mysql_error());
	}

	if ($cant_dig_dorm>0)
	{
	$sql = "insert into incluye
	values (
	5,
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	".$cant_dig_dorm."
	);";
	$res = mysql_query($sql) or die (mysql_error());
	}

	if ($cant_dig_banio>0)
	{
	$sql = "insert into incluye
	values (
	6,
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	".$cant_dig_banio."
	);";
	$res = mysql_query($sql) or die (mysql_error());
	}

	if ($cant_dig_aula_sat>0)
	{
	$sql = "insert into incluye
	values (
	7,
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	".$cant_dig_aula_sat."
	);";
	$res = mysql_query($sql) or die (mysql_error());
	}

	if ($cant_dig_let_eco>0)
	{
	$sql = "insert into incluye
	values (
	8,
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	".$cant_dig_let_eco."
	);";
	$res = mysql_query($sql) or die (mysql_error());
	}

	if ($cant_dig_let_vent>0)
	{
	$sql = "insert into incluye
	values (
	9,
	'".$_SESSION["num_expte"]."',
	'".$_SESSION["letra_expte"]."',
	'".$_SESSION["anio_expte"]."',
	".$cant_dig_let_vent."
	);";
	$res = mysql_query($sql) or die (mysql_error());
	}


unset($_SESSION["num_expte"]);
unset($_SESSION["letra_expte"]);
unset($_SESSION["anio_expte"]);
unset($_SESSION["conv"]);
unset($_SESSION["aborigen"]);
unset($_SESSION["cant_desem"]);
unset($_SESSION["monto_total"]);
unset($_SESSION["extracto"]);
unset($_SESSION["observ"]);
unset($_SESSION["muni"]);
unset($_SESSION["f_inicio"]);
unset($_SESSION["f_termino"]);
unset($_SESSION["cod_muni"]);
unset($_SESSION["techo"]);
unset($_SESSION["cerr"]);
unset($_SESSION["tipom"]);
unset($_SESSION["dig_piso"]);
unset($_SESSION["dig_dorm"]);
unset($_SESSION["dig_banio"]);
unset($_SESSION["dig_aula_sat"]);
unset($_SESSION["dig_let_eco"]);
unset($_SESSION["dig_let_vent"]);

if ($res) 
{
	if ($_SESSION["modif"])
	{
	echo " <script languaje=javascript>alert ('La modificación del expediente se ha realizado con éxito.');</script> " ; 
	}
	else
	{
	echo " <script languaje=javascript>alert ('La carga del expediente se ha realizado con éxito.');</script> " ;
	}
	echo "<script>window.location.href = \"menu.php\"</script>";
			
} 
else 
{
	echo " <script languaje=javascript>alert ('La carga del expediente no se ha podido realizar.');</script> " ;
	echo "<script>window.location.href = \"menu.php\"</script>";
}

} //   else if ($_POST["agregar_paso2"])
} //   if ($ok)
?>
<table align="center">
<tr><td>
<form method="post" action="menu.php" name="menu">
<input type="submit" name="menu" value="Volver al Menu" />
</form>
</td></tr>
</table>
<?  } else { echo " <script languaje=javascript>alert ('Usuario no identificado.');</script> "; 
			echo "<script>window.location.href = \"index.php\"</script>";}
	?>
</body>
</html>
