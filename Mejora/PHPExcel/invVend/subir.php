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
        if(file_exists('inv Vend.xls'))
        {
            unlink('inv Vend.xls');
        }

        if (copy($_FILES['archivo']['tmp_name'],$destino))
        {
            rename($archivo, 'inv Vend.xls');
            echo "<center>";
            echo $status = "Archivo subido: <b>".$archivo."</b>";
            echo "<h2><a href='invVend.php'>CARGAR BASE DE DATOS</a></h2>";
echo "</center>";
        }
        else
        {
            echo $status = "Error al subir el archivo";
        }

    }
    else
    {
        echo $status = "Error al subir archivo";
    }
}