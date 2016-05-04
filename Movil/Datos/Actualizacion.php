<?php
include('Config.php');
$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
$Datos = array();
$Noticias = array();
if (mysqli_connect_errno())
{
    $Extras['vConex'] = 0;
    $Datos['Estado'][] = $Extras;
}
else
{
    //Existe Conexion con la base de datos
    $Extras['vConex'] = 1;
    
 
    //Noticias
    $SqlNoticia = "select Ver, Nombre from Mv_db";
    $Resultado =  mysqli_query($vConex,$SqlNoticia);
    while($Row =  mysqli_fetch_object($Resultado))
    {
        $Noticia[$Row->Nombre] = $Row->Ver;
        
    }
    $Datos['Actualizaciones'][] = $Noticia;
    
}
 echo json_encode($Datos);