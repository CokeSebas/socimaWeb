 <?php
 include('basededatos.php');
	     $vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
	           
	      $vSql = "select product_id, model, sku, price, image from oc_product  where product_id = 81200";
	      
	      $Resultado =  mysqli_query($vConex,$vSql);
	      $R = "";
	      while($vArreglo = mysqli_fetch_row($Resultado))
	      {
	        echo  $R = " <b>Codigo:</b>$vArreglo[0]  ||  <b>Modelo:</b> $vArreglo[1]  ||  Codigo2: $vArreglo[2]  || Precio: $vArreglo[3] || Imagen1: $vArreglo[4]<br>";
	        
	       			 $vSql2 = "select image from oc_product_image where product_id = 81200 ";
	      
	    	 		 $Resultado2 =  mysqli_query($vConex,$vSql2);
	     			 $R2 = "";
	      				while($vArreglo2 = mysqli_fetch_row($Resultado2))
	      				{
	       					 echo  $R2 = "Imagenes: 81200 <br>"; 
	         
	     				} 
	     					$vSql3 = "select OAD.name, OPA.text from oc_product_attribute OPA, oc_attribute_description OAD where OPA.product_id = 81200 and OAD.attribute_id = OPA.attribute_id";
	     					 $Resultado3 =  mysqli_query($vConex,$vSql3);
		     			 		$R3 = "";
	      						while($vArreglo3 = mysqli_fetch_row($Resultado3))
	      						{
	       							 echo  $R3 = "Nombre: $vArreglo3[0]   <br>"; 
	       							 echo  $R3 = "Descripcion:$vArreglo3[1] <br>";
	         
	     						} 
	     					 echo "<hr>"; 
	     				
	         
	      }
	   