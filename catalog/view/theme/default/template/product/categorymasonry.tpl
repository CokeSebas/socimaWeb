<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($thumb || $description) { ?>
  <div class="category-info">
    <?php if ($thumb) { ?>
    <div class="image" ><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <?php if ($description) { ?>
    <?php echo $description; ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if ($categories) { ?>
  <h2><?php echo $text_refine; ?></h2>
  <div class="category-list">
    <?php if (count($categories) <= 5) { ?>
    <ul>
      <?php foreach ($categories as $category) { ?>
      <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <?php for ($i = 0; $i < count($categories);) { ?>
    <ul>
      <?php $j = $i + ceil(count($categories) / 4); ?>
      <?php for (; $i < $j; $i++) { ?>
      <?php if (isset($categories[$i])) { ?>
      <li><a href="<?php echo $categories[$i]['href']; ?>"><?php echo $categories[$i]['name']; ?></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if ($products) { ?>
  

  <script> 
function abrir(url) { 
open(url,'','top=350,left=2000,width=700,height=350') ; 
} 
</script> 
    <div class="product-filter">
 
      <img src="http://socimagestion.com/image/Icon_pdf.gif"/> &nbsp; 
      <!--<a href ="javascript:abrir('http://socimagestion.com/Mejora/tcpdf/examples/generatorcategory.php?id=<?php echo $category_id; ?>')" targetget="_blank" />Enviar por Correo</a>-->
      <a href ="http://socimagestion.com/Mejora/tcpdf/examples/generatorcategory.php?id=<?php echo $category_id; ?>&tipo=enviar" target="_blank" />Enviar por Correo</a>
	  
	  <img src="http://socimagestion.com/image/Icon_pdf.gif"/> &nbsp; 
      <!--<a href ="javascript:abrir('http://socimagestion.com/Mejora/tcpdf/examples/generatorcategory.php?id=<?php echo $category_id; ?>')" target="_blank" />Ver PDF</a>-->
      <a href ="http://socimagestion.com/Mejora/tcpdf/examples/generatorvercategory.php?id=<?php echo $category_id; ?>&tipo=ver" target="_blank" />Ver PDF</a>
     

<?php
       if($masonry_category_limit_option) { ?>
	<div class="limit"><?php echo $text_limit; ?>
	  <select onchange="location = this.value;">
	    <?php foreach ($limits as $limits) { ?>
	    <?php if ($limits['value'] == $limit) { ?>
	    <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
	    <?php } else { ?>
	    <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
	    <?php } ?>
	    <?php } ?>
	  </select>
	</div>
      <?php } ?>
	
      <?php if($masonry_category_sort_option) { ?>
      <div class="sort"><b><?php echo $text_sort; ?></b>
	<select onchange="location = this.value;">
	  <?php foreach ($sorts as $sorts) { ?>
	  <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
	  <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
	  <?php } else { ?>
	  <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
	  <?php } ?>
	  <?php } ?>
	</select>
      </div>
      <?php } ?>
    </div>

   <!-- <?php if($masonry_category_add_compare) { ?>
      <div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
    <?php } ?>-->


    <div id="item-container" class="product-grid" style="margin-top: 10px;">
<?php 
	include('basededatos.php');
	$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
function ValorIndividual($product_id,$vConex,$precio)
	     {
	      
	      $vSqlCantidadRecomendada = "select text from oc_product_attribute where product_id = $product_id and attribute_id = 20";
	      $Resultado =  mysqli_query($vConex,$vSqlCantidadRecomendada);
	      $RR = "";
		  //var_dump($Resultado);
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
	      	    
	      	     $R2 = " <br> <b>$".ceil($ValorIndividual)." c/u<br><br></b>";
	      	     $RR .= $R2; 
	      	   } }
	      	 
                return $RR;
	      }
function Ancho($vConex,$Codigo){
		$sql = "select length, width, height from oc_product where product_id = $Codigo";
		$Resultado =  mysqli_query($vConex,$sql);
		while($vArreglo = mysqli_fetch_row($Resultado))
	      {
     			switch((int)$vArreglo[0])
     			{
     			   case 1:
     			   echo "max-width :190px; height: auto;";
     			   break;
     			   case 2:
     			   echo "max-width :190px; height: 170px;";
     			   break;
     			   case 3:
     			   echo "max-width :190px; height: 200px;";
     			   break;
     			   case 4:
     			   echo "max-width :190px; height: 230px;";
     			   break;
     			   case 5:
     			   echo " max-width :190px; height: 260px;";
     			   break;
     			   case 6:
     			   echo " max-width :190px;height: 290px;";
     			   break;
     			   case 7:
     			   echo " max-width :190px;height: 320px;";
     			   break;
     			   case 8:
     			   echo "max-width :190px; height: 350px;";
     			   break;
     			   case 9:
     			   echo " max-width :190px;height: 380px;";
     			   break;
     			   case 10:
     			  echo " max-width :190px;height: 410px;";
     			   break;
     			   case 11:
     			  echo "max-width :190px; height: 440px;";
     			   break;
     			   case 12:
     			  echo "max-width :190px;height: 470px;";
     			   break;
     			   case 13:
     			  echo "max-width :190px; height: 500px;";
     			   break;
     			   case 14:
     			  echo "max-width :190px; height: 530px;";
     			   break;
     			  default:
     			  echo " max-width :190px;height: 140px;";
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
		  
			/*if(@getimagesize($product['thumb'])){
				$imagen = @getimagesize($product['thumb']);    //Sacamos la información
				$ancho = $imagen[0];              //Ancho
				$alto = $imagen[1];  			  //Alto
				if($alto <= 140){
					$height = $alto;
				}else{
					$height = 140;
				}
			}*/
		  ?>
	      <div class="image" style = "max-width: 190px; height: 140px; padding-bottom: 3px;"; > <a href="<?php echo $product['href']; ?>"><img style="<?php echo 'max-width: 190px; height: ' . $height . 'px;' ?>"; src="<?php echo $product['thumb']; ?>" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
	      <?php } else{ ?>
			<div class="image" style = "max-width: 190px; height: 140px; padding-bottom: 3px;"; > <a href="<?php echo $product['href']; ?>"><img style="<?php echo 'max-width: 190px; height: 140px;' ?>"; src="http://socimagestion.com/image/noimage.jpg" title="<?php echo $product['name']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
		<?php } ?>
	      
	    <div class="description"><?php echo $product['description']; ?></div>
	<?php 	
		$porcentaje = porcentaje($product['StockInicial'], 10, 0);
	?>
	<?php if ($product['quantity'] < $porcentaje){ ?>
		</br><div>			
			<?php echo '<b>Quedan ' . $product['quantity'] . '</b>'; ?>
		</div>		
	<?php } ?>
	
	     <div class="name" ><br/><a href="<?php echo $product['href']; ?>"><font size = "1"><?php echo $product['name'];?></font></a></div>
	     <div class="name" ><a href="<?php echo $product['href']; ?>"><font size = "1"><?php echo $product['description'];?></font></a></div>
		<?php echo "Codigo: <strong>".$product['product_id']."</strong>"; ?>
                <?php echo ValorIndividual($product['product_id'],$vConex,$product['price'])  ?>
		 
	      <?php if($masonry_category_price_option) { ?>
		<?php if ($product['price']) { ?>
		<div class="price">
		  <?php if (!$product['special']) { ?>
		  
		  <?php echo "<b>".$product['price']."</b>";?>
		  <?php } else { ?>
		  <span class="price-old"><?php echo "<b>".$product['price']."</b>"; ?></span> <span class="price-new"><?php echo "<b>".$product['special']."</b>"; ?></span>
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

	      <div class="cart" style="margin-bottom:0px !important;background-color:#2d9821;margin-left:0px;">
	      <center>
		<input type="button" value="<?php echo $button_cart; ?>" onclick="addProductToCart('<?php echo $product['product_id']; ?>');" class="button" style="width: 218px;margin-left: -10px;"/>
	      </center>
	      </div>

	      <?php if($masonry_category_add_wishlist) { ?>
		<div class="wishlist"><a onclick="addToWishList('<?php echo $product['product_id']; ?>');"><?php echo $button_wishlist; ?></a></div>
	      <?php } ?>

	     <!--<?php if($masonry_category_add_compare) { ?>
		<div class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>
	      <?php } ?>-->
	    </div>
	<?php }
	} ?>
    </div>
    
    <nav id="page-nav">
	<a href="<?php echo $masonry_url; ?>"></a>
    </nav>
    
  <?php } ?>
  
  <?php if (!$categories && !$products) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php } ?>
  
  <?php echo $content_bottom; ?>
</div>
<script type="text/javascript"><!--
function revisarCantidad(id) {
	cantidad = $('#cantidad_' + id).val();
	if (cantidad == '') {
		return 1;
	} else {
		return cantidad;
	}
}

function addProductToCart(id) {
	cantidad = $('#cantidad_' + id).val();
	//if () {
		addToCart(id, cantidad);
	//}
}

function agregarMas(id) {
	cantidad = $('#cantidad_' + id).val();
	if (cantidad != 999) {
		cantidad++;
	}
	$('#cantidad_' + id).val(cantidad);
}

function formatValue(valor) {
	if (valor.length > 3) {
		return valor;
	} else {
		var cont = 0, tmp_valor = "", i = 0, valor2 = "";
		for (i = 0; i < valor.length; i++) {
			if (valor.charAt(i) == "0" || valor.charAt(i) == "1" || valor.charAt(i) == "2" || valor.charAt(i) == "3" || valor.charAt(i) == "4" || valor.charAt(i) == "5" || valor.charAt(i) == "6" || valor.charAt(i) == "7" || valor.charAt(i) == "8" || valor.charAt(i) == "9") {
				if (valor.charAt(0) != "0") {
					valor2 = valor2 + valor.charAt(i);
				}
			}
		}
		for (i = valor2.length - 1; i >= 0; i--){
			tmp_valor = valor2.charAt(i) + tmp_valor;
			cont++;	
		}
		return tmp_valor;
	}
}

function agregarMenos(id) {
	cantidad = $('#cantidad_' + id).val();
	if (cantidad > 1) {
		cantidad--;
		$('#cantidad_' + id).val(cantidad);
	}
}
//--></script>
<?php echo $footer; ?>