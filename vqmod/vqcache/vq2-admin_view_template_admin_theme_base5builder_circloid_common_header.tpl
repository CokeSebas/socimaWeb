<?php


if(isset($this->request->get['route'])){
	$current_location = explode("/", $this->request->get['route']);
	if($current_location[0] == "common"){
		$is_homepage = TRUE;
	}else{
		$is_homepage = FALSE;
	}
}else{
	$is_homepage = FALSE;
}

if(isset($this->request->get['route'])){
	if($this->request->get['route'] == "common/login"){
		$is_custom_page = FALSE;
	}
}
if(!isset($this->request->get['route'])){
	$is_custom_page = FALSE;
}

$is_kuler = array("module/kbm", "module/kbm_mod_archive", "module/kbm_mod_article_tag", "module/kbm_mod_category", "module/kbm_mod_latest_comment", "module/kbm_mod_popular_article", "module/kbm_mod_recent_article", "module/kuler_accordion", "module/kuler_advanced_html", "module/kuler_css3_slideshow", "module/kuler_filter", "module/kuler_finder", "module/kuler_layer_slider", "module/kuler_menu", "module/kuler_newsletter","module/kuler_sitetools" ,"module/kuler_slides", "module/kuler_social_icons", "module/kuler_tabs", "module/kulercp", "module/kuler_layer_slider/layer", "module/kuler_layer_slider/preview", "module/kuler_layer_slider/previewgroup", "module/kuler_layer_slider/sliders", "module/kuler_layer_slider/typo");

?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
	<meta charset="utf-8">
	<title><?php echo $title; ?></title>
	<base href="<?php echo $base; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<?php foreach ($links as $link) { ?>
	<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
	<?php } ?>

	<!-- Le styles -->
	<?php if(!$is_custom_page){ ?>
		<link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/bootstrap.css" rel="stylesheet" />
		<link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/style.css" rel="stylesheet" />
		<?php if(isset($css_detail['css_name']) && ($css_detail['css_name'] != "default-profile")){?>
			<link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/color_profiles/<?php echo $css_detail['css_name']; ?>.css" rel="stylesheet" />
		<?php } ?>
		<link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/bootstrap-responsive.css" rel="stylesheet" />
		<link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/datepicker.css" rel="stylesheet" />
		<link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/style-responsive.css" rel="stylesheet" />
	<?php }else{ ?>
		<?php if(!$logged){ ?>
			<link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/bootstrap.css" rel="stylesheet" />
		<?php } ?>
		<link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/style-custom-page.css" rel="stylesheet" />
		<?php if(isset($css_detail['css_name']) && ($css_detail['css_name'] != "default-profile")){?>
			<link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/color_profiles/<?php echo $css_detail['css_name']; ?>.css" rel="stylesheet" />
		<?php } ?>
	<?php } ?>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link type="text/css" href="view/javascript/admin_theme/base5builder_circloid/ui/themes/ui-lightness/jquery-ui-1.8.20.custom-min.css" rel="stylesheet" />
	<?php if(!$is_custom_page){ ?>
		<link type="text/css" href='view/stylesheet/admin_theme/base5builder_circloid/color_picker/spectrum.css' rel='stylesheet' />
	<?php } ?>
	<?php
	if(isset($this->request->get['route'])){
		if(in_array($this->request->get['route'], $is_kuler)){
			?>
			<link type="text/css" href='view/stylesheet/admin_theme/base5builder_circloid/style-kuler-fix.css' rel='stylesheet' />
			<?php
		}
		if($this->request->get['route'] == "module/journal2"){
			?>
			<link type="text/css" href='view/stylesheet/admin_theme/base5builder_circloid/style-journal2-fix.css' rel='stylesheet' />
			<?php
		}
	}
	?>
	  <!--[if IE 7]>
	  <link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/style-ie7.css" rel="stylesheet">
	  <![endif]-->
	  <!--[if IE 8]>
	  <link type="text/css" href="view/stylesheet/admin_theme/base5builder_circloid/style-ie8.css" rel="stylesheet">
	  <![endif]-->
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/jquery.1.7.2.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/ui/jquery-ui-1.8.20.custom.min.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/misc/tabs.js"></script>
	  <?php foreach ($styles as $style) { ?>
	  <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
	  <?php } ?>
	  <?php foreach ($scripts as $script) { ?>
	  <script type="text/javascript" src="<?php echo $script; ?>"></script>
	  <?php } ?>
	  <?php if($this->user->getUserName() && $is_homepage){ ?>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/flot/jquery.flot.min.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/flot/jquery.flot.pie.min.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/flot/jquery.flot.tooltip.min.js"></script>
	  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/misc/modernizr.js"></script>
		<!--[if lte IE 8]>
		<script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/misc/excanvas.min.js"></script>
		<![endif]-->
		<?php } ?>
		<script type="text/javascript">
		$(document).ready(function(){

		// Signin - Button

		$(".form-signin-buttons input").click(function(){
			$(".form-signin").submit();
		});

		// Signin - Enter Key

		$('.form-signin input').keydown(function(e) {
			if (e.keyCode == 13) {
				$('.form-signin').submit();
			}
		});

	    // Confirm Delete
	    $('#form').submit(function(){
	    	if ($(this).attr('action').indexOf('delete',1) != -1) {
	    		if (!confirm('<?php echo $text_confirm; ?>')) {
	    			return false;
	    		}
	    	}
	    });

		// Confirm Uninstall
		$('a').click(function(){
			if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall', 1) != -1) {
				if (!confirm('<?php echo $text_confirm; ?>')) {
					return false;
				}
			}
		});
	});
		</script>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
  <script type="text/javascript" src="view/javascript/admin_theme/base5builder_circloid/misc/html5shiv.js"></script>
  <![endif]-->
  
  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="view/image/admin_theme/base5builder_circloid/ico/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="view/image/admin_theme/base5builder_circloid/ico/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="view/image/admin_theme/base5builder_circloid/ico/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="view/image/admin_theme/base5builder_circloid/ico/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="view/image/admin_theme/base5builder_circloid/ico/favicon.png">
  <?php

