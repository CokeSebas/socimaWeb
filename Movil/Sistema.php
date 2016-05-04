<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 26/09/14
 * Time: 10:43
 */

include('Funciones.php');
//if(isset($_SESSION['Clave']))
if(isset($_SESSION['token']))
{
?>
<html>
<head>
    <link href="hover.css" rel="stylesheet" media="all">
</head>
<body>
<div>
<?php
 echo EstadoBase();
 ?>
</div>
<hr>
<center>
<form action="" method="post">
    <input type="submit" class="buzz-out "  value="Actualizar Vendedores" name="Vendedores" />
</form>
<form action="" method="post">
    <input type="submit" class="buzz-out "  value="Actualizar Menu & Sub Menu" name="Menu" />
</form>
<form action="" method="post">
    <input type="submit" class="buzz-out "  value="Actualizar Productos" name="Productos" />
</form>
<form action="" method="post">
    <input type="submit" class="buzz-out "  value="Actualizar Marcas" name="Marcas" />
</form>
<form action="" method="post">
    <input type="submit" class="buzz-out "  value="Actualizar Ordenes" name="Orden" />
</form>
<form action="" method="post">
    <input type="submit" class="buzz-out "  value="Actualizar Clientes" name="Clientes" />
</form>
<form action="" method="post">
    <input type="submit" class="buzz-out "  value="Actualizar Noticias" name="Noticias" />
</form>
<form action="" method="post">
    <input type="submit" class="buzz-out "  value="Actualizar Estados" name="Estados" />
</form>

</center>

<div>
    <?php

    if(isset($_POST['Menu']))
    {
        ActualizarCategoriasPadre();
        ActualizarCategoriasHijo();
    }
	
    if(isset($_POST['Productos']))
    {
        CargarProductos();
        CargarAtributos();
        CargarProductosRelacionados();
        CargarCategoriaProductos();
    }
	
	if(isset($_POST['Marcas']))
    {
        cargarMarcas();
    }
    
     if(isset($_POST['Orden']))
    {
    	CargarOrdenes();
        CargarDetalleOrden();
    }
   
    if(isset($_POST['Clientes']))
    {
        CargarClientes();
    }
    if(isset($_POST['Noticias']))
    {
        CargarNoticias();
    }
    if(isset($_POST['Vendedores']))
    {
        CargarVendedores();
    }
    if(isset($_POST['Estados']))
    {
        CargarEstados();
    }

    
   
    ?>
</div>
<?php

}
else{ echo "<center> <h2> Error </h2> <br>Ud no tiene permiso para acceder al sistema </center>"; echo '<br><a href="logout.php"> Salir del sistema </a>';}
?>
</body>

</html>