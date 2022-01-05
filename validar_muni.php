<?php
session_start();
include ('conexion.php');
conectar();

if (conectar())
{
	$muni=$_POST["muni"];
	$pass=$_POST["pass"];
	$sql="select * from muni where desc_muni='$muni' and pass='$pass';";
	$res=mysql_query($sql) or die (mysql_error());
	if (mysql_num_rows($res)>0)
	{
		$dato = mysql_fetch_array($res);
		session_start();
		$_SESSION['usuario_autentificado'] = TRUE;
		$_SESSION['muni'] = $dato["desc_muni"];//declaramos una variable de tipo sesion
		$_SESSION['pass'] = $dato["pass"];	
		$r=session_id();
//		session_register($_SESSION);
	}
	else
	{
		$_SESSION['usuario_autentificado'] = FALSE;
		unset ($_SESSION['muni']);
		unset ($_SESSION['pass']);
		echo "<script languaje=javascript> alert (\"Usuario o Contraseña incorrecta\")</script>";
		echo "<script>window.location.href = \"munis.php\"</script>";
	}
	
	if ($_SESSION['usuario_autentificado'])
	{
	echo "<script>window.location.href = \"menu_muni.php\"</script>";
	}
}
else 
{ 
	echo " <script languaje=javascript>alert ('No pudo conectarse a la base de datos.');</script> "; 
	echo "<script>window.location.href = \"munis.php\"</script>";
}
?>
</body>
</html>
