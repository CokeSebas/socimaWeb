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
    
 //Estado
    $SqlEstado = "select * from Mv_Estado";
    $Resultado =  mysqli_query($vConex,$SqlEstado);

    while($Row =  mysqli_fetch_object($Resultado))
    {
        $Estado['idEstado'] = $Row->Estado_id;
        $Estado['Estado'] = str_replace("'","",utf8_encode($Row->Estado));

            $Datos['Estados'][] = $Estado;

    }
}
 echo json_encode($Datos);