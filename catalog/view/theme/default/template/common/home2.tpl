<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<table width="930px" border="0px" align="center">
	<?php if(isset($bannersC[0])) { ?>
		<tr>
			<td><a href="http://socimagestion.com/index.php?route=product/category&path=<?php echo $bannersC[0]['parent_id'].'_'.$bannersC[0]['informacion']; ?>" ><img src="<?php echo $bannersC[0]['url']; ?>" align="center" width="930" height="220"></td>
		</tr>
	<?php }else{ ?>
		<tr>
			<td><img src="<?php echo $bannersP[0]['url']; ?>" align="center" width="930" height="220"></td>
		</tr>
	<?php } ?>
</table>
<table width="937px" border="0px" align="center">
	<tr>
	<?php if($bannersP[1]['informacion'] != '') { ?>
		<td><a href="http://socimagestion.com/index.php?route=product/product&product_id=<?php echo $bannersP[1]['informacion']; ?>" ><img src="<?php echo $bannersP[1]['url']; ?>" width="460" height="300"></td>
	<?php }else{ ?>
		<td><img src="<?php echo $bannersP[1]['url']; ?>" width="460" height="300"></td>
	<?php } ?>
	<?php if($bannersP[2]['informacion'] != '') { ?>
		<td><a href="http://socimagestion.com/index.php?route=product/product&product_id=<?php echo $bannersP[2]['informacion']; ?>" ><img src="<?php echo $bannersP[2]['url']; ?>" width="460" height="300"></td>
	<?php }else{ ?>
		<td><img src="<?php echo $bannersP[2]['url']; ?>" width="460" height="300"></td>
	<?php } ?>
	</tr>
</table>
<?php echo $content_bottom; ?></div>
<?php echo $footer; ?>