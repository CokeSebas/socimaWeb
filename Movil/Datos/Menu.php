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
        $categoriaProducto['Codigo'] = $Row->category_id;

       $Datos['CategoriaProducto'][] = $categoriaProducto;

    }

}
 echo json_encode($Datos);











