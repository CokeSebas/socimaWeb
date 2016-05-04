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
    
    // Vendedor
    $SqlVendedores = "Select Codigo_vendedor, Nombre, email, usuario, clave, MM ,Cargo, totalActual, localidad, estado from Mv_Vendedores;";
    $Resultado =  mysqli_query($vConex,$SqlVendedores);

    while($Row =  mysqli_fetch_object($Resultado))
    {   $Usuario['CodigoVendedor'] = $Row->Codigo_vendedor;
        $Usuario['Nombre'] = utf8_encode($Row->Nombre);
        $Usuario['Email'] = utf8_encode($Row->email);
        $Usuario['Usuario'] = utf8_encode($Row->usuario);
        $Usuario['Clave'] = utf8_encode($Row->clave);
        $Usuario['Meta'] = $Row->MM;
        $Usuario['Cargo'] = $Row->Cargo;
		$Usuario['Actual'] = $Row->totalActual;
		$Usuario['Localidad'] = $Row->localidad;
		$Usuario['Estado'] = $Row->estado;


         $Datos['Vendedor'][] = $Usuario;
    }

}
 echo json_encode($Datos);