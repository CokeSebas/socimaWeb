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
				  $R = " || Pack: <b>$vArreglo[0]</b>";
				  $RR = $R;
				}
	      }
	      	 $vSqlCantidadPack = "select text from oc_product_attribute where product_id = $product_id and attribute_id = 20";
	      	 $Resultado2 =  mysqli_query($vConex,$vSqlCantidadPack);
	      	 $ValorIndividual;
	      	 while($vArreglo2 = mysqli_fetch_row($Resultado2))
	      	 {
	      	      $v = (int)$vArreglo2[0];
	      	      if($v > 0)
	      	      {
	      	      $precio2 =  str_replace("$",'',$precio);
	      	      $precio3 =  str_replace(".",'',$precio2);
	      	      $ValorIndividual = ( $precio3/ $v ) ;
	      	    
	      	     $R2 = " || <b>$".ceil($ValorIndividual)." c/u Aprox<br><br></b>";
	      	     $RR .= $R2; 
	      	    }
	      	 }
                return $RR;
	      }
		  
		  
		  function porcentaje($cantidad,$porciento,$decimales){
			return number_format($cantidad*$porciento/100 ,$decimales);
			}

		  
	     ?>
<script> 
function abrir(url) { 
open(url,'','top=350,left=2000,width=700,height=350') ; 
} 
</script>

