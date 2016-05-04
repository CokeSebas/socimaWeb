<?php 
	include('basededatos.php');
	$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
	
function ValorIndividual($product_id,$vConex,$precio)
	     {
	      
	      //$vSqlCantidadRecomendada = "select text from oc_product_attribute where product_id = $product_id and attribute_id = 25";
	      $vSqlCantidadRecomendada = "select text from oc_product_attribute where product_id = $product_id and attribute_id = 20";
	      $Resultado =  mysqli_query($vConex,$vSqlCantidadRecomendada);
	      $RR = "";
	      while($vArreglo = mysqli_fetch_row($Resultado))
	      {
			if($vArreglo[0] != ''){
				  $R = " <br /> Pack: <b>$vArreglo[0]</b>";
				  $RR = $R;
			}
	      }
	      	 $vSqlCantidadPack = "select text from oc_product_attribute where product_id = $product_id and attribute_id = 20";
	      	 $Resultado =  mysqli_query($vConex,$vSqlCantidadPack);
	      	 $ValorIndividual;
	      	 while($vArreglo2 = mysqli_fetch_row($Resultado))
	      	 {
	      	      $v = (int)$vArreglo2[0];
	      	      if($v > 0)
	      	      {
	      	      $precio2 =  str_replace("$",'',$precio);
	      	      $precio3 =  str_replace(".",'',$precio2);
	      	      $ValorIndividual = ( $precio3/ $v ) ;
	      	    
	      	     $R2 = "<br> <b>$".ceil($ValorIndividual)." c/u <br><br></b>";
	      	     $RR .= $R2; 
	      	  }  }

                return $RR;
	      }
	      
	      
	      function StockM($product_id,$vConex)
	     {
	      
	      $vSqlCantidadRecomendada = "select quantity from oc_product where product_id = $product_id";
	      $Resultado =  mysqli_query($vConex,$vSqlCantidadRecomendada);
	      $RR = "";
	      while($vArreglo = mysqli_fetch_row($Resultado))
	      {
	          $R = (int)$vArreglo[0];
	         

	         }

                return $R;
	      }


	      
	function Ancho($vConex,$Codigo){
		$sql = "select length, width, height from oc_product where product_id = $Codigo";
		$Resultado =  mysqli_query($vConex,$sql);
		while($vArreglo = mysqli_fetch_row($Resultado))
	      {
	      
     			switch((int)$vArreglo[0])
     			{
     			   case 1:
     			   echo "max-width: 190px;height: 100px;";
     			   break;
     			   case 2:
     			   echo "max-width: 190px; height: 130px;";
     			   break;
     			   case 3:
     			   echo "max-width: 190px; height: 160px;";
     			   break;
     			   case 4:
     			   echo "max-width: 190px; height: 190px;";
     			   break;
     			   case 5:
     			   echo "max-width: 190px; height: 220px;";
     			   break;
     			   case 6:
     			   echo "max-width: 190px; height: 250px;";
     			   break;
     			   case 7:
     			   echo "max-width: 190px; height: 280px;";
     			   break;
     			   case 8:
     			   echo "max-width: 190px; height: 310px;";
     			   break;
     			   case 9:
     			   echo "max-width: 190px; height: 340px;";
     			   break;
     			   case 10:
     			  echo "max-width: 190px; height: 370px;";
     			   break;
     			   case 11:
     			  echo "max-width: 190px; height: 400px;";
     			   break;
     			   case 12:
     			  echo "max-width: 190px; height: 450px;";
     			   break;
     			   case 13:
     			  echo "max-width: 190px; height: 480px;";
     			   break;
     			   case 14:
     			  echo "max-width: 190px; height: 480px;";
     			   break;
     			  default:
     			  echo "max-width: 190px; height: 100px;";
     			  break;   
     			
	      		
	      			}
	      
		}
	}
	
	function porcentaje($cantidad,$porciento,$decimales){
		return number_format($cantidad*$porciento/100 ,$decimales);
	}

	foreach ($products as $product) { 
	if($product['quantity'] != 0){
	?>
      <div class="item" style="background-color: white !important;padding-left: 10px;padding-top:10px;top:10px; position:relative; display:box;"> 
	      <?php if ($product['thumb']) {
			$height = 140;
			$url = str_replace(' ', '%20', $product['thumb']);
			//if (file_exists($product['thumb']) && ($data = getimagesize($product['thumb'])) ) {
			//if (@getimagesize($product['thumb']) && ($data = getimagesize($product['thumb'])) ) {
			if (@getimagesize($url) && ($data = getimagesize($url)) ) {
				if(@getimagesize($url)){
					$imagen = @getimagesize($url);    //Sacamos la información
					$ancho = $imagen[0];              //Ancho
					$alto = $imagen[1];  			  //Alto
					if($alto <= 140){
						$height = $alto;
					}else{
						$height = 140;
					}
				} else {
					$height = 140;
				}
			}
		  ?>
	      <div class="image" style = "max-width: 190px; height: 140px; padding-bottom: 3px;"; > <a href="<?php echo $product['href']; ?>"><img style="<?php echo 'max-width: 190px; height: ' . $height . 'px;' ?>"; src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
	      <?php } else{ ?>
			<div class="image" style = "max-width: 190px; height: 140px; padding-bottom: 3px;"; > <a href="<?php echo $product['href']; ?>"><img style="<?php echo 'max-width: 190px; height: 140px;' ?>"; src="http://socimagestion.com/image/noimage.jpg" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
		<?php } ?>
	      
	      <?php   $St = StockM($product['product_id'],$vConex);
	  if($St < 10)
	  {
   ?>

      <div class="description"><?php echo $product['description']; ?></div>
<div class="stock_tag">
			<div class="stock_image" style="background-image: url(image/data/stock_tags/stock_tag_rounded_gradient.png);background-position: -160px 0px;width: 80px;height: 25px;"></div><strong style="width: 80px;">Quedan <?php echo $St ?></strong>
		</div>
<?php } ?>
	<?php 	
		$porcentaje = porcentaje($product['StockInicial'], 10, 0);
	?>
	<?php if ($product['quantity'] < $porcentaje){ ?>
		</br><div>			
			<?php echo '<b>Quedan ' . $product['quantity'] . '</b>'; ?>
		</div>		
	<?php } ?>
		<div class="name" ><br/><a href="<?php echo $product['href']; ?>"><font size = "1"><?php echo $product['name'];?></font></a></div>
	    <div class="name" ><a href="<?php echo $product['href']; ?>"><font size = "1"><?php echo substr($product['description'],0,27);?></font></a></div>		
		<?php echo "Codigo: <strong>".$product['product_id']."</strong>"; ?>
		<?php echo ValorIndividual($product['product_id'],$vConex,$product['price'])  ?>
		
	
 
      <?php if($masonry_category_price_option) { ?>
	<?php if ($product['price']) { ?>
	<div class="price">
	
	  <?php if (!$product['special']) { ?>
	  <?php echo "<b>".$product['price']."</b>";?>
	  <?php } else { ?>
	  <span class="price-old"><?php echo "<b>".$product['price']."</b>"; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
	  <?php } ?>
	  <?php if ($product['tax']) { ?>
	  <br />
	  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
	  <?php } ?>
	</div>
	<?php } ?>

	<div class="moreless">
	
			<div style="width:35px; float:left; text-align:right;">
				<input id="cantidad_<?php echo $product['product_id']; ?>" onkeyup="this.value = formatValue(this.value)" onchange="this.value = revisarCantidad(<?php echo $product['product_id']; ?>)" type="text" value="1" size="1" maxlength="3" />
			</div>
			<div style="float:left;margin-left:10px;">
				<img src="image/morelessremove.png" alt="-" onclick="agregarMenos('<?php echo $product['product_id']; ?>');" style="cursor: pointer" width="25"></img>
			</div>
			<div style="margin-left:80px;">
				<img src="image/morelessadd.png" alt="+" onclick="agregarMas('<?php echo $product['product_id']; ?>');" style="cursor: pointer" width="25"></img>
			</div>
	  </div>
	  <div class="wishlist"><a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div>
	<!--<div class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>-->
	<?php if ($product['rating']) { ?>
	<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
	<?php } ?>

      <?php } ?>
  
	  <div class="cart" style="margin-bottom:0px !important;">
		<input type="button" value="<?php echo $button_cart; ?>" onclick="addProductToCart('<?php echo $product['product_id']; ?>');" class="button" style="width: 218px;margin-left: -10px;"/>
		
	   </div>
	  
      <?php if($masonry_category_add_wishlist) { ?>
	<div class="wishlist"><a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div>
      <?php } ?>

     <!-- <?php if($masonry_category_add_compare) { ?>
	<div class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>
      <?php }
		}	  ?>-->
    </div>
    </div>

<?php } ?>