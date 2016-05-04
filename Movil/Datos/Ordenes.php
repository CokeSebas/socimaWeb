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
    

    $SqlDetalleOrden = "select * from Mv_DetalleOrden";
    $Resultado =  mysqli_query($vConex,$SqlDetalleOrden);

    while($Row =  mysqli_fetch_object($Resultado))
    {
        $DetalleOrden['idOrden'] = $Row->Orden_id;
        $DetalleOrden['idProducto'] = $Row->Producto_id;
        $DetalleOrden['Cantidad'] = $Row->Cantidad;
        $DetalleOrden['Precio'] = $Row->Precio;
        $DetalleOrden['Total'] = $Row->Total;


          $Datos['DetalleOrden'][] = $DetalleOrden;

    }
    
     $SqlOrden= "select * from Mv_Orden";
    $Resultado =  mysqli_query($vConex,$SqlOrden);
    while($Row =  mysqli_fetch_object($Resultado))
    {

        $Orden['idOrden'] = $Row->Orden_id;
        $Orden['Codigo'] = str_replace("'","",utf8_encode($Row->Codigo_orden));
        $Orden['idCliente'] = $Row->Cliente_id;
        $Orden['DireccionP'] = str_replace("'","",utf8_encode($Row->Direccion_pago));
        $Orden['CiudadPago'] = str_replace("'","",utf8_encode($Row->Ciudad_pago));
        $Orden['Region'] = str_replace("'","",utf8_encode($Row->Nombre_region));
        $Orden['TipoPago'] = str_replace("'","",utf8_encode($Row->Tipo_pago));
        $Orden['Total'] = $Row->Total;
        $Orden['Estado'] = $Row->Estado;
        $Orden['Vendedor'] = $Row->Vendedor;
        $Orden['FFI'] = str_replace("'","",utf8_encode($Row->Fecha_ingreso));
        $Orden['FFM'] = str_replace("'","",utf8_encode($Row->Fecha_modificada));

        	$Datos['Orden'][] = $Orden;

    }
}
 echo json_encode($Datos);






