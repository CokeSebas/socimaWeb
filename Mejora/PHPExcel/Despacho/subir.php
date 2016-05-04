<?php
$status = "";
if ($_POST["action"] == "upload")
{
    // obtenemos los datos del archivo
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];

    if ($archivo != "")
    {
        // guardamos el archivo a la carpeta files
        $destino =  $archivo;
        if(file_exists('Despacho.xls'))
        {
            unlink('Despacho.xls');
        }

        if (copy($_FILES['archivo']['tmp_name'],$destino))
        {
            rename($archivo, 'Despacho.xls');
            echo $status = "<center>Archivo subido: <b>".$archivo."</b></center>";
            echo "<center><h2><a href='Despacho.php'>Actualizar Base de datos de Despachos</a></h2></center>";
            

        }
        else
        {
            echo $status = "<center>Error al subir el archivo</center>";
        }

    }
    else
    {
        echo $status = "<center>Error al subir archivo</center>";
    }
}