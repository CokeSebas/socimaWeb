<?php
/**
 * Sistema Creado por Alvaro Rivera para ODRIL Fecha de actualizacion 26/ Septiembre / 2014  11:39 hrs.
 * Se deja registro que se crear archivo de funciciones para la carga de datos desde socimagestion a socimamovil
 */


include('Config.php');

$vCxSocima = mysqli_connect($vServer,$vUser,$vPassword,$vBd);
$vCxMovil = mysqli_connect($vServer2,$vUser2,$vPassword2,$vBd2);
$verOnline = 0;
$verProductos = 0;
$verOrdenes = 0;
$verClientes = 0;
$verNoticias = 0;
$verVendedores = 0;
$verEstados = 0;
$verMarcas = 0;




function EstadoBase()
{

    if($GLOBALS['vCxSocima']){echo "<b><center><small>Socima : Ok</center></b></small>";}else{echo "<b><center><small>Factusol : Error al conectarla base de datos</center></b></small>";};
    if($GLOBALS['vCxMovil']){echo "<b><center><small>SocimaMovil : Ok</center></b></small>";}else{echo "<b><center><small>OpenCart : Error al conectarla base de datos</center></b></small>";};
}

Function VaciarTablaMovil ($Nombre)
{
    $vSqlVaciar = "TRUNCATE TABLE $Nombre";
    $vResultadoBuscador = mysqli_query($GLOBALS['vCxMovil'],$vSqlVaciar);
}

function ActualizarCategoriasPadre()
{  // <---- Buscar Categorias Padres  ---->


    $vNombre = "Mv_categoriaPadre" ;
    VaciarTablaMovil($vNombre); // SE VACIA LA TABLA PARA EVITAR LAS TABLAS ELIMINADAS EN LA SOCIMA

    $vSqlSeleccionarCategoriaPadre = "select CA.category_id,
                    CA.parent_id,
                    CAD.name
                    from oc_category CA, oc_category_description CAD
                    where (CA.category_id = CAD.category_id and CA.parent_id = 0)
                    ORDER BY  name asc";

    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlSeleccionarCategoriaPadre);
    $Total = $vResultado->num_rows;
    echo "<br><br>Total de Categorias Padre: ".$Total."<br>";

// <---- Fin de buscar Categorias Padres  ---->
    $vContador = 0;
    
// <---- Insertar Categorias Padres en BD-Movil  ---->
    while($vArreglo = mysqli_fetch_row($vResultado))
    {

            $vSqlInsertCategoriaPadreEnMovil = "INSERT INTO Mv_categoriaPadre
                                                SET category_id = $vArreglo[0], parent_id = $vArreglo[1], name = '$vArreglo[2]'; ";
            $vResultadoInsertCategoria = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertCategoriaPadreEnMovil);
            $vContador++;
           

    }
    if($vResultadoInsertCategoria != 0)
    {
        echo "Se han cargado $vContador categorias, a la base datos Movil";
            $vSqlSelect = "select Ver From Mv_db where Nombre = 'Menu' ";
            $ResVer = mysqli_query($GLOBALS['vCxMovil'],$vSqlSelect);
            while($vR = mysqli_fetch_array($ResVer))
            {
             $verOnline = $vR[0];
            }
            $GLOBALS['verOnline'] = ++$verOnline;
            $sqlIn = "update Mv_db set Ver = $verOnline where Nombre = 'Menu'";
            mysqli_query($GLOBALS['vCxMovil'],$sqlIn);
    }else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }

// <---- Fin Insertar Categorias Padres en BD-Movil  ---->

}
function ActualizarCategoriasHijo()
{  // <---- Buscar Categorias Hijas  ---->


    $vNombre = "Mv_categoriaHijo" ;
    VaciarTablaMovil($vNombre); // SE VACIA LA TABLA PARA EVITAR LAS TABLAS ELIMINADAS EN LA SOCIMA

    $vSqlSeleccionarCategoriaHijo = "select
                                 CA.category_id,
                                  CA.parent_id,
                                  CAD.name
                                  from
                                  oc_category CA,
                                  oc_category_description CAD
                                  where
                                  (CA.category_id = CAD.category_id and CA.parent_id != 0)
                                  group by CA.category_id;";

    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlSeleccionarCategoriaHijo);
    $Total = $vResultado->num_rows;
    echo "<br><br>Total de Categorias Hijas: ".$Total."<br>";

