<?php
date_default_timezone_set('America/Buenos_Aires');

function fecha()
{
$anio = date("Y"); 
$mes = date("m"); 
$solo_fecha = date("d"); 
echo "Hoy es ".$solo_fecha."-".$mes."-".$anio;
}

function validar_fecha($dia, $mes, $anio)
{
	$resp = false;
	$anio_actual = date("Y");
	$anio_min = $anio_actual - 7;
	$anio_max = $anio_actual + 7;
	
	if (is_numeric($dia))
	{
		if (is_numeric($mes))
		{
			if (is_numeric($anio))
			{
				if (($anio>=$anio_min) and ($anio<=$anio_max))
				{
					if (($mes>=1) and ($mes<=12))
					{
						if (($mes==1) or ($mes==3) or ($mes==5) or ($mes==7) or ($mes==8) or ($mes==10) or ($mes==12))
						{
							if (($dia>=1) and ($dia<=31))
							{
							$resp = true;
							}
						}
						else
						if (($mes==4) or ($mes==6) or ($mes==9) or ($mes==11))
						{
							if (($dia>=1) and ($dia<=30))
							{
							$resp = true;
							}
						}
						if ($mes==2)
						{
							if (($anio==2012) or ($anio==2008) or ($anio==2016))
							{
								if (($dia>=1) and ($dia<=29))
								{
								$resp = true;
								}
							}
							else 
							{
								if (($dia>=1) and ($dia<=28))
								{
								$resp = true;
								}
							}
						}
					}
				}
			}
		}
	}
return $resp;
}

function fecha_en_blanco($dia, $mes, $anio)
{ $resp=false;
		if (
			($dia=="") or 
			($mes=="") or 
			($anio==""))
		{$resp=true;
		}
return $resp;
}
?>

