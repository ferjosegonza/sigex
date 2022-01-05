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
<title>SIGEX - Sistema de Gestión de Expedientes.</title></head>

<body>
<? 	if ($_SESSION['usuario_autentificado'])
	{ ?><br /><?
	echo "USUARIO REGISTRADO: ",$_SESSION['user'];
	
		if ($_POST["seg_paso1"])
		{	?>
		<form name="seg_paso2" action="usuarios_seg.php" method="post">
		<table align="center">
		<tr><td colspan="2"><strong>REALIZAR SEGUIMIENTO POR:</strong></td></tr>
		<tr><td align="right">Expediente:</td><td align="left"><input type="radio" name="expous" value="exp" /></td></tr>
		<tr><td align="right">Usuario:</td><td align="left"><input type="radio" name="expous" value="user" /></td></tr>
		<tr align="center"><td colspan="2"><input type="submit" name="seg_paso2" value="Siguiente" /></td></tr>
		</table>
		</form>
<? 		}	// seg_paso1

		if (($_POST["seg_paso2"]) or ($_SESSION["volver_expte"]))
		{	?>
		<form name="seg_paso3" action="usuarios_seg.php" method="post">
		<table align="center">

<?			if (($_POST["expous"]=="exp") or ($_SESSION["volver_expte"]))
			{ $_SESSION["volver_expte"]=false;
			?>
			<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			<tr align="center"><td colspan="2"><strong>Ingrese datos del Expediente</strong> (obligatorio)</td></tr>
			<tr><td colspan="2">Expediente Nº: <input type="text" size="1" name="n_exp"/> - 
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
<?			}

			if ($_POST["expous"]=="user")
			{
?>			<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			<tr><td colspan="2">¿Que <strong>Usuario</strong> desea listar? <select name="user"><?
			$sql_user = "select * from usuario;";
			$res_user = mysql_query($sql_user) or die (mysql_error());
				while ($row = mysql_fetch_array($res_user))
				{ ?>
					<option value="<? echo $row["cod_usu"]; ?>" ><? echo $row["nombre"]; ?></option>
		<?		}
		?>			<option value="todos">Todos</option>
			</select></td></tr>
<?			}	
?>			<tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
			<tr align="center"><td colspan="2">Filtrar por <strong>fechas </strong>(no es obligatorio):</td></tr>
			<tr align="left"><td>Desde (aaaa/mm/dd):</td><td align="left">
			<input type="text" size="2" name="f_a_desde" /> /
			<input type="text" size="1" name="f_m_desde" /> /
			<input type="text" size="1" name="f_d_desde" /> </td></tr>
			<tr><td>Hasta (aaaa/mm/dd):</td><td align="left">
			<input type="text" size="2" name="f_a_hasta" /> /
			<input type="text" size="1" name="f_m_hasta" /> /
			<input type="text" size="1" name="f_d_hasta" /> 
			</td></tr>
			<tr align="center"><td colspan="2"><input type="submit" name="seg_paso1" value="Anterior" />
									<input type="submit" name="seg_paso3" value="Siguiente" /></td></tr>
		</form>
<? 		}	// seg_paso2
		
		if ($_POST["seg_paso3"])
		{
			// pregunto si num o anio de expte vienen vacios, si es asi, mando de vuelta
			if (	((isset($_POST["n_exp"])) and (isset($_POST["a_exp"]))) and 
				((($_POST["n_exp"])=="") or (($_POST["a_exp"])==""))
				)
			{
			echo " <script languaje=javascript>alert ('Debe completar todos los campos de número de expediente.');</script> " ; 
			$_SESSION["volver_expte"]=true;
			echo "<script>window.location.href = \"usuarios_seg.php\"</script>";
			}
			
			// pregunto si vieron fechas, si es asi: lo agrego en una variable que concateno en la consulta, si no, 
			// en esa misma variable la cargo con ""
			if (validar_fecha($_POST["f_d_desde"],$_POST["f_m_desde"],$_POST["f_a_desde"]))
			{
			$f_desde=$_POST["f_a_desde"]."-".$_POST["f_m_desde"]."-".$_POST["f_d_desde"];
			}
			else { $f_desde="0000-00-00"; }
			
			if (validar_fecha($_POST["f_d_hasta"],$_POST["f_m_hasta"],$_POST["f_a_hasta"]))
			{
			$f_hasta=$_POST["f_a_hasta"]."-".$_POST["f_m_hasta"]."-".$_POST["f_d_hasta"];
			}
			else { $f_hasta="2050-12-31"; }
		
			if ($_POST["user"])
			{
				if (($_POST["user"])=="todos")
				{	$titulo = " TODOS LOS USUARIOS";
					$sql_seg = "select ut.num_expte as num_expte,
								ut.letra_expte as letra_expte,
								ut.anio_expte as anio_expte,
								ut.fecha as fecha,
								ut.hora as hora,
								ut.creo as creo,
								ut.modif as modif,
								ut.borro as borro,
								us.nombre as nombre
						from	utilizo ut, usuario us
						where 	ut.cod_usu = us.cod_usu and
								ut.fecha >= '".$f_desde."' and
								ut.fecha <= '".$f_hasta."'
						order by fecha, hora;";
				} 
				else // si es seg de 1 usuario
				{	$titulo = "L USUARIO: ".$_POST["user"];
					$sql_seg = "select ut.num_expte as num_expte,
								ut.letra_expte as letra_expte,
								ut.anio_expte as anio_expte,
								ut.fecha as fecha,
								ut.hora as hora,
								ut.creo as creo,
								ut.modif as modif,
								ut.borro as borro,
								us.nombre as nombre
						from	utilizo ut, usuario us
						where	us.cod_usu = '".$_POST["user"]."' and
								ut.cod_usu = us.cod_usu and
								ut.fecha >= '".$f_desde."' and
								ut.fecha <= '".$f_hasta."'
						order by fecha, hora;";
				}
			}  // if post user

			// si busca x expte
			else if (($_POST["n_exp"]) and ($_POST["l_exp"]) and ($_POST["a_exp"]))
			{
				if (
					(($_POST["n_exp"])=='') or 
					(($_POST["l_exp"])=='') or 
					(($_POST["a_exp"])=='') or
					(!isset($_POST["n_exp"])) or 
					(!isset($_POST["l_exp"])) or 
					(!isset($_POST["a_exp"]))
				   )
				{ echo " <script languaje=javascript>alert ('Debe completar todos los campos de número de expediente.');</script> " ; $cargo_mal=1;
				echo "<script>window.location.href = \"menu.php\"</script>";
				}
				else
				{
					$ok=true;
					if (is_numeric($_POST["n_exp"]))
					{}
						else
					{$ok=false; 
					$nan="número de expediente, ";}

					if (is_numeric($_POST["a_exp"]))
					{}
					else
					{$ok=false;
					$nan1="año de expediente, ";
					$nan=$nan.$nan1;}
			
					if ($ok)
					{}
					else
					{$cargo_mal=1;
					echo " <script languaje=javascript>alert ('En: ".$nan." debe ingresar números enteros.');</script> " ;
					}
				}
				if ($cargo_mal==1)
				{ 
				echo "<script>window.location.href = \"menu.php\"</script>";		
				}
				else
				{
					$titulo = "L EXPEDIENTE: ".$_POST["n_exp"]."-".$_POST["l_exp"]."-".$_POST["a_exp"];
					$sql_seg = "select ut.num_expte as num_expte,
								ut.letra_expte as letra_expte,
								ut.anio_expte as anio_expte,
								ut.fecha as fecha,
								ut.hora as hora,
								ut.creo as creo,
								ut.modif as modif,
								ut.borro as borro,
								us.nombre as nombre
						from	utilizo ut, usuario us
						where	num_expte = '".$_POST["n_exp"]."' and
								letra_expte = '".$_POST["l_exp"]."' and
								anio_expte = '".$_POST["a_exp"]."' and
								ut.cod_usu = us.cod_usu and
								ut.fecha >= '".$f_desde."' and
								ut.fecha <= '".$f_hasta."'
						order by fecha, hora;";
				}
			}  // else busca x expte
			
			$res_seg = mysql_query($sql_seg) or die (mysql_error());
			
			if ($row_seg=mysql_fetch_row($res_seg))
			{
				
?>				<table align="center">
				<tr align="center"><td><p>&nbsp;</p>
				  <p><strong>SEGUIMIENTO DE<? echo $titulo; ?></strong></p>
				  <p>&nbsp;</p></td></tr>
				</table>
				<table align="center" border="1">
				<tr><td><strong>FECHA</strong></td>
				<td><strong>HORA</strong></td>
				<td><strong>EXPEDIENTE</strong></td>
				<td><strong>USUARIO</strong></td>
				<td><strong>ACCIÓN</strong></td></tr>

<?				while ($row_seg = mysql_fetch_array($res_seg))
				{	?>
				<tr><td><? echo $row_seg["fecha"]; ?></td>
				<td><? echo $row_seg["hora"]; ?></td>
				<td><? echo $row_seg["num_expte"]."-".$row_seg["letra_expte"]."-".$row_seg["anio_expte"]; ?></td>
				<td><? echo $row_seg["nombre"]; ?></td>
				<td><? if ($row_seg["creo"]==1) echo "Creó"; 
				if ($row_seg["modif"]==1) echo "Modificó"; 
				if ($row_seg["borro"]==1) echo "Borró"; ?></td></tr>
<?				}
?>				</table>
<?			}
			else 
			{ echo " <script languaje=javascript>alert ('La búsqueda no produjo ningún resultado.');</script> " ;
			echo "<script>window.location.href = \"menu.php\"</script>";
			}
		}  // seg_paso3
?>
<table align="center">
<tr><td>
<form method="post" name="volver" action="menu.php">
<input type="submit" name="menu" value="Volver al Menú" />
</form>
</td></tr></table>
<?	} 
	else 
	{ 
	echo " <script languaje=javascript>alert ('Ingrese con Usuario y Contraseña.');</script> "; 
	echo "<script>window.location.href = \"index.php\"</script>";
	}?>

</body>
</html>