<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>


  </div>
  <div class="product-info">
    <?php if ($thumb || $images) { ?>
    <div class="left">
      <?php if ($thumb) { ?>
	  
      <div class="image"><a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
	<!--<?php if (isset($discount_tag['discount'])){ ?>
		<div class="discount_tag">
			<a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox">
				<div class="discount_image" style="<?php echo $discount_tag['discount']; ?>"></div><strong <?php echo $discount_tag['discount_width']; ?>><?php echo $discount_tag['discount_text']?></strong>
			</a>
		</div>
	<?php } ?>
	<?php if (isset($discount_tag['stock'])){ ?>
		<div class="stock_tag">
			<a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox">
				<div class="stock_image" style="<?php echo $discount_tag['stock']; ?>"></div><strong <?php echo $discount_tag['stock_width']; ?>><?php echo $discount_tag['stock_text']?></strong>
			</a>
		</div>
	<?php } ?>-->
                        </div>
      <?php } ?>
      <?php if ($images) { ?>
      <div class="image-additional">
        <?php foreach ($images as $image) { ?>
			<?php if($image['thumb'] != null || $image['popup'] != null) { ?>
				<a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
			<?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
    <?php } ?>
    <div class="right">
      <div class="description">
      
      <h1><?php echo $heading_title; ?></h1>
	  <h4><?php echo $sub_heading; ?></h4></br>
	  
        
				<?php if( $manufacturer_image ) { ?>
				<img src="<?php echo $manufacturer_image; ?>" title="<?php echo $manufacturer; ?>" alt="<?php echo $manufacturer; ?>" class="image-manufacturer"/>
				<?php } ?>
			
        <?php if ($manufacturer) { ?>
	
        <?php } 
        ?>
        
 <img src="http://socimagestion.com/image/Icon_pdf.gif"/>&nbsp; <a href ="http://socimagestion.com/Mejora/tcpdf/examples/generator.php?id=<?php echo $sku; ?>" target="_blank"/>Enviar por correo</a><br>
 <img src="http://socimagestion.com/image/Icon_pdf.gif"/> &nbsp; <a href ="http://socimagestion.com/Mejora/tcpdf/examples/generatorProducto.php?id=<?php echo $sku; ?>&tipo=ver" target="_blank" />Ver PDF</a><br>


        <span><?php echo '<font size=3>' . $text_model . '</font>'; ?></span> <?php echo '<font size=3>'.$sku.'</font>'; ?><br />
        <?php if ($reward) { ?>
        <span><?php echo $text_reward; ?></span> <?php echo $reward; ?><br />
        <?php } ?>
		<?php $porcentaje = porcentaje($StockInicial, 10, 0);
			if($quantity < $porcentaje) { ?>
			<span><?php echo 'Quedan '; ?></span> <?php echo $quantity; ?>
		<?php } ?>
		</div>
        
       <?php 
      echo ValorIndividual($sku,$vConex,$price)
       ?>
      <?php if ($price) { ?>
      <div class="price"><?php echo $text_price; ?>
        <?php if (!$special) { ?>
        <?php echo $price; ?>
        <?php } else { ?>
        <span class="price-old"><?php echo $price; ?></span><br />
		<div class="price"><?php echo "Precio Oferta: "; ?><span class="price-new"><?php echo $special; ?></span>
        <?php } ?>
        <br />
        <!--<?php if ($tax) { ?>
        <span class="price-tax"><?php echo $text_tax; ?> <?php echo $tax; ?></span><br />
        <?php } ?>-->
        <?php if ($points) { ?>
        <span class="reward"><small><?php echo $text_points; ?> <?php echo $points; ?></small></span><br />
        <?php } ?>
        <?php if ($discounts) { ?>
        <br />
        <div class="discount">
          <?php foreach ($discounts as $discount) { ?>
          <?php echo sprintf($text_discount, $discount['quantity'], $discount['price']); ?><br />
          <?php } ?>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
     
      <?php if ($profiles): ?>
     
      <div class="option">
          <h2><span class="required">*</span><?php echo $text_payment_profile ?></h2>
          <br />
          <select name="profile_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($profiles as $profile): ?>
              <option value="<?php echo $profile['profile_id'] ?>"><?php echo $profile['name'] ?></option>
              <?php endforeach; ?>
          </select>
          <br />
          <br />
          <span id="profile-description"></span>
          <br />
          <br />
      </div>
      <?php endif; ?>
      <?php if ($options) { ?>
      <div class="options">
        <h2><?php echo $text_option; ?></h2>
        <br />
        <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'select') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <select name="option[<?php echo $option['product_option_id']; ?>]">
            <option value=""><?php echo $text_select; ?></option>
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
            </option>
            <?php } ?>
          </select>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <?php foreach ($option['option_value'] as $option_value) { ?>
          <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
          <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
            <?php if ($option_value['price']) { ?>
            (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
            <?php } ?>
          </label>
          <br />
          <?php } ?>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <table class="option-image">
            <?php foreach ($option['option_value'] as $option_value) { ?>
            <tr>
              <td style="width: 1px;"><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" /></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><img src="<?php echo $option_value['image']; ?>" alt="<?php echo $option_value['name'] . ($option_value['price'] ? ' ' . $option_value['price_prefix'] . $option_value['price'] : ''); ?>" /></label></td>
              <td><label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                  <?php if ($option_value['price']) { ?>
                  (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                  <?php } ?>
                </label></td>
            </tr>
            <?php } ?>
          </table>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" cols="40" rows="5"><?php echo $option['option_value']; ?></textarea>
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="button" value="<?php echo $button_upload; ?>" id="button-option-<?php echo $option['product_option_id']; ?>" class="button">
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="date" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="datetime" />
        </div>
        <br />
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div id="option-<?php echo $option['product_option_id']; ?>" class="option">
          <?php if ($option['required']) { ?>
          <span class="required">*</span>
          <?php } ?>
          <b><?php echo $option['name']; ?>:</b><br />
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['option_value']; ?>" class="time" />
        </div>
        <br />
        <?php } ?>
        <?php } ?>
      </div>
      <?php } ?>
	   <div class="cart">
        <div><?php echo $text_qty; ?>
			<script type="text/javascript">
				function quantityup() {
					if (document.getElementById("valor").value != 99999) {
						document.getElementById("valor").value++;
					}
				}
				function quantitydown(){
					if (document.getElementById("valor").value > 1) {
						document.getElementById('valor').value--;
					}
				}
				function formatValue(valor) {
					if (valor.length > 6) {
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
				function checkValue(value) {
					return value == '' ? 1 : value;
				}
			</script>
          <input type="text" id="valor" name="quantity" size="2" value="<?php echo $minimum; ?>" onkeyup="this.value = formatValue(this.value)" onblur="this.value = checkValue(this.value)"/><input type="button" id="valor2" class="flechaabajo" onclick="quantitydown()"><input type="button" class="flechaarriba" onclick="quantityup()">
          <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
          &nbsp;
          <input type="button" value="<?php echo $button_cart; ?>" id="button-cart" class="button" style="margin-left:0px;" />
          <span>&nbsp;&nbsp;<?php echo $text_or; ?>&nbsp;&nbsp;</span>
          <span class="links"><a onclick="addToWishList('<?php echo $product_id; ?>');"><?php echo $button_wishlist; ?></a><br />
            <!--<a onclick="addToCompare('<?php echo $product_id; ?>');"><?php echo $button_compare; ?></a></span>-->
        </div>
        <?php if ($minimum > 1) { ?>
        <div class="minimum"><?php echo $text_minimum; ?></div>
        <?php } ?>
      </div>
	   <?php if ($attribute_groups) { ?>
	   
			<?php $att_total = count($attribute_groups[0]['attribute']);?>
			<table class="attribute" style="width:75%;">
			
			<?php $values = array();?>
			<?php for ($i=0; $i<$att_total; $i++) { $values[$i] = $attribute_groups[0]['attribute'][$i]['name'] . ': ' . $attribute_groups[0]['attribute'][$i]['text'];  } ?>
         
			<tbody>
			
			<?php for($c=0;$c<count($values);$c++) { ?>
				<tr>
					<td style="font-weight:normal;text-align:center;color:#4D4D4D;width:250px;"><?php echo $values[$c];?></td>
					<?php $c++; ?>
					<?php if(isset($values[$c])) { ?>
					<td style="font-weight:normal;text-align:center;color:#4D4D4D;width:250px;"><?php echo $values[$c]; ?></td>
					<?php } else { ?>
						<td style="font-weight:normal;text-align:center;color:#4D4D4D;width:250px;"></td>
					<?php } ?>
				</tr>
			<?php } ?>	
				
				
			</tbody>
			
			</table>
		
		<?php } ?>
     
      <div id="tabs" class="htabs"><a href="#tab-description"><?php echo $tab_description; ?></a>
    
    <?php if ($review_status) { ?>
    <a href="#tab-review"><?php echo $tab_review; ?></a>
    <?php } ?>
    <?php if ($products) { ?>
    <a href="#tab-related"><?php echo 'Productos Relacionados'; ?> (<?php echo count($products); ?>)</a>
    <?php } ?>
  </div>
    <div id="tab-description" class="tab-content" style="margin-left: 14% !important;width: 73%;"><?php echo $description; ?></div>

 
  <?php if ($review_status) { ?>
  <div id="tab-review" class="tab-content" >
    <div id="review"></div>
    <h2 id="review-title"><?php echo $text_write; ?></h2>
    <b><?php echo $entry_name; ?></b><br />
    <input type="text" name="name" value="" />
    <br />
    <br />
    <b><?php echo $entry_review; ?></b>
    <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
    <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
    <br />
  
    <input type="radio" name="rating" value="5" style="visibility:hidden"  checked />

    <div class="buttons">
      <div class="right"><a id="button-review" class="button" style="color: #F5ECEC"><?php echo $button_continue; ?></a></div>
    </div>
  </div>
  <?php } ?>
  <?php if ($products) { ?>
  <div id="tab-related" class="tab-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
           <?php if ($product['thumb']) { ?>
          <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        
        <?php } echo "<br><br><br><br><br><br><br>"; ?>
        <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo "<font size= 1>".$product['name']."</font>" ?></a></div>
    
        <?php echo "&nbsp;&nbsp;Codigo : <b>".$product['product_id']."</b><br>"?>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo $product['price']; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button"style="color: #F5ECEC;"><?php echo $button_cart; ?></a></div>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
  <?php if ($tags) { ?>
  <div class="tags" style="display:none;"><b><?php echo $text_tags; ?></b>
    <?php for ($i = 0; $i < count($tags); $i++) { ?>
    <?php if ($i < (count($tags) - 1)) { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
    <?php } else { ?>
    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>
    </div>
  </div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.colorbox').colorbox({
		overlayClose: true,
		opacity: 0.5,
		rel: "colorbox"
	});
});
//--></script> 
<script type="text/javascript"><!--

$('select[name="profile_id"], input[name="quantity"]').change(function(){
    $.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name="product_id"], input[name="quantity"], select[name="profile_id"]'),
		dataType: 'json',
        beforeSend: function() {
            $('#profile-description').html('');
        },
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
            
			if (json['success']) {
                $('#profile-description').html(json['success']);
			}	
		}
	});
});
    
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();
			
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
                
                if (json['error']['profile']) {
                    $('select[name="profile_id"]').after('<span class="error">' + json['error']['profile'] + '</span>');
                }
			} 
			
			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
				$('.success').fadeIn('slow');
					
				$('#cart-total').html(json['total']);
				
				$('html, body').animate({ scrollTop: 0 }, 'slow'); 
			}	
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
		
		$('.error').remove();
		
		if (json['success']) {
			alert(json['success']);
			
			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}
		
		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}
		
		$('.loading').remove();	
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');
		
	$('#review').load(this.href);
	
	$('#review').fadeIn('slow');
	
	return false;
});			

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	if ($.browser.msie && $.browser.version == 6) {
		$('.date, .datetime, .time').bgIframe();
	}

	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	$('.datetime').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'h:m',
	});
	$('.time').timepicker({timeFormat: 'h:m'});
});
//--></script> 
<!-- BOF om_Thumb_image_swap.xml -->
<?php if ($images) { ?>
<script type="text/javascript"><!--
$(function(){
	var imgs = <?php echo json_encode($images); ?>;
	var html = '';
	$.each(imgs,function(i,image){
		html += '<div class="image" style="display:none;"><a href="' + image.popup + '" title="<?php echo $heading_title; ?>" class="colorbox">';
		html += '<img src="' + image.addthumb + '" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></div>';
		$('.image-additional').before(html);
		html = '';
	})
	html = '<a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>">';
	html += '<img src="<?php echo $thumb; ?>" width="<?php echo $this->config->get('config_image_additional_width'); ?>" height="<?php echo $this->config->get('config_image_additional_height'); ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>';
	$('.image-additional').prepend(html);
	var images = $('div.left .image');
	var thumbs = $('.image-additional a');
	thumbs.removeClass('cboxElement').removeClass('colorbox');
	images.children('a').colorbox({rel:'colorbox'});
	thumbs.on('click',function(e){
		e.preventDefault();
		images.hide();
		images.eq(thumbs.index(this)).show();
	});
});
//--></script>
<!-- EOF om_Thumb_image_swap.xml -->
<?php } ?>
<?php echo $footer; ?>