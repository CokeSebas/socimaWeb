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
    
 
    //Noticias
    $SqlNoticia = "select * from Mv_Noticias";
    $Resultado =  mysqli_query($vConex,$SqlNoticia);
    while($Row =  mysqli_fetch_object($Resultado))
    {
        $Noticia['Titulo'] = str_replace("'","",utf8_encode($Row->titulo));
        $Noticia['Noticia'] = str_replace("'","",utf8_encode($Row->noticia));
        $Noticia['Imagen'] = str_replace("'","",utf8_encode($Row->Imagen));


        	$Datos['Noticia'][] = $Noticia;

    }
    
    $SqlBanner =  "Select * from Mv_Banner";
    $Resultado =  mysqli_query($vConex,$SqlBanner); 
     while($Row =  mysqli_fetch_object($Resultado))
    {
        $Noticias['BannerId'] = str_replace("'","",utf8_encode($Row->BannerId));
        $Noticias['Url'] = str_replace("'","",utf8_encode($Row->Url));
        $Noticias['Informacion'] = str_replace("'","",utf8_encode($Row->Informacion));


        	$Datos['Banner'][] = $Noticias;

    }
}
 echo json_encode($Datos);