// Fix Non-Responsive Soles/Order page
if(isset($this->request->get['route'])){
	if(($this->request->get['route'] == "sale/order/info") || ($this->request->get['route'] == "sale/order/update")){
		?>
		<style type="text/css">
		.box .content{
			overflow-x: auto;
		}
		.vtabs-content{
			min-width: 500px;
		}
		</style>
		<?php
	}

	if($this->request->get['route'] == "sale/order/update"){
		?>
		<style type="text/css">
		.vtabs-content{
			margin-left: 15px;
		}
		</style>
		<?php
	}
}
  ?>

		  
      <?php if ($this->request->get): ?>
	  <?php if ($this->request->get['route'] === 'catalog/product/update' || $this->request->get['route'] === 'catalog/product/insert'): ?>

<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="view/javascript/jquery-file-upload/css/bootstrap.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="view/javascript/jquery-file-upload/css/style.css">
<!-- Bootstrap styles for responsive website layout, supporting different screen sizes -->
<link rel="stylesheet" href="view/javascript/jquery-file-upload/css/bootstrap-responsive.min.css">
<!-- Bootstrap CSS fixes for IE6 -->
<!--[if lt IE 7]><link rel="stylesheet" href="view/javascript/jquery-file-upload/css/bootstrap-ie6.min.css"><![endif]-->
<!-- Bootstrap Image Gallery styles -->
<link rel="stylesheet" href="view/javascript/jquery-file-upload/css/bootstrap-image-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="view/javascript/jquery-file-upload/css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="view/javascript/jquery-file-upload/css/jquery.fileupload-ui-noscript.css"></noscript>
<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

