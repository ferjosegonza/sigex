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
	{ 
	?><br /><? echo "USUARIO REGISTRADO: ",$_SESSION['user'];
	
		if (($_POST["cambiar_clave"]) or ($_SESSION["cambiar"]))
		{	
		$sql_usu = "select * from usuario where user = '".$_SESSION["user"]."';";
		$res_usu = mysql_query($sql_usu) or die (mysql_error());
		$row_usu = mysql_fetch_array($res_usu);

		?>
		<form name="wep" action="usuarios_clave.php" method="post">
		<input type="hidden" name="pass_viejo" value="<? echo $row_usu["pass"]; ?>" />
		<input type="hidden" name="cod_usu" value="<? echo $row_usu["cod_usu"]; ?>" />
		<table align="center">
		<tr><td colspan="2" align="center"><strong>DATOS DEL USUARIO</strong></td></tr>
		<tr><td align="right">Nombre:</td><td align="left"><? echo $row_usu["nombre"]; ?></td></tr>
		<tr><td align="right">Usuario:</td><td align="left"><? echo $row_usu["user"]; ?></td></tr>
		<tr><td align="right">Contraseña actual:</td><td align="left"><input type="password" name="pass_viejo" /></td></tr>
		<tr><td align="right">Contraseña nueva (de 4 a 8 caracteres):</td><td align="left"><input type="password" name="pass_new1" /></td></tr>
		<tr><td align="right">Vuelva a escribir la contraseña nueva:</td><td align="left"><input type="password" name="pass_new2" /></td></tr>
		<tr align="center"><td colspan="2"><input type="submit" name="cambiar_clave_paso2" value="Siguiente" /></td></tr>
		</table>
		</form>
<? 		unset($_SESSION["cambiar"]);
		}	// fin cambiar_clave

		if ($_POST["cambiar_clave_paso2"])
		{	?> <form name="asd" action="usuarios_clave.php" method="post"> <?
			if (
				($_POST["pass_viejo"]) and
				($_POST["pass_new1"]) and
				($_POST["pass_new2"]) 
				)
			{
				$sql_viejo = "select * from usuario
								where cod_usu=".$_POST["cod_usu"]." and
								pass='".$_POST["pass_viejo"]."';";
				$res_viejo = mysql_query($sql_viejo) or die (mysql_error());
				$row_viejo = mysql_fetch_array($res_viejo);
				if ($row_viejo["pass"]!=$_POST["pass_viejo"])
				{
					echo "<script languaje=javascript>alert ('La contraseña actual no es válida. Si olvidó su contraseña contáctese con el administrador.');</script> " ;
					echo "<script>window.location.href = \"index.php\"</script>";
				}
				else
				{
					if (
						((strlen($_POST["pass_new1"])>3) and (strlen($_POST["pass_new1"])<9)) or
						((strlen($_POST["pass_new2"])>3) and (strlen($_POST["pass_new2"])<9))
						)
					{}
					else if (($_POST["pass_new1"])==($_POST["pass_new2"]))
					{$volver = true;
					echo "<script languaje=javascript>alert ('La contraseña nueva debe tener entre 4 y 8 caracteres.');</script> " ;
					}
					else if (($_POST["pass_new1"])!=($_POST["pass_new2"]))
					{$volver = true;
					echo "<script languaje=javascript>alert ('La contraseña nueva debe tener entre 4 y 8 caracteres, y debe coincidir con su confirmación.');</script> " ;
					}
					if (
						(strlen($_POST["pass_new1"])>3) and (strlen($_POST["pass_new1"])<9) and
						(strlen($_POST["pass_new2"])>3) and (strlen($_POST["pass_new2"])<9) and
						(($_POST["pass_new1"])!=($_POST["pass_new2"]))
						)
					{$volver = true;
					echo "<script languaje=javascript>alert ('La contraseña nueva y su confirmación deben coincidir.');</script> " ;
					}
					if (($_POST["pass_viejo"])==($_POST["pass_new1"]))
					{$volver = true;
					echo "<script languaje=javascript>alert ('La contraseña anterior y la nueva no deben coincidir.');</script> " ;
					}
					if (
						(strlen($_POST["pass_new1"])>3) and (strlen($_POST["pass_new1"])<9) and
						(strlen($_POST["pass_new2"])>3) and (strlen($_POST["pass_new2"])<9) and
						(($_POST["pass_new1"])==($_POST["pass_new2"])) and 
						(($_POST["pass_viejo"])!=($_POST["pass_new1"]))
						)
					{
						$sql_pass = "update usuario set pass='".$_POST["pass_new1"]."' 
									where cod_usu='".$_POST["cod_usu"]."';";
						$res_pass = mysql_query($sql_pass) or die (mysql_error());
						if ($res_pass)
						{
						echo "<script languaje=javascript>alert ('La contraseña se ha cambiado.');</script> " ;
						echo "<script>window.location.href = \"menu.php\"</script>";
						}
						else
						{$volver = true;
						echo "<script languaje=javascript>alert ('El cambio no se ha podido realizar, intente nuevamente.');</script> " ;
						}
					}
				}
			}
			else
			{	
				$volver = true;
				echo "<script languaje=javascript>alert ('Datos no válidos, ingrese nuevamente.');</script> " ;
			}
			if ($volver)
			{	$_SESSION["cambiar"]=true;
				echo "<script>window.location.href = \"usuarios_clave.php\"</script>";
			}
		?>	</form>
<? 		}	// fin cambiar_clave_paso2
		

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
