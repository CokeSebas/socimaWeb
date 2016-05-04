<?php
include('Config.php');
$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
$Datos = array();
if (mysqli_connect_errno())
{
    $Extras['vConex'] = 0;
    $Datos['Estado'][] = $Extras;
	
}
else
{

    //Existe Conexion con la base de datos
    $Extras['vConex'] = 1;
    
    // Marca
    $SqlMarcas = "SELECT `marca_id`, `nombre` FROM `Mv_Marca`;";
    $Resultado =  mysqli_query($vConex,$SqlMarcas);

    while($Row =  mysqli_fetch_object($Resultado)){   
		$Marca['marca_id'] = $Row->marca_id;
		$Marca['nombre'] = $Row->nombre;
        $Datos['Marca'][] = $Marca;
    }
}
 echo json_encode($Datos);