<!-- Bootstrap collistions FIX -->
<style type="text/css">
    h1, h2, h3 {
        line-height: 20px;
    }
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        line-height: 10px;
        padding-top: 0;
    }
    select#range {
        height: 10px;
        line-height: 10px;
    }
    #form #tab-image .container {
        margin-right: 0;
        margin-left: 0;
    }

    table.list input, textarea, .uneditable-input {
        width: auto;
    }

    #form input[name^=product_description] {
        width: 500px;
    }

    #form textarea[name^=product_description] {
        width: 500px;
        height: 200px;
    }

    #form #tab-option input, textarea, keygen, select, button, isindex {
        margin: 0em;
        font: -webkit-small-control;
        color: initial;
        letter-spacing: normal;
        word-spacing: normal;
        text-transform: none;
        text-indent: 0px;
        text-shadow: none;
        display: inline-block;
        text-align: start;
        width: auto;
        height: auto;
    }

    #tab-image #images {
        display: none;
    }

    /* Disable start button for image uploader */
    .btn.btn-primary.start {
        display: none;
    }

    /* Disable cancel upload button */
    .btn.btn-warning.cancel {
        display: none;
    }

    /* Disable checkboxes for image uploader */ 
    .fileupload-buttonbar .toggle, .files .toggle, .files .btn span {
        display: none;
    }

    /* Make place for scrolling on iPad */
    #tab-image {
        width: 660px;
    }
</style>

<?php endif; ?>
<?php endif; ?>
        
</head>

