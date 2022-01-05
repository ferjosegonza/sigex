<?php
session_start();
include ('conexion.php');
conectar();

if (conectar())
{
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$sql = "select * from usuario where user='$user' and pass='$pass'";
	$res = mysql_query($sql);
	if (mysql_num_rows($res)>0)
	{
		$dato = mysql_fetch_array($res);
		$_SESSION['usuario_autentificado'] = TRUE;
		$_SESSION['user'] = $dato["user"];//declaramos una variable de tipo sesion
		$_SESSION['pass'] = $dato["pass"];	
		$r=session_id();
		echo $r=session_id();
//		session_register($_SESSION);
	}
	else
	{
		$_SESSION['usuario_autentificado'] = FALSE;
		unset ($_SESSION['user']);
		unset ($_SESSION['pass']);
		echo "<script languaje=javascript> alert (\"Usuario o Contraseña incorrecta\")</script>";
		echo "<script>window.location.href = \"index.php\"</script>";
	}
	
	if ($_SESSION['usuario_autentificado'])
	{
	echo "<script>window.location.href = \"menu.php\"</script>";
	}
} 
else 
{ 
	echo " <script languaje=javascript>alert ('No pudo conectarse a la base de datos.');</script> "; 
	echo "<script>window.location.href = \"index.php\"</script>";
}
?>
</body>
</html>
