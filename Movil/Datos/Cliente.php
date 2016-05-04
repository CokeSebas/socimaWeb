<?php
include('Config.php');
$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
$Datos = array();
$Cliente=  array();
if (mysqli_connect_errno())
{
    $Extras['vConex'] = 0;
    $Datos['Estado'][] = $Extras;
}
else
{
    //Existe Conexion con la base de datos
    $Extras['vConex'] = 1;
    
    // Cliente
    $SqlCliente = "select customer_id, firstname,email,telephone,salesrep_id,credito,address_1,city,name,codec, lastname, CreditoMaximo from Mv_Clientes";
    $Resultado =  mysqli_query($vConex,$SqlCliente);

    while($Row =  mysqli_fetch_object($Resultado))
    {   $Cliente['CodigoCliente'] = $Row->customer_id;
        $Cliente['Nombre'] = str_replace("'","",utf8_encode($Row->firstname));
        $Cliente['Email'] = utf8_encode($Row->email);
        $Cliente['Telefono'] = $Row->telephone;
        $Cliente['Vendedor'] = $Row->salesrep_id;
        $Cliente['Credito'] = $Row->credito;
        $Cliente['Direccion'] = str_replace("'","",utf8_encode($Row->address_1));
        $Cliente['Ciudad'] = str_replace("'","",utf8_encode($Row->city));
        $Cliente['Region'] = str_replace("'","",utf8_encode($Row->name));
        $Cliente['Codigo'] = utf8_encode($Row->codec);
        $Cliente['Rut']    = $Row->lastname;
		$Cliente['CreditoMaximo'] = $Row->CreditoMaximo;
		$Datos['Cliente'][] = $Cliente;
		
    }

}
 echo json_encode($Datos);
 ?>