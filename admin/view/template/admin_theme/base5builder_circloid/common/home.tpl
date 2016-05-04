<?php echo $header; ?>
<div id="content" class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
				<?php } ?>
			</div>
			<?php if ($error_install) { ?>
			<div class="warning"><?php echo $error_install; ?></div>
			<?php } ?>
			<?php if ($error_image) { ?>
			<div class="warning"><?php echo $error_image; ?></div>
			<?php } ?>
			<?php if ($error_image_cache) { ?>
			<div class="warning"><?php echo $error_image_cache; ?></div>
			<?php } ?>
			<?php if ($error_cache) { ?>
			<div class="warning"><?php echo $error_cache; ?></div>
			<?php } ?>
			<?php if ($error_download) { ?>
			<div class="warning"><?php echo $error_download; ?></div>
			<?php } ?>
			<?php if ($error_logs) { ?>
			<div class="warning"><?php echo $error_logs; ?></div>
			<?php } ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="box span12">
			<?php if (isset($error_warning)) { ?>
			<div class="warning"><?php echo $error_warning; ?></div>
			<?php } ?>
			<?php if (isset($success)) { ?>
			<!--<div class="success"><?php echo $success; ?></div>-->
  <div class="success"><a target="_blank" href="http://socimagestion.com/Movil/Sistema.php"><?php echo "Recuerde actualizar los datos para el sistema Movil"; ?></div>
			<?php } ?>
			<div>
			<!--<?php var_dump(count($vendedores)); ?>-->
			<?php if($group_user == 1 OR $group_user == 16){ ?>
				<table border="1px">
					<tr>
						<td><?php echo 'Nombre : ' .$vendedores[0]['nombre'] . ' ' . $vendedores[0]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[1]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[0]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[1]['nombre'] . ' ' . $vendedores[1]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[1]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[1]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[2]['nombre'] . ' ' . $vendedores[2]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[2]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[2]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[3]['nombre'] . ' ' . $vendedores[3]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[3]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[3]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[4]['nombre'] . ' ' . $vendedores[4]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[4]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[4]['actual'],0,',','.') ; ?> </td>
					</tr>
					<tr>
						<td><?php echo 'Nombre : ' .$vendedores[5]['nombre'] . ' ' . $vendedores[5]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[5]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[5]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[6]['nombre'] . ' ' . $vendedores[6]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[6]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[6]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[7]['nombre'] . ' ' . $vendedores[7]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[7]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[7]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[8]['nombre'] . ' ' . $vendedores[8]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[8]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[8]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[9]['nombre'] . ' ' . $vendedores[9]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[9]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[9]['actual'],0,',','.') ; ?> </td>
					</tr>
					<?php if (count($vendedores) > 10){ ?>
						<tr>
						<td><?php echo 'Nombre : ' .$vendedores[10]['nombre'] . ' ' . $vendedores[10]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[10]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[10]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[11]['nombre'] . ' ' . $vendedores[11]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[11]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[11]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[12]['nombre'] . ' ' . $vendedores[12]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[12]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[12]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[13]['nombre'] . ' ' . $vendedores[13]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[13]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[13]['actual'],0,',','.') ; ?> </td>
						<td><?php echo 'Nombre : ' .$vendedores[14]['nombre'] . ' ' . $vendedores[14]['apellido']. '<br/> Meta : $ ' . number_format($vendedores[14]['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores[14]['actual'],0,',','.') ; ?> </td>
					</tr>
					<?php } ?>
				</table>
			<?php }else { ?>
				<table border="1px">
					<tr>
						<td><?php echo 'Nombre : ' .$vendedores['nombre'] . ' ' . $vendedores['apellido']. '<br/> Meta : $ ' . number_format($vendedores['meta'],0,',','.') . '<br/> Actual : $ ' . number_format($vendedores['actual'],0,',','.') ; ?> </td>

					</tr>
				</table>
			<?php } ?>
			</div>
			<br/><br/>
				<div>
				<h2><?php echo 'Ver últimas 10 ordenes completas'; ?></h2>
					<button id="boton_excel" class="btn btn-small" onclick="excel()"><img src="view/image/blue-document-excel.png" alt=""> Descargar Excel</button>
				</div>
				<br/>
				<div class="latest c-widget c-widget-large span12">
					<h2><?php echo $text_latest_10_orders; ?></h2>
					<div class="dashboard-content">
						<table class="list">
							<thead>
								<tr>
									<td class="right"><?php echo $column_order; ?></td>
									<td class="left"><?php echo $column_customer; ?></td>
									<td class="left"><?php echo $column_status; ?></td>
									<td class="left"><?php echo $column_date_added; ?></td>
									<td class="right"><?php echo $column_total; ?></td>
									<td class="right"><?php echo $column_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php if ($orders) { ?>
								<?php foreach ($orders as $order) { ?>
								<tr>
									<td class="right"><?php echo $order['order_id']; ?></td>
									<td class="left"><?php echo $order['customer']; ?></td>
									<td class="left"><?php echo $order['status']; ?></td>
									<td class="left"><?php echo $order['date_added']; ?></td>
									<td class="right"><?php echo $order['total']; ?></td>
									<td class="right"><?php foreach ($order['action'] as $action) { ?>
										[ <a href="<?php echo $action['href']; ?>"><?php echo 'Ver'; ?></a> ]
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
								<?php } else { ?>
								<tr>
									<td class="center" colspan="6"><?php echo $text_no_results; ?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div> 
	</div> 
	<?php echo $footer; ?>
<script type="text/javascript">
	function excel(){
		location.href='view/template/admin_theme/base5builder_circloid/common/excel_orders.php';
		/*$.ajax({
		url: 'index.php?route=common/home/excel&token=<?php echo $token; ?>',
		datatype: 'post',
		success: function(json){
			if (json){
				//alert('El Estado ha sido actualizado correctamente');
				//window.location.reload();
			} else {
				//alert('no se a podido actualizar');
			}
		}
		});*/
	}
</script>