<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <b><?php echo $text_critea; ?></b>
  <div class="content">
    <p><?php echo $entry_search; ?>
      <?php if ($search) { ?>
      <input type="text" name="search" value="<?php echo $search; ?>" />
      <?php } else { ?>
      <input type="text" name="search" value="<?php echo $search; ?>" onclick="this.value = '';" onkeydown="this.style.color = '000000'" style="color: #999;" />
      <?php } ?>
      <select name="category_id">
        <option value="0"><?php echo $text_category; ?></option>
        <?php foreach ($categories as $category_1) { ?>
        <?php if ($category_1['category_id'] == $category_id) { ?>
        <option value="<?php echo $category_1['category_id']; ?>" selected="selected"><?php echo $category_1['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_1['category_id']; ?>"><?php echo $category_1['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_1['children'] as $category_2) { ?>
        <?php if ($category_2['category_id'] == $category_id) { ?>
        <option value="<?php echo $category_2['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_2['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_2['name']; ?></option>
        <?php } ?>
        <?php foreach ($category_2['children'] as $category_3) { ?>
        <?php if ($category_3['category_id'] == $category_id) { ?>
        <option value="<?php echo $category_3['category_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $category_3['category_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $category_3['name']; ?></option>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        <?php } ?>
      </select>
      <?php if ($sub_category) { ?>
      <input type="checkbox" name="sub_category" value="1" id="sub_category" checked="checked" />
      <?php } else { ?>
      <input type="checkbox" name="sub_category" value="1" id="sub_category" />
      <?php } ?>
      <label for="sub_category"><?php echo $text_sub_category; ?></label>
    </p>
    <?php if ($description) { ?>
    <input type="checkbox" name="description" value="1" id="description" checked="checked" />
    <?php } else { ?>
    <input type="checkbox" name="description" value="1" id="description" />
    <?php } ?>
    <label for="description"><?php echo $entry_description; ?></label>
  </div>
  <div class="buttons">
    <div class="right"><input type="button" value="<?php echo $button_search; ?>" id="button-search" class="button" /></div>
  </div>
  <h2><?php echo $text_search; ?></h2>
  <?php if ($products) { ?>
    <div class="product-filter">
	
      <?php if($masonry_search_limit_option) { ?>
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

      <?php if($masonry_search_sort_option) { ?>
      <div class="sort"><?php echo $text_sort; ?>
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
  
  <!--  <?php if($masonry_search_add_compare) { ?>
	<div class="product-compare"><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></div>
    <?php } ?>-->
  
  <div id="item-container" class="product-grid" style="margin-top: 10px;">
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

	    <div class="item" style="background-color: white !important;padding-left: 10px;padding-top:10px;top:10px;position:relative;display:box;">

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
	<div class="price" ><strong>
	  <?php if (!$product['special']) { ?>
	  <?php echo  $product['price']; ?>
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
      
     <!-- <?php if($masonry_search_add_compare) { ?>
	<div class="compare"><a onclick="addToCompare('<?php echo $product['product_id']; ?>');"><?php echo $button_compare; ?></a></div>
      <?php } ?>-->
      
    </div>
    <?php } 
	}?>
  </div>
  
  <nav id="page-nav">
    <a href="<?php echo $masonry_url; ?>"></a>
  </nav>
    
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <?php }?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#content input[name=\'search\']').keydown(function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').bind('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').attr('disabled', 'disabled');
		$('input[name=\'sub_category\']').removeAttr('checked');
	} else {
		$('input[name=\'sub_category\']').removeAttr('disabled');
	}
});

$('select[name=\'category_id\']').trigger('change');

$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';
	
	var search = $('#content input[name=\'search\']').attr('value');
	
	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').attr('value');
	
	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}
	
	var sub_category = $('#content input[name=\'sub_category\']:checked').attr('value');
	
	if (sub_category) {
		url += '&sub_category=true';
	}
		
	var filter_description = $('#content input[name=\'description\']:checked').attr('value');
	
	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

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