<?php echo $header; ?>


<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  

  <h1>Cuenta Cliente</h1>
  <div class="tile-stats tile-neon-red" style="width:400px;">
            <div class="icon"><i class="entypo-attention"></i></div>
            <div class="num" data-start="<?php echo number_format($credito,0,',','.'); ?>" data-end="<?php echo number_format($credito,0,',','.'); ?>" data-postfix="" data-duration="2000" data-delay="0">
            <?php echo number_format($credito,0,',','.'); ?>
            </div>
            <h3>Credito Disponible</h3> 
        </div>
  <h2><?php echo $text_my_account; ?></h2>
<div class="content">
    <ul>
      <div style="float: left; width: 180px; margin-bottom: 10px; padding: 5px; border:1px solid #E5E5E5; margin-right:15px;"><a href="<?php echo $edit; ?>"><img src="http://socimagestion.com/catalog/view/theme/default/image/account-images/edit.png" alt="Account Details" style=" margin-left: 60px;">
<p style="margin-top: 20px; text-align:center;"><?php echo $text_edit; ?></p></a></div>


     <div style="float: left; width: 200px; margin-bottom: 10px; padding: 5px; border:1px solid #E5E5E5; margin-right:15px;"><a href="<?php echo $address; ?>"><img src="http://socimagestion.com/catalog/view/theme/default/image/account-images/address.png" alt="Address Book" style=" margin-left: 60px;">
<p style="margin-top: 20px; text-align:center; "><?php echo $text_address; ?></p></a></div>

     <div style="float: left; width: 180px; margin-bottom: 10px; padding: 5px; border:1px solid #E5E5E5; margin-right:15px;"><a href="<?php echo $wishlist; ?>"><img src="http://socimagestion.com/catalog/view/theme/default/image/account-images/wishlist.png" alt="Wish List" style="margin-left: 60px; ">
<p style="margin-top: 20px; text-align:center;">Venta Preparada</p></a></div>
    </ul>
    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/custom.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
</div>
  

  <h2><?php echo $text_my_orders ?></h2>
  <div class="content">
    <ul>
     <div style="float: left; width: 180px; margin-bottom: 10px; padding: 5px; border:1px solid #E5E5E5; margin-right:15px;"><a href="<?php echo $order; ?>"><img src="http://socimagestion.com/catalog/view/theme/default/image/account-images/orders.png" alt="Order History" style=" margin-left: 60px;">
<p style="margin-top: 20px; text-align:center;"><?php echo $text_order; ?></p></a></div>

      <?php if ($reward) { ?>
      <li><a href="<?php echo $reward; ?>"><?php echo $text_reward; ?></a></li>
      <?php } ?>
        <div style="float: left; width: 180px; margin-bottom: 10px; padding: 5px; border:1px solid #E5E5E5; margin-right:15px;"><a href="<?php echo $transaction; ?>"><img src="http://socimagestion.com/catalog/view/theme/default/image/account-images/trans.png" alt="Transactions" style=" margin-left: 60px;">
<p style="margin-top: 20px; text-align:center;"><?php echo $text_transaction; ?></p></a></div>

    </ul>
  </div>
  

  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 
