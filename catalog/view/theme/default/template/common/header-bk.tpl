<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/styles.css" />
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<script type="text/javascript" src="catalog/view/javascript/ajaxsearch2.js"></script>
<script type="text/javascript" src="catalog/view/javascript/script.js"></script>
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>
<?php echo $google_analytics; ?>
</head>
<body>
<div id="catmenu">
	<div id="catmenu-logo">
		<a href="<?php echo $home; ?>"><img src="catalog/view/theme/default/image/logosocima.png"/></a>
	</div>
	<div id="cssmenu">
		<?php if ($categories) { ?>
			<ul>	
				<li class='active'><a href='#'><span>INICIO</span></a></li>
				<?php foreach ($categories as $category) { ?>
					<li class='has-sub'><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?><img class="rotate-none" src="catalog/view/theme/default/image/arrow.png" style="position: absolute;margin-top: 1.3em;right: 1em;" /></a>
						<?php if ($category['children']) { ?>
							<?php for ($i = 0; $i < count($category['children']);) { ?>
								<ul>
									<?php $j = $i + ceil(count($category['children']) / 1); ?>
									<?php for (; $i < $j; $i++) { ?>
										<?php if (isset($category['children'][$i])) { ?>
											<li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
										<?php } ?>
									<?php } ?>
								</ul>
							<?php } ?>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
		<?php } ?> 
	</div>
</div>
<div id="hidescroller"/></div>
<div id="topinfo">
	<div class="wishlist"><a href="<?php echo $wishlist; ?>" style="text-decoration: none;line-height: 4;font-size: 15px;color: #FFFFFF;font-weight: bold;">Preparar Venta</a></div><?php echo $cart; ?>
</div>
<div id="header" style="width:70%;height:57px;margin-top:-66px;margin-left:19% !important;background: #e0e0e0;background: -moz-linear-gradient(top, #e0e0e0 0%, #f4f4f4 25%, #f4f4f4 75%, #e0e0e0 100%);background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#e0e0e0), color-stop(25%,#f4f4f4), color-stop(75%,#f4f4f4), color-stop(100%,#e0e0e0));background: -webkit-linear-gradient(top, #e0e0e0 0%,#f4f4f4 25%,#f4f4f4 75%,#e0e0e0 100%); background: -o-linear-gradient(top, #e0e0e0 0%,#f4f4f4 25%,#f4f4f4 75%,#e0e0e0 100%);background: -ms-linear-gradient(top, #e0e0e0 0%,#f4f4f4 25%,#f4f4f4 75%,#e0e0e0 100%);background: linear-gradient(to bottom, #e0e0e0 0%,#f4f4f4 25%,#f4f4f4 75%,#e0e0e0 100%);">
  <div id="search">
    <div class="button-search"></div>
    <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
    <div style="position: absolute;margin-left: 27em;width: 350px;margin-top: -20px;">
	<?php if (!$logged) { ?>
    <?php echo $text_welcome; ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?></div>
</div>
</div>  
<div id="container">
<div id="header">
  <?php if ($logo) { ?>
  <div id="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
  <?php } ?>
  <?php echo $language; ?>
  <?php echo $currency; ?>
<div class="links"><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a><a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a><a href="<?php echo $shopping_cart; ?>"><?php echo $text_shopping_cart; ?></a><a href="<?php echo $checkout; ?>"><?php echo $text_checkout; ?></a></div>
</div>

<?php if ($error) { ?>
    
    <div class="warning"><?php echo $error ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
    
<?php } ?>
<div id="notification"></div>
