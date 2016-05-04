

<div class="left">
<?php
if (isset($_SESSION['userid']))
{

        include('basededatos.php');
        $vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);

        echo "<h2> Vendedor </h2>";
        echo $_SESSION['name'];
        echo "<h3>Listado de clientes</h3>";
        echo '<select name="Clientes" id ="Clientes" onchange="Logear()"> ';
        echo "<option value='0'> Seleccionar </option>";
        $_SESSION['userid'];
        $vSql = "SELECT firstname, lastname, email from oc_customer where salesrep_id = ".$_SESSION['userid']." ; ";
        $vResultado = mysqli_query($vConex,$vSql);
        $vContador = 1;

        while ( $vArreglo = mysqli_fetch_row($vResultado))
        {
            echo $vDatos[$vContador][] = $vArreglo[0] ;
            echo $vDatos[$vContador][] = $vArreglo[1] ;
            echo  $vDatos[$vContador][] = $vArreglo[2];


         echo "<option value='$vContador'> ". $vArreglo[0] ."</option>";

          echo   $vContador++;
        }
         echo "</select>";


    ?>
<script>
    function Logear()
    {
    var res =     document.getElementById("Clientes").value;
        document.location.href = 'http://socimagestion.com/Mejora/Select.php?Clientes='+res ;

    }



</script>
<?php
}
else
{

}
?>

</div>
<div id="login" class="right">
  <b><?php echo $entry_email; ?></b><br />
  <input type="text" name="email" value="<?php if(isset($_SESSION['Clientes'])){ echo $vDatos[$_SESSION['Clientes']][2]; } else { echo '' ; }  ?>" />
  <br />
  <br />
  <b><?php echo $entry_password; ?></b><br />
  <input type="password" name="password" value="<?php if(isset($_SESSION['Clientes'])){ echo $vDatos[$_SESSION['Clientes']][1]; } else { echo '' ; }  ?>" />
  <br />
  <a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a><br />
  <br />
  <input type="button" value="<?php echo $button_login; ?>" id="button-login" class="button" /><br />
  <br />
</div>