<?php if(!isset($menu_event_type)){$menu_event_type = "";} ?>
<!-- Set the active color profile -->
<body class="<?php if(isset($css_detail['css_name'])){echo $css_detail['css_name'];} ?>" data-color-profile="<?php if(isset($css_detail['css_name'])){echo $css_detail['css_name'];} ?>" data-menu-event-type="<?php echo $menu_event_type; ?>">
	<div class="container-fluid">

		<?php if ($logged) { ?>

		<div class="header">
			<div class="logo">
				<a href="<?php echo $home; ?>">
					<img class="visible-desktop" src="view/image/admin_theme/base5builder_circloid/logosocima.png" width="243" height="44" alt="Logo" />
					<img class="visible-tablet" src="view/image/admin_theme/base5builder_circloid/logosocima.png" width="156" height="44" alt="Logo" />
					<img class="visible-phone" src="view/image/admin_theme/base5builder_circloid/logosocima.png" width="48" height="44" alt="Logo" />
				</a>
			</div>
			<!-- Menu Control For Mobile/Tablets -->
			<div id="menu-control">
				<div class="menu-control-outer">
					<div class="menu-control-inner">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</div>
				</div>
			</div>
			<!-- Displays Secondary Menu -->
			<div class="secondary-menu">
				<ul>
					<li id="store">

						<!--<a href="http://socimagestion.com/index.php?route=product/category&path=1406" target="_blank" class="top"><span><?php echo $text_front; ?></span></a>-->
						<a href="<?php echo $store; ?>" target="_blank" class="top"><span><?php echo $text_front; ?></span></a>
					</li>
					<li id="logout"><a class="top" href="<?php echo $logout; ?>"><span><?php echo $text_logout; ?></span></a></li>
				</ul>
			</div>
			<!-- Displays Low Stock/Out of Stock Warnings -->
			
			<?php
			if(!isset($theme_not_installed)){
				if ($this->user->hasPermission('access', 'catalog/product')) {
					
					if($low_stock > 0 || $out_stock > 0){
						?>
						<div class="stock-alert-header">
							<?php
							if($low_stock_status){
								if($low_stock > 0 ){
									?>
									<div class="low-stock-alert stock-alert">
										<a href="<?php echo $low_stock_link; ?>">
											<img src="view/image/admin_theme/base5builder_circloid/icon-lowstock.png" alt="Low Stock" width="32" height="32" />
										</a>
										<div class="alert-label">
											<a href="<?php echo $low_stock_link; ?>">
												<?php echo $text_low_stock; ?>
											</a>
										</div>
										<div class="stock-number-outer">
											<div class="stock-number-inner">
												<div class="stock-number">
													<?php echo $low_stock; ?>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
							}
							?>
							<?php
							if($out_stock_status){
								if($out_stock > 0 ){
									?>
									<div class="out-stock-alert stock-alert">
										<a href="<?php echo $out_stock_link; ?>">
											<img src="view/image/admin_theme/base5builder_circloid/icon-lowstock.png" alt="Out Of Stock" width="32" height="32" />
										</a>
										<div class="alert-label">
											<a href="<?php echo $out_stock_link; ?>">
												<?php echo $text_out_stock; ?>
											</a>
										</div>
										<div class="stock-number-outer">
											<div class="stock-number-inner">
												<div class="stock-number">
													<?php echo $out_stock; ?>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
							}
							?>
						</div>
						<?php
					}
				}
			}
			?>
			<!-- Displays Logged In User -->
			<div class="admin-info">
				<img src="view/image/admin_theme/base5builder_circloid/icon-user.png" alt="Admin" width="32" height="32" />
				<?php echo $logged; ?>
			</div>
			<?php if(!$is_custom_page){ ?>
			<div class="clearfix"></div>
			<?php }else{ ?>
			<div class="clear"></div>
			<?php } ?>
		</div>
		<!-- Main Container For Each Page Content -->
		<div class="main-body">
			<!-- Left Menu/Main Menu -->
			<div id="left-column">
				<div id="mainnav">
					<ul class="mainnav">
						<li id="dashboard"><a href="<?php echo $home; ?>" class="top"><?php echo $text_dashboard; ?></a></li>
						<li id="catalog"><a class="top"><?php echo $text_catalog; ?></a>
							<ul>
								<?php if($group_user == 1 OR $group_user == 16){ ?>
									<li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>
								<?php }else { ?>
									<!--<li><a href="<?php echo $category; ?>"><?php echo $text_category; ?></a></li>-->
								<?php } ?>
								<li><a href="<?php echo $product; ?>"><?php echo $text_product; ?></a></li>
								<?php if($group_user == 1 OR $group_user == 16){ ?>
									<li><a href="<?php echo $filter; ?>"><?php echo $text_filter; ?></a></li>
									<!--<li><a href="<?php echo $profile; ?>"><?php echo $text_profile; ?></a></li>-->
									<li><a class="parent"><?php echo $text_attribute; ?></a>
										<ul>
											<li><a href="<?php echo $attribute; ?>"><?php echo $text_attribute; ?></a></li>
											<li><a href="<?php echo $attribute_group; ?>"><?php echo $text_attribute_group; ?></a></li>
										</ul>
									</li>
									<li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
									<!--<li><a href="<?php echo $option; ?>"><?php echo $text_option; ?></a></li>							
									<li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
									<li><a href="<?php echo $review; ?>"><?php echo $text_review; ?></a></li>
									<li><a href="<?php echo $information; ?>"><?php echo $text_information; ?></a></li>-->
								<?php }else { ?>
									<!--<li><a href="<?php echo $filter; ?>"><?php echo $text_filter; ?></a></li>
									<li><a href="<?php echo $profile; ?>"><?php echo $text_profile; ?></a></li>
									<li><a class="parent"><?php echo $text_attribute; ?></a>
										<ul>
											<li><a href="<?php echo $attribute; ?>"><?php echo $text_attribute; ?></a></li>
											<li><a href="<?php echo $attribute_group; ?>"><?php echo $text_attribute_group; ?></a></li>
										</ul>
									</li>
									<li><a href="<?php echo $option; ?>"><?php echo $text_option; ?></a></li>
									<li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
									<li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>
									<li><a href="<?php echo $review; ?>"><?php echo $text_review; ?></a></li>
									<li><a href="<?php echo $information; ?>"><?php echo $text_information; ?></a></li>-->
								<?php } ?>
							</ul>
						</li>
						<?php if($group_user == 16){ ?>
							<li id="extension"><a class="top"><?php echo $text_extension; ?></a>
								<ul>
									<li><a href="<?php echo $module; ?>"><?php echo $text_module; ?></a></li>
									<li><a href="<?php echo $shipping; ?>"><?php echo $text_shipping; ?></a></li>
									<li><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a></li>
									<li><a href="<?php echo $total; ?>"><?php echo $text_total; ?></a></li>
									<li><a href="<?php echo $feed; ?>"><?php echo $text_feed; ?></a></li>
									<?php if ($openbay_show_menu == 1) { ?>
									<li><a class="parent"><?php echo $text_openbay_extension; ?></a>
										<ul>
											<li><a href="<?php echo $openbay_link_extension; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
											<li><a href="<?php echo $openbay_link_orders; ?>"><?php echo $text_openbay_orders; ?></a></li>
											<li><a href="<?php echo $openbay_link_items; ?>"><?php echo $text_openbay_items; ?></a></li>

											<?php if($openbay_markets['ebay'] == 1){ ?>
											<li><a class="parent" href="<?php echo $openbay_link_ebay; ?>"><?php echo $text_openbay_ebay; ?></a>
												<ul>
													<li><a href="<?php echo $openbay_link_ebay_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
													<li><a href="<?php echo $openbay_link_ebay_links; ?>"><?php echo $text_openbay_links; ?></a></li>
													<li><a href="<?php echo $openbay_link_ebay_orderimport; ?>"><?php echo $text_openbay_order_import; ?></a></li>
												</ul>
											</li>
											<?php } ?>

											<?php if($openbay_markets['amazon'] == 1){ ?>
											<li><a class="parent" href="<?php echo $openbay_link_amazon; ?>"><?php echo $text_openbay_amazon; ?></a>
												<ul>
													<li><a href="<?php echo $openbay_link_amazon_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
													<li><a href="<?php echo $openbay_link_amazon_links; ?>"><?php echo $text_openbay_links; ?></a></li>
												</ul>
											</li>
											<?php } ?>

											<?php if($openbay_markets['amazonus'] == 1){ ?>
											<li><a class="parent" href="<?php echo $openbay_link_amazonus; ?>"><?php echo $text_openbay_amazonus; ?></a>
												<ul>
													<li><a href="<?php echo $openbay_link_amazonus_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
													<li><a href="<?php echo $openbay_link_amazonus_links; ?>"><?php echo $text_openbay_links; ?></a></li>
												</ul>
											</li>
											<?php } ?>
										</ul>
									</li>
									<?php } ?>
								</ul>
							</li>
						<?php }else{ ?>
							<!--<li id="extension"><a class="top"><?php echo $text_extension; ?></a>
								<ul>
									<li><a href="<?php echo $module; ?>"><?php echo $text_module; ?></a></li>
									<li><a href="<?php echo $shipping; ?>"><?php echo $text_shipping; ?></a></li>
									<li><a href="<?php echo $payment; ?>"><?php echo $text_payment; ?></a></li>
									<li><a href="<?php echo $total; ?>"><?php echo $text_total; ?></a></li>
									<li><a href="<?php echo $feed; ?>"><?php echo $text_feed; ?></a></li>
									<?php if ($openbay_show_menu == 1) { ?>
									<li><a class="parent"><?php echo $text_openbay_extension; ?></a>
										<ul>
											<li><a href="<?php echo $openbay_link_extension; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
											<li><a href="<?php echo $openbay_link_orders; ?>"><?php echo $text_openbay_orders; ?></a></li>
											<li><a href="<?php echo $openbay_link_items; ?>"><?php echo $text_openbay_items; ?></a></li>

											<?php if($openbay_markets['ebay'] == 1){ ?>
											<li><a class="parent" href="<?php echo $openbay_link_ebay; ?>"><?php echo $text_openbay_ebay; ?></a>
												<ul>
													<li><a href="<?php echo $openbay_link_ebay_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
													<li><a href="<?php echo $openbay_link_ebay_links; ?>"><?php echo $text_openbay_links; ?></a></li>
													<li><a href="<?php echo $openbay_link_ebay_orderimport; ?>"><?php echo $text_openbay_order_import; ?></a></li>
												</ul>
											</li>
											<?php } ?>

											<?php if($openbay_markets['amazon'] == 1){ ?>
											<li><a class="parent" href="<?php echo $openbay_link_amazon; ?>"><?php echo $text_openbay_amazon; ?></a>
												<ul>
													<li><a href="<?php echo $openbay_link_amazon_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
													<li><a href="<?php echo $openbay_link_amazon_links; ?>"><?php echo $text_openbay_links; ?></a></li>
												</ul>
											</li>
											<?php } ?>

											<?php if($openbay_markets['amazonus'] == 1){ ?>
											<li><a class="parent" href="<?php echo $openbay_link_amazonus; ?>"><?php echo $text_openbay_amazonus; ?></a>
												<ul>
													<li><a href="<?php echo $openbay_link_amazonus_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
													<li><a href="<?php echo $openbay_link_amazonus_links; ?>"><?php echo $text_openbay_links; ?></a></li>
												</ul>
											</li>
											<?php } ?>
										</ul>
									</li>
									<?php } ?>
								</ul>
							</li>-->
						<?php } ?>
						<li id="sale"><a class="top"><?php echo $text_sale; ?></a>
							<ul>
								<li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
								<!--<li><a href="<?php echo $recurring_profile; ?>"><?php echo $text_recurring_profile; ?></a></li>
								<li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>-->
								<li><a class="parent"><?php echo $text_customer; ?></a>
									<ul>
										<li><a href="<?php echo $customer; ?>"><?php echo $text_customer; ?></a></li>
										<!--<li><a href="<?php echo $customer_group; ?>"><?php echo $text_customer_group; ?></a></li>
										<li><a href="<?php echo $customer_ban_ip; ?>"><?php echo $text_customer_ban_ip; ?></a></li>-->
									</ul>
								</li>
								<!--<li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
								<li><a href="<?php echo $coupon; ?>"><?php echo $text_coupon; ?></a></li>
								<li><a class="parent"><?php echo $text_voucher; ?></a>
									<ul>
										<li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
										<li><a href="<?php echo $voucher_theme; ?>"><?php echo $text_voucher_theme; ?></a></li>
									</ul>
								</li>-->
								<!-- PAYPAL MANAGE NAVIGATION LINK -->
								<?php if ($pp_express_status) { ?>
								<li><a class="parent" href="<?php echo $paypal_express; ?>"><?php echo $text_paypal_express; ?></a>
									<ul>
										<li><a href="<?php echo $paypal_express_search; ?>"><?php echo $text_paypal_express_search; ?></a></li>
									</ul>
								</li>
								<?php } ?>
								<!-- PAYPAL MANAGE NAVIGATION LINK END -->
								<!--<li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>-->
							</ul>
						</li>
						<?php if($group_user == 16 OR $group_user == 1){ ?>
							<li id="system"><a class="top"><?php echo $text_system; ?></a>
								<?php if($group_user == 16) { ?>
								<ul>
									<li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li>
									<li><a class="parent"><?php echo $text_design; ?></a>
										<ul>
											<li><a href="<?php echo $layout; ?>"><?php echo $text_layout; ?></a></li>
											<li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li>
										</ul>
									</li>
									<li><a class="parent"><?php echo $text_users; ?></a>
										<ul>
											<li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
											<li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
										</ul>
									</li>
									<li><a class="parent"><?php echo $text_localisation; ?></a>
										<ul>
											<li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
											<li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
											<li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
											<li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
											<li><a class="parent"><?php echo $text_return; ?></a>
												<ul>
													<li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
													<li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
													<li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
												</ul>
											</li>
											<li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
											<li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
											<li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
											<li><a class="parent"><?php echo $text_tax; ?></a>
												<ul>
													<li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
													<li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li>
												</ul>
											</li>
											<li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
											<li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
										</ul>
									</li>
									<li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
									<li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>
									<?php /* //karapuz */?>
          <?php if (!empty($is_ka_import_installed)) { ?>
          <li><a href="<?php echo $ka_import; ?>"><?php echo $text_ka_import; ?></a></li>
          <?php } ?>
          <?php ///karapuz ?>
								</ul>
							<?php }else { ?>
								<ul>
									<li><a class="parent"><?php echo $text_users; ?></a>
										<ul>
											<li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
											<li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
										</ul>
									</li>
								</ul>
							<?php } ?>
							</li>
						<?php }else { ?>
							<!--<li id="system"><a class="top"><?php echo $text_system; ?></a>
								<ul>
									<li><a href="<?php echo $setting; ?>"><?php echo $text_setting; ?></a></li>
									<li><a class="parent"><?php echo $text_design; ?></a>
										<ul>
											<li><a href="<?php echo $layout; ?>"><?php echo $text_layout; ?></a></li>
											<li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li>
										</ul>
									</li>
									<li><a class="parent"><?php echo $text_users; ?></a>
										<ul>
											<li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
											<li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
										</ul>
									</li>
									<li><a class="parent"><?php echo $text_localisation; ?></a>
										<ul>
											<li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
											<li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
											<li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
											<li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
											<li><a class="parent"><?php echo $text_return; ?></a>
												<ul>
													<li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
													<li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
													<li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
												</ul>
											</li>
											<li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
											<li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
											<li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
											<li><a class="parent"><?php echo $text_tax; ?></a>
												<ul>
													<li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
													<li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li>
												</ul>
											</li>
											<li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
											<li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
										</ul>
									</li>
									<li><a href="<?php echo $error_log; ?>"><?php echo $text_error_log; ?></a></li>
									<li><a href="<?php echo $backup; ?>"><?php echo $text_backup; ?></a></li>
								</ul>
							</li>-->
						<?php } ?>
						<li id="reports"><a class="top"><?php echo $text_reports; ?></a>
							<ul>
								<li><a class="parent"><?php echo $text_sale; ?></a>
									<ul>
										<li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li>
										<!--<li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li>
										<li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li>
										<li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li>
										<li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>-->
									</ul>
								</li>
								<li><a class="parent"><?php echo $text_product; ?></a>
									<ul>
										<li><a href="<?php echo $report_product_viewed; ?>"><?php echo $text_report_product_viewed; ?></a></li>
										<!--<li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li>-->
									</ul>
								</li>
								<!--<li><a class="parent"><?php echo $text_customer; ?></a>
									<ul>
										<li><a href="<?php echo $report_customer_online; ?>"><?php echo $text_report_customer_online; ?></a></li>
										<li><a href="<?php echo $report_customer_order; ?>"><?php echo $text_report_customer_order; ?></a></li>
										<li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li>
										<li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li>
									</ul>
								</li>
								<li><a class="parent"><?php echo $text_affiliate; ?></a>
									<ul>
										<li><a href="<?php echo $report_affiliate_commission; ?>"><?php echo $text_report_affiliate_commission; ?></a></li>
									</ul>
								</li>-->
							</ul>
						</li>
						<!--<li id="help"><a class="top"><?php echo $text_help; ?></a>
							<ul>
								<li><a href="http://www.opencart.com" target="_blank"><?php echo $text_opencart; ?></a></li>
								<li><a href="http://www.opencart.com/index.php?route=documentation/introduction" target="_blank"><?php echo $text_documentation; ?></a></li>
								<li><a href="http://forum.opencart.com" target="_blank"><?php echo $text_support; ?></a></li>
								<?php if(!$is_custom_page){ ?>
									<li id="add-custom-admin-page"><a href="#">Make This Page Compatible</a></li>
								<?php }else{ ?>
									<li id="remove-custom-admin-page"><a href="#">Remove Page Compatibility</a></li>
								<?php } ?>
							</ul>
						</li>-->
						<li id="actualizar"><a class="top"><?php echo 'Extras'; ?></a>
							<ul>
								<li><a href="<?php echo $noticias; ?>"><?php echo 'Noticias'; ?></a></li>
								<li><a href="<?php echo $banners; ?>"><?php echo 'Banner'; ?></a></li>
								<li><a target="_blank" href="http://socimagestion.com/Movil/Sistema.php"><?php echo 'Administracion Movil'; ?></a></li>
								<li><a target="_blank" href="http://socimagestion.com/Mejora/PHPExcel//sistema.php/"><?php echo 'Cargar Excel'; ?></a></li>
							</ul>
						</li>
						
					</ul>
				</div>
			</div>
			<div id="right-column">
				<?php } ?>