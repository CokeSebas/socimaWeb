<?php
ob_start();
session_start();
include('config.php');
$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
function Login($vUsuario,$vClave,&$vRes)
{
    $vSql =  "SELECT *  FROM oc_salesrep where (username = '$vUsuario' and password = '$vClave' )";
    $vResultado = mysqli_query($GLOBALS['vConex'],$vSql);
    $vCount = 0;
    while($row = mysqli_fetch_object($vResultado))
    {
        $vCount++;
        $vRes = $row;
        $vRes -> salesrep_id;

    }
    if($vCount == 1)
    {
        return 1;
    }
    else
    {
        return 0;
    }

}
if(!isset($_SESSION['userid']))
{
    if(isset($_POST['login']))
    {
        if(Login($_POST['user'],$_POST['password'],$vRes)== 1)
        {
            $_SESSION['userid'] = $vRes -> salesrep_id;
            $_SESSION['name'] = $vRes -> name;
            $_SESSION['email'] = $vRes -> email;
            header("location: http://socimagestion.com");
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
    <div><label>Username</label><input name="user" type="text" ></div>
    <div><label>Password</label><input name="password" type="password"></div>
    <div><input name="login" type="submit" value="login"></div>
</form>
<?php
}
else
{
    echo 'Acceso Correcto';
    echo '<a href="logout.php"> Logout </a>';
}
?>