// <---- Fin de buscar Categorias Hijas  ---->
   $vContador = 0;
// <---- Insertar Categorias Padres en BD-Movil  ---->
    while($vArreglo = mysqli_fetch_row($vResultado))
    {

        $vSqlInsertCategoriaHijoEnMovil = "INSERT INTO Mv_categoriaHijo
                                                SET category_id = $vArreglo[0], parent_id = $vArreglo[1], name = '$vArreglo[2]'; ";
        $vResultadoInsertCategoria = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertCategoriaHijoEnMovil);
        $vContador++;
    }

    if($vResultadoInsertCategoria != 0)
    {
     echo "Se han cargado $vContador categorias hijas, a la base datos Movil";
    }else
    {
    echo "La carga hacia la base de datos Movil ha producido un error.";
    }

// <---- Fin Insertar Categorias Padres en BD-Movil  ---->
echo "<br>ver : ".$GLOBALS['verOnline'];
}

/* CARGAR PRODUCTOS */

function CargarProductos()
{
    $vNombre = "Mv_Productos" ;
    VaciarTablaMovil($vNombre); // SE VACIA LA TABLA PARA EVITAR LAS TABLAS ELIMINADAS EN SOCIMA

    $vSqlSeleccionarProducto = "select PR.product_id, PR.model,PRDD.meta_description ,PR.sku, PR.upc, PR.StockInicial, PR.quantity,PR.price,PR.length, PR.status, PR.date_added, PRD.price as Descuento, PRD.date_start, PRD.date_end, PRDD.tag as tag, PR.manufacturer_id, PR.sort_order, PR.modificado from oc_product PR 
	left join oc_product_special PRD on PRD.product_id = PR.product_id
	left join oc_product_description PRDD on PR.product_id =  PRDD.product_id
	where PR.status = 1";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlSeleccionarProducto);
    $Total = $vResultado->num_rows;
    echo "<br><br>Total de Productos Registrados: ".$Total."<br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {

      $vSqlInsertProductos= "INSERT INTO Mv_Productos set Codigo_producto = $vArreglo[0], modelo =\"".addslashes($vArreglo[1])."\", descripcion =\"".addslashes($vArreglo[2])."\", codigo='$vArreglo[3]',codigo_bodega = '$vArreglo[4]', Stock_inicial ='$vArreglo[5]', Cantidad = $vArreglo[6] , Precio = $vArreglo[7], Tam = '$vArreglo[8]', Estado = '$vArreglo[9]', Agregado = '$vArreglo[10]' ,Descuento= '$vArreglo[11]' ,Descuento_inicio= '$vArreglo[12]' ,Descuento_fin= '$vArreglo[13]', tag = '$vArreglo[14]', marca_id= '$vArreglo[15]', sort_order = '$vArreglo[16]', modificado = '$vArreglo[17]';  ";
     $vResultadoInsertProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertProductos);
           
           $vContador++;
        
    }
    
    	    $vSqlSelect = "select Ver From Mv_db where Nombre = 'Productos' ";
            $ResVer = mysqli_query($GLOBALS['vCxMovil'],$vSqlSelect);
            while($vR = mysqli_fetch_array($ResVer))
            {
             $verProductos = $vR[0];
            }
            $GLOBALS['verProductos'] = ++$verProductos;
            $sqlIn = "update Mv_db set Ver = $verProductos where Nombre = 'Productos'";
            mysqli_query($GLOBALS['vCxMovil'],$sqlIn);

    
     mysqli_query($GLOBALS['vCxMovil'],'update Mv_Productos set Descripcion =  replace(Descripcion,"&lt;p&gt;"," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Productos set Descripcion =  replace(Descripcion,","," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Productos set Descripcion =  replace(Descripcion,\'"\'," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Productos set Descripcion =  replace(Descripcion,"&lt;/p&gt;"," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Productos set Descripcion =  replace(Descripcion,"&amp;nbsp"," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Productos set Descripcion =  replace(Descripcion,"8&quot;"," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Productos set Descripcion =  replace(Descripcion,"&quot;"," ")');
    
    if($vResultadoInsertProductos != 0)
        {
            echo "Se han cargado $vContador productos, a la base datos Movil";
        }
    else
        {
            echo "La carga hacia la base de datos Movil ha producido un error.";
        }

}

