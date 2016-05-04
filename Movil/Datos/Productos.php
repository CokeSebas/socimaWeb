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
    
 //Producto
    $SqlProducto = "select * from Mv_Productos";
    $Resultado =  mysqli_query($vConex,$SqlProducto);
    while($Row =  mysqli_fetch_object($Resultado))
    {


        $Producto['idProducto'] = $Row->Codigo_producto;
        $Producto['Modelo'] = str_replace("'","",utf8_encode($Row->Modelo));
        $Producto['Descripcion'] = str_replace("'","",utf8_encode($Row->Descripcion));
        $Producto['CodigoProducto'] = $Row->Codigo;
            $Producto['CodigoBodega'] = str_replace("'","",utf8_encode($Row->Codigo_bodega));
            $Producto['StockInicial'] = $Row->Stock_inicial;
            $Producto['Cantidad'] = $Row->Cantidad;
            $Producto['Precio'] = $Row->Precio;
            $Producto['Tam'] = $Row->Tam;
            $Producto['FFA'] =  $Row->Agregado;
            $Producto['Descuento'] = $Row->Descuento;
            $Producto['FFDI'] = $Row->Descuento_inicio;
            $Producto['FFDF'] = $Row->Descuento_fin;
			$Producto['Tag']  = $Row->tag;
			$Producto['Marca'] = $Row->marca_id;
			$Producto['Sort_order'] = $Row->sort_order;
			$Producto['Modificado'] = $Row->modificado;

      $Datos['Productos'][] = $Producto;

    }
    
     $SqlProductosRelacionados = "select * from Mv_ProductosRelacionados";
    $Resultado =  mysqli_query($vConex,$SqlProductosRelacionados);
    while($Row =  mysqli_fetch_object($Resultado))
    {

        $ProductoRelacion['idProducto'] = $Row->Producto_id;
        $ProductoRelacion['idRelacion'] = $Row->Relacion_id;


        	$Datos['ProductoRelacion'][] = $ProductoRelacion;

    }
    
       //DetalleProducto
    $SqlDetalleProducto = "select * from Mv_ProductosAtributos";
    $Resultado =  mysqli_query($vConex,$SqlDetalleProducto);
    while($Row =  mysqli_fetch_object($Resultado))
    {

        $DetalleProducto['idProducto'] = $Row->Codigo_producto;
        $DetalleProducto['idAtributo'] = $Row->Codigo_Atributo;
        $DetalleProducto['Atributo'] = str_replace("'","",utf8_encode($Row->Atributo));
        $DetalleProducto['Descripcion'] = str_replace("'","",utf8_encode($Row->Descripcion));

          $Datos['DetalleProducto'][] = $DetalleProducto;

    }

}
 echo json_encode($Datos);