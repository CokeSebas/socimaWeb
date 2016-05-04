<?php 
	include('basededatos.php');
	$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
function ValorIndividual($product_id,$vConex,$precio)
	     {
	      
	      $vSqlCantidadRecomendada = "select text from oc_product_attribute where product_id = $product_id and attribute_id = 25";
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
	      	    
	      	     $R2 = " <br> <b>$".ceil($ValorIndividual)." c/u Aprox<br><br></b>";
	      	     $RR .= $R2; 
	      	   } }
	      	 
                return $RR;
	      }
	function Ancho($Codigo){
		$sql = "select length, width, height from oc_product where product_id = $Codigo";
		$Resultado =  mysqli_query($GLOBALS['vConex'],$sql);
		while($vArreglo = mysqli_fetch_row($Resultado))
	      {
	      	if ((Int)$vArreglo[1] == 0 && (Int)$vArreglo[2] == 0)
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
	      	else
	      	{
	      	echo "width: (int)$vArreglo[1]px; height: (int)$vArreglo[2]px;";
	      }
		}
	}

	
	foreach ($products as $product) { 
			if($product['quantity'] !=0){
	?>
	    <div class="item" style="background-color: white !important;padding-left: 10px;padding-top:10px;top:10px; position:relative; display:box;">

      <?php if ($product['thumb']) { ?>
	      <div class="image" style = "<?php  echo Ancho($product['product_id'])?> padding-bottom: 20px;"; > <a href="<?php echo $product['href']; ?>"><img style="<?php echo Ancho($product['product_id'])?>"; src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
	      <?php }?>
      
     
      
      
 <div class="description"><?php echo $product['description']; ?></div>
      <?php if (isset($product['discount'])){ ?>
		<div class="discount_tag">
			<div class="discount_image" style="<?php echo $product['discount']; ?>"></div><strong <?php echo $product['discount_width']; ?>><?php echo $product['discount_text']?></strong>
		</div>
	<?php } ?>
	<?php if (isset($product['stock'])){ ?>
		<div class="stock_tag">
			<div class="stock_image" style="<?php echo $product['stock']; ?>"></div><strong <?php echo $product['stock_width']; ?>><?php echo $product['stock_text']?></strong>
		</div>
	<?php } ?>
	<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
      
		<?php echo "Codigo: <strong>".$product['product_id']."</strong>"; ?>                
		<?php echo ValorIndividual($product['product_id'],$vConex,$product['price'])  ?>
		 

      <?php if($masonry_search_price_option) { ?>
	<?php if ($product['price']) { ?>
	<div class="price"><strong>
	  <?php if (!$product['special']) { ?>
	  <?php echo $product['price']; ?>
	  <?php } else { ?>
	  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
	  <?php } ?>
	  <?php if ($product['tax']) { ?>
	  <br />
	  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
	  <?php } ?>
	  </strong>
	</div>
	<?php } ?>
	
<div class="moreless">
		<div style="width:35px; float:left; text-align:right;">
			<input id="cantidad_<?php echo $product['product_id']; ?>" onkeyup="this.value = formatValue(this.value)" onchange="this.value = revisarCantidad(<?php echo $product['product_id']; ?>)" type="text" value="1" size="1" maxlength="3" />
		</div>
		<div style="float:left;margin-left:10px;">
			<img src="image/morelessadd.png" alt="+" onclick="agregarMas('<?php echo $product['product_id']; ?>');" style="cursor: pointer" width="25"></img>
		</div>
		<div style="margin-left:80px;">
			<img src="image/morelessremove.png" alt="-" onclick="agregarMenos('<?php echo $product['product_id']; ?>');" style="cursor: pointer" width="25"></img>
		</div>
	</div>
	
	<?php if ($product['rating']) { ?>
	<div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
	<?php } ?>
      <?php } ?>

      	 <div class="cart" style="margin-bottom:0px !important;">
		<input type="button" value="<?php echo $button_cart; ?>" onclick="addProductToCart('<?php echo $product['product_id']; ?>');" class="button" style="width: 218px;margin-left: -10px;margin-top: 10px;"/>
	  </div>

      <?php if($masonry_search_add_wishlist) { ?>
	<div class="wishlist"><a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div>
      <?php } ?>

      <?php if($masonry_search_add_compare) { ?>
	<!--<div class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>-->
      <?php } ?>
    </div>

<?php } 
	}?>