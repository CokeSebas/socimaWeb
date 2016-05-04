<!DocType HTML>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
body {
	color: #0f0f0f;
	font-family: Helvetica;
	margin: 0 auto 0 auto;
}
h2 {
	color: #252625;
	font-size: 11px;
	font-weight: bold;
	margin-top: 15px;
}
.clear {
	clear: both;
}
.bold {
	font-weight: bold;
}
.title {
	background: #f2f2f2;
	clear: both;
	color: #252625;
	font-size: 15px;
	font-weight: bold;
	margin-top: 19px;
	padding: 15px 13px 0 11px;
}
.ex-tax {
	color: #444;
	font-size: 11px;
	font-weight: normal;
}
table td, ul li {
	color: #808180;
	font-size: 11px;
}
td.bold {
	padding-left: 50px;
}

#gallery {
	float:right;
	padding-top: 10px;
	width:200px;
}
.img {
	margin-top: 10px;
}
#list2 {
	margin-bottom: 50px;
}
.image {
	margin-bottom: 10px;
	text-align: center;
	width: 100%;
}
.image-qr {}
.description, .description p {
	color: #808080 !important;
	font-size: 11px;
	line-height: 21px;
	text-align: justify;
}
</style>
<title><?php echo $product_info['name']; ?></title>
</head>
<body>
<div class="title">
	<?php echo $product_info['name']; ?>
	<p style="text-align:right;font-size:13px<?php if (strlen($product_info['name']) < 55) { ?>;margin-top:-19px<?php } ?>">
		<?php if ($tax) { ?>
		<?php echo $tax; ?><br/>
		<?php } ?>
		<span class="ex-tax"><?php echo $text_price; ?> <?php echo $price; ?></span>
	</p>
</div>

<div style="width:300px; float:left">
	<?php $attribute_group = array_shift($attribute_groups); ?>
	<?php if ($attribute_group) { ?>
	<h2><?php echo $text_attributes; ?></h2>

	<table>
		<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
		<tr>
		 <td><?php echo $attribute['name']; ?>:</td>
		 <td class="bold"><?php echo $attribute['text']; ?></td>
		</tr>
		<?php } ?>
	</table>
	<?php } ?>

<?php $pos = strlen($description) > 1050 ? strpos($description, '<li>', 1050) : 1050; ?>
<?php if ($pos) { ?>
<div class="description">
	<?php echo substr($description, 0, $pos); ?>
	<?php if (strlen($description) > 1050) { ?>
	</ul>
	<?php } ?>
</div>
<?php } ?>
</div>
<div id="gallery">
	<img src="<?php echo $this->model_tool_image->resize($product_info['image'], 300, 200); ?>" class="img">
	<?php $i = 0; ?>
	<?php foreach ($images as $i => $image) { ?>
	<img src="<?php echo $this->model_tool_image->resize($image['image'], 300, 200); ?>" class="img">
	<?php unset($images[$i]); ?>
	<?php if (++$i > 2) break; ?>
	<?php } ?>
</div>
<div class="clear"></div>
<?php if (strlen($description) > 1050) { ?>
<div class="description">
	<?php if (substr($description, $pos, 3) == '<li') { ?>
	<ul id="list2">
	<?php } ?>
	<?php echo substr($description, $pos); ?>
</div>
<?php } ?>

<?php foreach ($images as $image) { ?>
<img src="<?php echo $this->model_tool_image->resize($image['image'], 600, 400); ?>" class="image"><br />
<?php } ?>

<img style="width: 130px;height: 130px;" src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo rawurlencode($this->url->link('product/product', 'product_id=' . $product_info['product_id'])); ?>&amp;qzone=0&amp;size=120x120&amp;margin=0" alt="qr code"><br>

<span id="href"><?php echo $this->url->link('product/product', 'product_id=' . $product_info['product_id']); ?></span>
</body>
</html>