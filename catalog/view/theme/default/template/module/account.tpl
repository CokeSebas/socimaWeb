<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <ul>
      <?php if (!$logged) {
     
      
     echo "<li><a href=admin/index.php?route=sale/customer&token=".$_SESSION['Tk'].">  Clientes </a></li>";
      
      ?>
     
      <?php } ?> 
      <?php if ($logged) { ?>
      <?php } ?>
      <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
      <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
      <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
      <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
      <li><a href="<?php echo $transaction; ?>"><?php echo $text_transaction; ?></a></li>
      <?php if ($logged) { ?>
      <li><a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a></li>
      <?php } ?>
    </ul>
  </div>
</div>