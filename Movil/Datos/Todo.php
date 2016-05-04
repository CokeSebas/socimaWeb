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
    $SqlCliente = "select customer_id, firstname,email,telephone,salesrep_id,credito,address_1,city,name,codec from Mv_Clientes";
    $Resultado =  mysqli_query($vConex,$SqlCliente);

    while($Row =  mysqli_fetch_object($Resultado))
    {   $Cliente['CodigoCliente'] = $Row->customer_id;
        $Cliente['Nombre'] = str_replace("'","",utf8_encode($Row->firstname));
        $Cliente['Email'] = utf8_encode($Row->Email);
        $Cliente['Telefono'] = $Row->telephone;
        $Cliente['Vendedor'] = $Row->salesrep_id;
        $Cliente['Credito'] = $Row->credito;
        $Cliente['Direccion'] = str_replace("'","",utf8_encode($Row->address_1));
        $Cliente['Ciudad'] = str_replace("'","",utf8_encode($Row->city));
        $Cliente['Region'] = str_replace("'","",utf8_encode($Row->name));
        $Cliente['Codigo'] = utf8_encode($Row->codec);
        $Datos['Cliente'][] = $Cliente;
    }
    $SqlEstado = "select * from Mv_Estado";
    $Resultado =  mysqli_query($vConex,$SqlEstado);

    while($Row =  mysqli_fetch_object($Resultado))
    {
        $Estado['idEstado'] = $Row->Estado_id;
        $Estado['Estado'] = str_replace("'","",utf8_encode($Row->Estado));

            $Datos['Estados'][] = $Estado;

    }
    
    
 $SqlCategoriaPadre = "Select category_id, name from Mv_categoriaPadre;";
    $Resultado =  mysqli_query($vConex,$SqlCategoriaPadre);

    while($Row =  mysqli_fetch_object($Resultado))
    {   $MenuPadre['Codigo'] = $Row->category_id;
        $MenuPadre['NombreCategoria'] = utf8_encode($Row->name);

        $Datos['MenuPadre'][] = $MenuPadre;

    }

    // Menu Hijo
    $SqlCategoriaHijo = "Select category_id,parent_id, name from Mv_categoriaHijo;";
    $Resultado =  mysqli_query($vConex,$SqlCategoriaHijo);

    while($Row =  mysqli_fetch_object($Resultado))
    {   $MenuHijo['Codigo'] = $Row->category_id;
        $MenuHijo['CodigoPadre'] = $Row->parent_id;
        $MenuHijo['NombreCategoria'] = utf8_encode($Row->name);

     $Datos['MenuHijo'][] = $MenuHijo;

    }

    // categoriaProducto
    $SqlCategoriaProducto = "Select product_id,category_id from Mv_categoriaProductos;";
    $Resultado =  mysqli_query($vConex,$SqlCategoriaProducto);

    while($Row =  mysqli_fetch_object($Resultado))
    {   $categoriaProducto['CodigoProducto'] = $Row->product_id;
        $categoriaProducto['codigo'] = $Row->category_id;

       $Datos['categoriaProducto'][] = $categoriaProducto;

    }
    
        //Noticias
    $SqlNoticia = "select * from Mv_Noticias";
    $Resultado =  mysqli_query($vConex,$SqlNoticia);
    while($Row =  mysqli_fetch_object($Resultado))
    {
        $Noticia['Titulo'] = str_replace("'","",utf8_encode($Row->titulo));
        $Noticia['Noticia'] = str_replace("'","",utf8_encode($Row->noticia));

        	$Datos['Noticia'][] = $Noticia;

    }
    
    

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
        $Orden['CiudadPago'] = str_replace("'","",utf8_encode($Row->CiudadPago));
        $Orden['Region'] = str_replace("'","",utf8_encode($Row->Nombre_region));
        $Orden['TipoPago'] = str_replace("'","",utf8_encode($Row->Tipo_pago));
        $Orden['Total'] = $Row->Total;
        $Orden['Estado'] = $Row->Estado;
        $Orden['Vendedor'] = $Row->Vendedor;
        $Orden['FFI'] = str_replace("'","",utf8_encode($Row->Fecha_ingreso));
        $Orden['FFM'] = str_replace("'","",utf8_encode($Row->Fecha_modificada));

        	$Datos['Orden'][] = $Orden;

    }
	    
    // Marca
    $SqlMarcas = "SELECT marca_id, nombre FROM `v_Marca";
    $Resultado =  mysqli_query($vConex,$SqlMarcas);
    while($Row =  mysqli_fetch_object($Resultado)){   
		$Marca['marca_id'] = $Row['marca_id'];
		$Marca['nombre'] = $Row['nombre'];
		
         $Datos['Marca'][] = $Marca;
    }

    
 //Producto
    $SqlProducto = "select * from Mv_Productos";
    $Resultado =  mysqli_query($vConex,$SqlProducto);
    while($Row =  mysqli_fetch_object($Resultado))
    {


        $Producto['idProducto'] = $Row->Codigo_producto;
        $Producto['Modelo'] = str_replace($Buscar,"",($Row->Modelo));
        $Producto['Descripcion'] = $Row->Descripcion;
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


    // Vendedor
    $SqlVendedores = "Select Codigo_vendedor, Nombre, email, usuario, clave, MM from Mv_Vendedores;";
    $Resultado =  mysqli_query($vConex,$SqlVendedores);

    while($Row =  mysqli_fetch_object($Resultado))
    {   $Usuario['CodigoVendedor'] = $Row->Codigo_vendedor;
        $Usuario['Nombre'] = utf8_encode($Row->Nombre);
        $Usuario['Email'] = utf8_encode($Row->email);
        $Usuario['Usuario'] = utf8_encode($Row->usuario);
        $Usuario['Clave'] = utf8_encode($Row->clave);
        $Usuario['Meta'] = $Row->MM;

         $Datos['Vendedor'][] = $Usuario;
    }

}
 echo json_encode($Datos);