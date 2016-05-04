<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product">
      <?php foreach ($products as $product) { ?>
      <div>
	  <div class="name"><a href="<?php echo $product['href']; ?>"
style="<?php echo $product['image_width']; ?>"
                        ><?php echo substr($product['name'],0,16); if(strlen($product['name'])>16) { echo "..."; }?></a></div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>">
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
                        <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
        <?php echo "<b>Codigo</b>: ".$product['product_id'];?>
        <?php if ($product['price']) { ?>
        <div class="price">
          <?php if (!$product['special']) { ?>
          <?php echo "<b>".$product['price']."</b>"; ?>
          <?php } else { ?>
          <span class="price-old"><?php echo "<b>".$product['price']."</b>"; ?></span> <span class="price-new"><?php echo "<b>".$product['special']."</b>"; ?></span>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($product['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
        <?php } ?>
        
        <div class="cart" style="position: absolute;width: 218px;height: 50px;margin-top: 10px;"><input type="button" value="<?php echo $button_cart; ?>" onclick="addToCart('<?php echo $product['product_id']; ?>');" class="button" /></div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>