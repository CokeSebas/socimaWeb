<?php
include('basededatos.php');
$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd); 
 $vSqlCantidadRecomendada = "select * from oc_customer where email = \"\" ";

	      $Resultado =  mysqli_query($vConex,$vSqlCantidadRecomendada);
	      $RR = "";
	      while($vArreglo = mysqli_fetch_row($Resultado))
	      {
	          echo  " <br> update oc_customer set email = \"$vArreglo[3]@socimagestion.com\" where customer_id =  $vArreglo[0];";
	          
	      }