function cargarMarcas(){
	$vNombre = "Mv_Marca" ;
    VaciarTablaMovil($vNombre);
    $vSqlMarcas = "SELECT manufacturer_id, name FROM oc_manufacturer";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlMarcas);
    $Total = $vResultado->num_rows;
    echo "Total de Marcas: ".$Total."<br><br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
        $vSqlInsertEstado= "INSERT INTO Mv_Marca set marca_id= ".$vArreglo[0].", nombre = '".$vArreglo[1]."';";
        $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertEstado);
        $vContador++;
    }
    if($vResultadoInsertCategoriasProductos!= 0)
    {
        echo "Se han cargado $vContador Marcas, a la base datos Movil";
        $vSqlSelect = "select Ver From Mv_db where Nombre = 'Marcas'";
            $ResVer = mysqli_query($GLOBALS['vCxMovil'],$vSqlSelect);
            while($vR = mysqli_fetch_array($ResVer))
            {
             $verMarca = $vR[0];
            }
            $GLOBALS['verMarca'] = ++$verMarca;
            $sqlIn = "update Mv_db set Ver = $verMarca where Nombre = 'Marcas'";
            mysqli_query($GLOBALS['vCxMovil'],$sqlIn);
            echo "<br>ver :".$GLOBALS['verMarca'];
    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }
}


function CargarAtributos()
{
    $vNombre = "Mv_ProductosAtributos" ;
    VaciarTablaMovil($vNombre);
   $vSqlProductosAtributos = "select PATR.product_id,PATR.attribute_id,ATRD.name,PATR.text from oc_product_attribute PATR, oc_attribute_description ATRD where ATRD.attribute_id = PATR.attribute_id";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlProductosAtributos);
    $Total = $vResultado->num_rows;
    echo "<br><br>Total de Atributos: ".$Total."<br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
        $vSqlInsertProductosAtributos= "INSERT INTO Mv_ProductosAtributos set Codigo_Producto= $vArreglo[0], Codigo_Atributo= $vArreglo[1],Atributo ='$vArreglo[2]',Descripcion ='$vArreglo[3]';";
        $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertProductosAtributos);
        $vContador++;
    }
    
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_ProductosAtributos set Atributo =  replace(Atributo,"ñ","n")');
        mysqli_query($GLOBALS['vCxMovil'],'update Mv_ProductosAtributos set Descripcion =  replace(Descripcion,"&quot;"," ")');


    if($vResultadoInsertCategoriasProductos!= 0)
    {
        echo "Se han cargado $vContador Atributos a los productos, en la base datos Movil";
    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }

}

/* CARGAR DEPENDENCIA DEL PRODUCTO A UNA CATEGORIA */

function CargarCategoriaProductos()
{
    $vNombre = "Mv_categoriaProductos" ;
    VaciarTablaMovil($vNombre);
    $vSqlCategoriaProductos = "select product_id, category_id from oc_product_to_category";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlCategoriaProductos);
    $Total = $vResultado->num_rows;
    echo "<br><br>Total de Productos Registrados con su categoria: ".$Total."<br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
        $vSqlInsertCategoriasProductos= "INSERT INTO Mv_categoriaProductos set product_id= $vArreglo[0], category_id = $vArreglo[1];";
        $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertCategoriasProductos);
        $vContador++;
    }
    if($vResultadoInsertCategoriasProductos!= 0)
    {
        echo "Se han cargado $vContador productos en categorias, a la base datos Movil";
    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }
            echo "<br>ver : ".$GLOBALS['verProductos'];

}

/* CARGAR RELACIONES ENTRE PRODUCTOS */

function CargarProductosRelacionados()
{
    $vNombre = "Mv_ProductosRelacionados" ;
    VaciarTablaMovil($vNombre);
    $vSqlProductosRelacionados = "select product_id, related_id from oc_product_related";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlProductosRelacionados);
    $Total = $vResultado->num_rows;
    echo "<br><br>Total de Pructos Relacionados: ".$Total."<br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
        $vSqlInsertProductosRelacionados= "INSERT INTO Mv_ProductosRelacionados set Producto_id= $vArreglo[0], Relacion_id = $vArreglo[1];";
        
        
        $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertProductosRelacionados);
        $vContador++;
    }
    if($vResultadoInsertCategoriasProductos!= 0)
    {
    
        echo "Se han cargado $vContador Relaciones entre productos, a la base datos Movil";
    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }

}

/* CARGAR  CLIENTES  RECORDAR QUE LA LISTA DE CLIENTES SE REPITEN LOS CORREOS */

