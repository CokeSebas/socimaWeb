<?php
ob_start();
session_start();
/**
 * Sistema Creado por Alvaro Rivera para ODRIL Fecha de actualizacion 22/ Septiembre / 2014  22:40 hrs.
 * Se deja registro que se entregan datos conexion a bases de datos TIENDA3
 */

$vPs = 0;
function Login($vClave)
{

    if($vClave == 2022)
    {
        $GLOBALS['vPs'] =  $vClave;
        return 1;
    }
    else
    {
        return 0;
    }

}

if(!isset($_SESSION['Clave']))
{
    if(isset($_POST['login']))
    {
        if(Login($_POST['password'])== 1)
        {

            $_SESSION['Clave'] = $vPs;
            header("location: http://socimagestion.com/Mejora/PHPExcel//sistema.php/");

        }
        else
        {
            echo '<div class="error"> Su usuario o clave es incorrecto, vuelva a intentarlo </div>';
        }
    }
    ob_end_flush();
?>


    <style type="text/css">
        *{
    font-size: 14px;
    font-family: sans-serif;
            background-size: 100%;
    }
    form.login {
    background: none repeat scroll 0 0 #F1F1F1;
    border: 1px solid #DDDDDD;
        position: absolute;
        top:35%;
        left:38%;
        padding: 20px;
    width: 278px;

    }
    form.login div {
    margin-bottom: 15px;
        background: none repeat scroll 0 0 #F1F1F1;
        overflow: hidden;
    }
    form.login div label {
    display: block;
    background: none repeat scroll 0 0 #F1F1F1;
    float: left;
    line-height: 25px;
    }
    form.login div input[type="text"], form.login div input[type="password"] {
    border: 1px solid #DCDCDC;
        background: none repeat scroll 0 0 #F1F1F1;

        float: right;
    padding: 4px;
    }
    form.login div input[type="submit"] {
    background: none repeat scroll 0 0 #DEDEDE;
    border: 1px solid #C6C6C6;
    float: right;
    font-weight: bold;
    padding: 4px 20px;
    }
    .error{
    color: red;
    font-weight: bold;
    margin: 10px;
    text-align: center;
    }
    </style>
    <form action="" method="post" class="login">
    <div><label>Password</label><input name="password" type="password"></div>
    <div><input name="login" type="submit" value="Ingresar"></div>
</form>
<?php
}
else
{
    echo 'Ya se encuentra Logeado';
    echo '<br><a href="logout.php"> Salir del sistema </a>';

}
?>