function CargarClientes()
{
    $vNombre = "Mv_Clientes" ;
    VaciarTablaMovil($vNombre);
    
    $vSqlClientes= "select CU.customer_id, CU.firstname,CU.lastname,CU.email,CU.telephone,CU.fax,CU.salesrep_id,CU.Credito, CUD.address_id, CUD.address_1, CUD.address_2, CUD.city, CUDZ.name,CUDZ.code, CU.CreditoMaximo 
					from oc_customer CU left join oc_address CUD on CUD.address_id = CU.address_id left join oc_zone CUDZ on CUD.zone_id =  CUDZ.zone_id";

    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlClientes);
    $Total = $vResultado->num_rows;
    echo "<br><br>Total Cliente reconocidos: ".$Total."<br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
      $vSqlInsertClientes= "INSERT INTO Mv_Clientes set customer_id= $vArreglo[0], firstname = \"".addslashes($vArreglo[1])."\", lastname = \"".addslashes($vArreglo[2])."\", email  = \"".addslashes($vArreglo[3])."\", telephone = \"".addslashes($vArreglo[4])."\", fax  = \"".addslashes($vArreglo[5])."\", salesrep_id  = $vArreglo[6], Credito  = $vArreglo[7], address_id  = \"".addslashes($vArreglo[8])."\", address_1  = \"".addslashes($vArreglo[9])."\",address_2  = \"".addslashes ($vArreglo[10])."\",city = \"".addslashes($vArreglo[11])."\", name  = \"".addslashes($vArreglo[12])."\", codec  = \"".$vArreglo[13]."\", CreditoMaximo  = " . $vArreglo[14] . ";";
       
       $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertClientes);
       $vContador++;

     
       
    }
    if($vResultadoInsertCategoriasProductos!= 0)
    {
            echo "Se han cargado $vContador Clientes, a la base datos Movil";
            $vSqlSelect = "select Ver From Mv_db where Nombre = 'Clientes' ";
            $ResVer = mysqli_query($GLOBALS['vCxMovil'],$vSqlSelect);
            while($vR = mysqli_fetch_array($ResVer))
            {
             $verClientes = $vR[0];
            }
            $GLOBALS['verClientes'] = ++$verClientes;
            $sqlIn = "update Mv_db set Ver = $verClientes where Nombre = 'Clientes'";
            mysqli_query($GLOBALS['vCxMovil'],$sqlIn);
            echo "<br>ver :".$GLOBALS['verClientes'];
    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }

}

/* CARGAR NOTICIAS ||  REVISAR TEMA DE TEXTOS CON IMAGENES */

function CargarNoticias()
{
Banner();
    $vNombre = "Mv_Noticias" ;
   
    VaciarTablaMovil($vNombre);
   $vSqlNoticias = "select INFODESC.title as Titulo, INFODESC.description as Noticia, INFODESC.imagen as Imagen, INFO.sort_order, INFO.status from oc_information INFO, oc_information_description INFODESC where INFODESC.information_id =  INFO.information_id";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlNoticias);
    $Total = $vResultado->num_rows;
    echo "Total de Noticias Redactadas: ".$Total."<br><br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
       $vSqlInsertNoticias= "INSERT INTO Mv_Noticias set titulo= \"".$vArreglo[0]."\", noticia = \"".addslashes($vArreglo[1])."\",Imagen = ' $vArreglo[2]',orderc =$vArreglo[3],statuse = $vArreglo[4];";
       
        $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertNoticias);
        $vContador++;
    }
    
    
    
    
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Noticias set Noticia =  replace(Noticia,"&lt;p&gt;"," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Noticias set Noticia =  replace(Noticia,"<p>"," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Noticias set Noticia =  replace(Noticia,\'"\'," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Noticias set Noticia =  replace(Noticia,"&lt;/p&gt;"," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Noticias set Noticia =  replace(Noticia,"&amp;nbsp"," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Noticias set Noticia =  replace(Noticia,"8&quot;"," ")');
    mysqli_query($GLOBALS['vCxMovil'],'update Mv_Noticias set Noticia =  replace(Noticia,"&quot;"," ")');
    if($vResultadoInsertCategoriasProductos!= 0)
    {
        echo "Se han cargado $vContador Noticas, a la base datos Movil";
         $vSqlSelect = "select Ver From Mv_db where Nombre = 'Noticias' ";
            $ResVer = mysqli_query($GLOBALS['vCxMovil'],$vSqlSelect);
            while($vR = mysqli_fetch_array($ResVer))
            {
             $verNoticias = $vR[0];
            }
            $GLOBALS['verNoticias'] = ++$verNoticias;
            $sqlIn = "update Mv_db set Ver = $verNoticias where Nombre = 'Noticias'";
            mysqli_query($GLOBALS['vCxMovil'],$sqlIn);
            echo "<br>ver :".$GLOBALS['verNoticias'];
        
    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }

}

function Banner()
{
    $vNombre =  "Mv_Banner";
    VaciarTablaMovil($vNombre);
    $vSqlBanner = "Select banner_id,url,informacion from oc_banner2";
    $vContadorDos = 0;
     $vResultadoDos = mysqli_query($GLOBALS['vCxSocima'],$vSqlBanner);
    echo  $TotalDos =  $vResultadoDos->num_rows;
    echo  "<br>Total de Banner Actualizados: ".$TotalDos."<br><br>";
    while($vArregloDos = mysqli_fetch_row($vResultadoDos))
    {
    
   echo  $vSqlInsertarBanner = "INSERT INTO Mv_Banner set Url =\"".$vArregloDos[1]."\", Informacion = \"".$vArregloDos[2]."\";";
    $vResultadoInsertarBanner =  mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertarBanner);
    }
    
}

/* CARGAR VENDEDORES Y USUARIOS DEL SISTEMA */

function CargarVendedores()
{
    $vNombre = "Mv_Vendedores" ;
    VaciarTablaMovil($vNombre);
    $vSqlVendedores = "select salesrep_id, name, email, username,password,telephone,address,date_added, MM, Cargo, localidad, status from oc_salesrep";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlVendedores);
    $Total = $vResultado->num_rows;
    echo "Total de Vendedores: ".$Total."<br><br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
		$sqlTotal = "SELECT IFNULL(SUM(total), 0) AS total FROM oc_order WHERE salesrep_id = '".$vArreglo[0]."'";
		$resultado = mysqli_query($GLOBALS['vCxSocima'],$sqlTotal);
		$total = mysqli_fetch_row($resultado);

       $vSqlInsertVendedores= "INSERT INTO Mv_Vendedores set Codigo_vendedor = \"".$vArreglo[0]."\",Cargo = \"".$vArreglo[9]."\" ,MM = \"".$vArreglo[8]."\", nombre = '$vArreglo[1]',email = \"".$vArreglo[2]."\", usuario = \"".$vArreglo[3]."\", clave = \"".$vArreglo[4]."\", telefono = \"".$vArreglo[5]."\", direccion = \"".$vArreglo[6]."\", fecha_creacion = \"".$vArreglo[7]."\", totalActual = \"".$total[0]."\", localidad = \"".$vArreglo[10]."\", estado = \"".$vArreglo[11]."\";";
	   
        $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertVendedores);
        $vContador++;
    }
    if($vResultadoInsertCategoriasProductos!= 0)
    {
        echo "Se han cargado $vContador Vendedores, a la base datos Movil";
          $vSqlSelect = "select Ver From Mv_db where Nombre = 'Vendedores' ";
            $ResVer = mysqli_query($GLOBALS['vCxMovil'],$vSqlSelect);
            while($vR = mysqli_fetch_array($ResVer))
            {
             $verVendedores = $vR[0];
            }
            $GLOBALS['verVendedores'] = ++$verVendedores;
            $sqlIn = "update Mv_db set Ver = $verVendedores where Nombre = 'Vendedores'";
            mysqli_query($GLOBALS['vCxMovil'],$sqlIn);
            echo "<br>ver :".$GLOBALS['verVendedores'];
    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }

}

/* CARGAR ESTADOS DE LA ORDNES  || PERO PODRIA SERVIR PARA UTILIZAR EN OTRAS SITUACIONS */ 

function CargarEstados()
{
    $vNombre = "Mv_Estado" ;
    VaciarTablaMovil($vNombre);
   $vSqlEstado = "select order_status_id, name from oc_order_status";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlEstado);
    $Total = $vResultado->num_rows;
    echo "Total de Estados: ".$Total."<br><br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
         $vSqlInsertEstado= "INSERT INTO Mv_Estado set Estado_id= \"".$vArreglo[0]."\", Estado = \"".$vArreglo[1]."\";";
       
        $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertEstado);
        $vContador++;
    }
    if($vResultadoInsertCategoriasProductos!= 0)
    {
        echo "Se han cargado $vContador Estados, a la base datos Movil";
        $vSqlSelect = "select Ver From Mv_db where Nombre = 'Estado' ";
            $ResVer = mysqli_query($GLOBALS['vCxMovil'],$vSqlSelect);
            while($vR = mysqli_fetch_array($ResVer))
            {
             $verEstado = $vR[0];
            }
            $GLOBALS['verEstado'] = ++$verEstado;
            $sqlIn = "update Mv_db set Ver = $verEstado where Nombre = 'Estado'";
            mysqli_query($GLOBALS['vCxMovil'],$sqlIn);
            echo "<br>ver :".$GLOBALS['verEstado'];
    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }

}



/* CARGAR ORDENES DE COMPRA */

function CargarOrdenes()
{
    $vNombre = "Mv_Orden" ;
    VaciarTablaMovil($vNombre);
  $vSqlOrden= "select ORD.order_id,ORD.invoice_prefix,ORD.customer_id,ORD.payment_address_1,ORD.payment_city, ORD.payment_zone_id,ORDZ.name,ORDZ.code, ORD.payment_code,ORD.total, ORD.order_status_id,ORD.date_added,ORD.date_modified,ORD.salesrep_id from oc_order ORD, oc_zone ORDZ where ORDZ.zone_id = ORD.payment_zone_id";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlOrden);
    $Total = $vResultado->num_rows;
    echo "<br><br>Total de  Ordenes: ".$Total."<br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
        $vSqlInsertOrden= "INSERT INTO Mv_Orden set Orden_id = $vArreglo[0], codigo_orden = '$vArreglo[1]', Cliente_id= $vArreglo[2], Direccion_pago = '$vArreglo[3]', Ciudad_pago = '$vArreglo[4]',Codigo_region = $vArreglo[5], Nombre_region = '$vArreglo[6]', Abr_region  = '$vArreglo[7]', Tipo_pago = '$vArreglo[8]', total = $vArreglo[9], Estado = $vArreglo[10],Fecha_ingreso = '$vArreglo[11]',Fecha_modificada = '$vArreglo[12]', vendedor = $vArreglo[13];";
       
       $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertOrden);
        $vContador++;
       
    }
    
    if($vResultadoInsertCategoriasProductos!= 0)
    {
        echo "Se han cargado $vContador ordenes, a la base datos Movil";
            $vSqlSelect = "select Ver From Mv_db where Nombre = 'Ordenes' ";
            $ResVer = mysqli_query($GLOBALS['vCxMovil'],$vSqlSelect);
            while($vR = mysqli_fetch_array($ResVer))
            {
             $verOrdenes = $vR[0];
            }
            $GLOBALS['verOrdenes'] = ++$verOrdenes;
            $sqlIn = "update Mv_db set Ver = $verOrdenes where Nombre = 'Ordenes'";
            mysqli_query($GLOBALS['vCxMovil'],$sqlIn);
    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }

}

/* CARGAR PRODUCTOS A LAS ORDENES */


function CargarDetalleOrden()
{
    $vNombre = "Mv_DetalleOrden" ;
    VaciarTablaMovil($vNombre);
  $vSqlDetalleOrden= "select order_id,product_id,quantity,price,total from oc_order_product";
    $vContador = 0;
    $vResultado =  mysqli_query($GLOBALS['vCxSocima'],$vSqlDetalleOrden);
    $Total = $vResultado->num_rows;
    echo "<br><br>Total de Productos en Ordenes: ".$Total."<br>";
    while($vArreglo = mysqli_fetch_row($vResultado))
    {
        $vSqlInsertDetalleOrden= "INSERT INTO Mv_DetalleOrden set Orden_id = $vArreglo[0],Producto_id = $vArreglo[1],Cantidad= $vArreglo[2],Precio = $vArreglo[3],Total = $vArreglo[4];";
        
       
        $vResultadoInsertCategoriasProductos = mysqli_query($GLOBALS['vCxMovil'],$vSqlInsertDetalleOrden);
        $vContador++;
    }
    if($vResultadoInsertCategoriasProductos!= 0)
    {
        echo "Se han cargado $vContador Productos a las ordenes, a la base datos Movil";
                    echo "<br>ver : ".$GLOBALS['verOrdenes'];

    }
    else
    {
        echo "La carga hacia la base de datos Movil ha producido un error.";
    }

}