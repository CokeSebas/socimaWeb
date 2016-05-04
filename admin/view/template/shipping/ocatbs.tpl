<!doctype html> 
<!--
      //===========================================//
     // Total-Based Shipping                      //
    // Author: Joel Reeds                        //
   // Company: OpenCart Addons                  //
  // Website: http://opencartaddons.com        //
 // Contact: webmaster@opencartaddons.com     //
//===========================================//
-->
<?php echo $header; ?>	
<?php if ($ocversion >= 150) { ?>			
	<div id="content">
		<div class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
			<?php } ?>
		</div>
<?php } ?>	
	<?php if ($success) { ?>
        <!--<div class="success"><?php echo $success; ?></div>-->
  <div class="success"><a target="_blank" href="http://socimagestion.com/Movil/Sistema.php"><?php echo "Recuerde actualizar los datos para el sistema Movil"; ?></div>
    <?php } ?>
	<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
		<div class="box">
			<?php if ($ocversion < 150) { ?>
				<div class="left"></div>
				<div class="right"></div>
			<?php } ?>
			<div class="heading">
				<?php if ($ocversion < 150) { ?>
					<h1 style="background-image: url('view/image/shipping.png');"><?php echo $heading_title; ?></h1>
				<?php } else { ?>
					<h1><img src="view/image/shipping.png" alt="" /> <?php echo $heading_title; ?></h1>
				<?php } ?>
				<div class="buttons"><a onclick="$('#form').attr('action', '<?php echo $action; ?>&apply=true'); $('#form').submit();" class="button"><span><?php echo $button_apply; ?></span></a><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
			</div>
			<div class="content">
				<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
					<div class="oca-general">
						<div class="oca-header"><?php echo $text_general_settings; ?> <div class="oca-remove"><a href="http://opencartaddons.com" target="_blank"><img src="view/image/oca_logo.png" alt="OpenCart Addons" height="17px"/></a></div></div>
						<div class="oca-rate" style="border: 1px solid #DDDDDD; padding: 5px; height: 400px; text-align:center;">
							<div class="oca-entry"><?php echo $entry_status; ?></div>
							<div class="oca-input" align="center">
								<select name="<?php echo $extension; ?>_status">
									<?php if (${$extension . '_status'}) { ?>
										<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
										<option value="0"><?php echo $text_disabled; ?></option>
									<?php } else { ?>
										<option value="1"><?php echo $text_enabled; ?></option>
										<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="oca-entry"><?php echo $entry_title; ?></div>
							<div class="oca-input" align="center">
								<?php foreach ($languages as $language) { ?>
									<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="text" name="<?php echo $extension; ?>_title[<?php echo $language['code']; ?>]" value="<?php echo (!empty(${$extension.'_title'}[$language['code']])) ? ${$extension.'_title'}[$language['code']] : ''; ?>" size="25" /><br />
								<?php } ?>
							</div>
							<div class="oca-entry"><?php echo $entry_sort_order; ?></div>
							<div class="oca-input">
								<input type="text" name="<?php echo $extension; ?>_sort_order" value="<?php echo ${$extension . '_sort_order'}; ?>" size="5" />
							</div>
							<div class="oca-entry"><?php echo $entry_sort_quotes; ?></div>
							<div class="oca-input" align="center">
								<select name="<?php echo $extension; ?>_sort_quotes">
									<?php foreach ($sort_quotes as $sort_quote) { ?>
										<?php if ($sort_quote['id'] == ${$extension . '_sort_quotes'}) { ?>
											<option value="<?php echo $sort_quote['id']; ?>" selected="selected"><?php echo $sort_quote['name']; ?></option>
										<?php } else { ?>
											<option value="<?php echo $sort_quote['id']; ?>"><?php echo $sort_quote['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
							<?php if ($display_weight_option) { ?>
								<div class="oca-entry"><?php echo $entry_display_weight; ?></div>
								<div class="oca-input" align="center">
									<select name="<?php echo $extension; ?>_display_weight">
										<?php if (${$extension . '_display_weight'}) { ?> 
											<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
											<option value="0"><?php echo $text_disabled; ?></option>
										<?php } else { ?>
											<option value="1"><?php echo $text_enabled; ?></option>
											<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
										<?php } ?>
									</select>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="oca-information">
						<div class="oca-header"><?php echo $text_help; ?> <div class="oca-remove"><a href="http://opencartaddons.com" target="_blank"><img src="view/image/oca_logo.png" alt="OpenCart Addons" height="17px"/></a></div></div>
						<div class="oca-rate" style="border: 1px solid #DDDDDD; height: 400px; padding: 5px; overflow: auto;">
							<div id="help" class="htabs">
								<?php if ($ocversion >= 150) { $htabs = 'href'; } else { $htabs = 'tab'; } ?>
								<a <?php echo $htabs; ?>="#help-general_settings"><?php echo $text_general_settings; ?></a>
								<a <?php echo $htabs; ?>="#help-rate_general"><?php echo $text_rate . ' ' . $text_general; ?></a>
								<a <?php echo $htabs; ?>="#help-rate_criteria"><?php echo $text_rate . ' ' . $text_criteria; ?></a>
								<a <?php echo $htabs; ?>="#help-rate_parameters"><?php echo $text_rate . ' ' . $text_parameters; ?></a>
								<a <?php echo $htabs; ?>="#help-rate_calculations"><?php echo $text_rate . ' ' . $text_calculations; ?></a>
								<a <?php echo $htabs; ?>="#help-rate_troubleshoot"><?php echo $text_troubleshoot; ?></a>
							</div>
							<?php if ($ocversion >= 150) { $htabs_content = 'htabs-content'; } else { $htabs_content = 'htabs_page'; } ?>
							<div id="help-general_settings" class="<?php echo $htabs_content; ?>">
								<?php echo $help_general_settings; ?>
							</div>
							<div id="help-rate_general" class="<?php echo $htabs_content; ?>">
								<?php echo $help_rate_general; ?>
							</div>
							<div id="help-rate_criteria" class="<?php echo $htabs_content; ?>">
								<?php echo $help_rate_criteria; ?>
							</div>
							<div id="help-rate_parameters" class="<?php echo $htabs_content; ?>">
								<?php echo $help_rate_parameters; ?>
							</div>
							<div id="help-rate_calculations" class="<?php echo $htabs_content; ?>">
								<?php echo $help_rate_calculations; ?>
							</div>
							<div id="help-rate_troubleshoot" class="<?php echo $htabs_content; ?>">
								<?php echo $help_rate_troubleshoot; ?>
							</div>
						</div>
					</div>
					
					<?php $rate_row = 1; ?>
					<?php if (!empty(${$extension . '_rate'})) { ?>
						<?php foreach (${$extension . '_rate'} as $data) { ?>
							<div id="rate-row<?php echo $rate_row; ?>" class="oca-rate">
								<div class="oca-head"><?php echo substr($data['rate_name'], 0, 100); if (strlen($data['rate_name']) > 100) { echo '...'; } ?> <div class="oca-remove"><a onclick="if (confirm('<?php echo $text_confirm_delete; ?>')) { $('#rate-row<?php echo $rate_row; ?>').remove(); }"><img src="view/image/oca_remove.png" alt="<?php echo $button_remove_rate; ?>" /></a></div></div>
								<div class="oca-content">
									<table class="oca-table">
										<thead>
											<tr>
												<td class="left" colspan="4" style="border-bottom: 1px solid #DDDDDD;"><?php echo $entry_rate_description; ?> <input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][rate_name]" value="<?php echo $data['rate_name']; ?>" size="115" /></td>
											</tr>
											<tr>
												<td class="center"><?php echo $text_general; ?></td>
												<td class="center"><?php echo $text_criteria; ?></td>
												<td class="center"><?php echo $text_parameters; ?></td>
												<td class="center"><?php echo $text_calculations; ?></td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="center" style="vertical-align:top;">
													<div class="oca-entry"><?php echo $entry_rate_status; ?></div>
													<div class="oca-input">
														<select name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][status]">
															<?php if ($data['status']) { ?>
																<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
																<option value="0"><?php echo $text_disabled; ?></option>
															<?php } else { ?>
																<option value="1"><?php echo $text_enabled; ?></option>
																<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
															<?php } ?>
														</select>
													</div>
													<div class="oca-entry"><?php echo $entry_name; ?></div>
													<div class="oca-input">
														<?php foreach ($languages as $language) { ?>
															<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][name][<?php echo $language['code']; ?>]" value="<?php echo $data['name'][$language['code']]; ?>" size="25" /><br />
														<?php } ?>
													</div>
													<div class="oca-entry"><?php echo $entry_multirate; ?></div>
													<div class="oca-input">
														<select name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][multirate]">
															<?php foreach ($multirates as $multirate) { ?>
																<?php if ($multirate['id'] == $data['multirate']) { ?>
																	<option value="<?php echo $multirate['id']; ?>" selected="selected"><?php echo $multirate['name']; ?></option>
																<?php } else { ?>
																	<option value="<?php echo $multirate['id']; ?>"><?php echo $multirate['name']; ?></option>
																<?php } ?>
															<?php } ?>
														</select>
													</div>
													<div class="oca-entry"><?php echo $entry_rate_sort_order; ?></div>
													<div class="oca-input">
														<input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][sort_order]" value="<?php echo $data['sort_order']; ?>" size="5" />
													</div>
													<div class="oca-entry"><?php echo $entry_tax; ?></div>
													<div class="oca-input">
														<select name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][tax_class_id]">
															<option value="0"><?php echo $text_none; ?></option>
															<?php foreach ($tax_classes as $tax_class) { ?>
																<?php if ($tax_class['tax_class_id'] == $data['tax_class_id']) { ?>
																	<option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
																<?php } else { ?>
																	<option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
																<?php } ?>
															<?php } ?>
														</select>
													</div>
												</td>
												<td class="center" style="vertical-align:top;">
													<div class="oca-entry"><?php echo $entry_stores; ?></div>
													<div class="oca-input">
														<div class="scrollbox" style="width:100%; text-align:left;">
															<?php $class = 'odd'; ?>
															<div class="<?php echo $class; ?>">
																<?php if (!empty($data['stores']) && in_array(0, $data['stores'])) { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][stores][]" value="0" checked="checked" />
																	<?php echo $this->config->get('config_name'); ?>
																<?php } else { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][stores][]" value="0" />
																	<?php echo $this->config->get('config_name'); ?>
																<?php } ?>
															</div>
															<?php foreach ($stores as $store) { ?>
																<div class="<?php echo $class; ?>">
																	<?php if (!empty($data['stores']) && in_array($store['store_id'], $data['stores'])) { ?>
																		<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][stores][]" value="<?php echo $store['store_id']; ?>" checked="checked" />
																		<?php echo $store['name']; ?>
																	<?php } else { ?>
																		<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][stores][]" value="<?php echo $store['store_id']; ?>" />
																		<?php echo $store['name']; ?>
																	<?php } ?>
																</div>
															<?php } ?>
														</div>
														<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
													</div>
													<div class="oca-entry"><?php echo $entry_customer_groups; ?></div>
													<div class="oca-input">
														<div class="scrollbox" style="width:100%; text-align:left;">
															<?php $class = 'even'; ?>
															<div class="<?php echo $class; ?>">
																<?php if (!empty($data['customer_groups']) && in_array(0, $data['customer_groups'])) { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][customer_groups][]" value="0" checked="checked" />
																	<i><?php echo $text_guest_checkout; ?></i>
																<?php } else { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][customer_groups][]" value="0" />
																	<i><?php echo $text_guest_checkout; ?></i>
																<?php } ?>
															</div>
															<?php foreach ($customer_groups as $customer_group) { ?>
																<div class="<?php echo $class; ?>">
																<?php if (!empty($data['customer_groups']) && in_array($customer_group['customer_group_id'], $data['customer_groups'])) { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][customer_groups][]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
																	<?php echo $customer_group['name']; ?>
																<?php } else { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][customer_groups][]" value="<?php echo $customer_group['customer_group_id']; ?>" />
																	<?php echo $customer_group['name']; ?>
																	<?php } ?>
																</div>
															<?php } ?>
														</div>
														<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
													</div>
													<div class="oca-entry"><?php echo $entry_geo_zones; ?></div>
													<div class="oca-input">
														<div class="scrollbox" style="width:100%; text-align:left;">		
															<?php $class = 'even'; ?>
															<div class="<?php echo $class; ?>">
																<?php if (!empty($data['geo_zones']) && in_array(0, $data['geo_zones'])) { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][geo_zones][]" value="0" checked="checked" />
																	<i><?php echo $text_all_zones; ?></i>
																<?php } else { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][geo_zones][]" value="0" />
																	<i><?php echo $text_all_zones; ?></i>
																<?php } ?>
															</div>
															<?php foreach ($geo_zones as $geo_zone) { ?>
																<div class="<?php echo $class; ?>">
																	<?php if (!empty($data['geo_zones']) && in_array($geo_zone['geo_zone_id'], $data['geo_zones'])) { ?>
																		<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][geo_zones][]" value="<?php echo $geo_zone['geo_zone_id']; ?>" checked="checked" />
																		<?php echo $geo_zone['name']; ?>
																	<?php } else { ?>
																		<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][geo_zones][]" value="<?php echo $geo_zone['geo_zone_id']; ?>" />
																		<?php echo $geo_zone['name']; ?>
																	<?php } ?>
																</div>
															<?php } ?>
														</div>
														<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
													</div>
													<div class="oca-entry"><?php echo $entry_postal_codes; ?></div>
													<div class="oca-input">
														<select name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][postal_code_type]">
															<?php foreach ($postal_code_types as $postal_code_type) { ?>
																<?php if ($postal_code_type['id'] == $data['postal_code_type']) { ?>
																	<option value="<?php echo $postal_code_type['id']; ?>" selected="selected"><?php echo $postal_code_type['name']; ?></option>
																<?php } else { ?>
																	<option value="<?php echo $postal_code_type['id']; ?>"><?php echo $postal_code_type['name']; ?></option>
																<?php } ?>
															<?php } ?>
														</select>
														<br/><textarea name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][postal_codes]" cols="45" rows="3"><?php echo $data['postal_codes']; ?></textarea>
													</div>
												</td>
												<td class="center" style="vertical-align:top;">
													<div class="oca-entry"><?php echo $entry_cart_values; ?></div>
													<div class="oca-input" align="center">
														<table class="oca-table-noborder">
															<thead>
																<tr>
																	<td class="left">&nbsp;</td>
																	<td class="center"><?php echo $text_min; ?></td>
																	<td class="center"><?php echo $text_max; ?></td>
																	<td class="center"><?php echo $text_add; ?></td>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td class="left"><?php echo $entry_quantity; ?></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][quantity_min]" value="<?php echo $data['quantity_min']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][quantity_max]" value="<?php echo $data['quantity_max']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][quantity_add]" value="<?php echo $data['quantity_add']; ?>" size="5" /></td>
																</tr>
																<tr>
																	<td class="left"><?php echo $entry_total; ?></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][total_min]" value="<?php echo $data['total_min']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][total_max]" value="<?php echo $data['total_max']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][total_add]" value="<?php echo $data['total_add']; ?>" size="5" /></td>
																</tr>
																<tr>
																	<td class="left"><?php echo $entry_weight; ?></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][weight_min]" value="<?php echo $data['weight_min']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][weight_max]" value="<?php echo $data['weight_max']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][weight_add]" value="<?php echo $data['weight_add']; ?>" size="5" /></td>
																</tr>
																<tr>
																	<td class="left"><?php echo $entry_volume; ?></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][volume_min]" value="<?php echo $data['volume_min']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][volume_max]" value="<?php echo $data['volume_max']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][volume_add]" value="<?php echo $data['volume_add']; ?>" size="5" /></td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="oca-entry"><?php echo $entry_product_dimensions; ?></div>
													<div class="oca-input" align="center">
														<table class="oca-table-noborder">
															<thead>
																<tr>
																	<td class="left">&nbsp;</td>
																	<td class="center"><?php echo $text_min; ?></td>
																	<td class="center"><?php echo $text_max; ?></td>
																	<td class="center"><?php echo $text_add; ?></td>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td class="left"><?php echo $entry_length; ?></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][length_min]" value="<?php echo $data['length_min']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][length_max]" value="<?php echo $data['length_max']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][length_add]" value="<?php echo $data['length_add']; ?>" size="5" /></td>
																</tr>
																<tr>
																	<td class="left"><?php echo $entry_width; ?></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][width_min]" value="<?php echo $data['width_min']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][width_max]" value="<?php echo $data['width_max']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][width_add]" value="<?php echo $data['width_add']; ?>" size="5" /></td>
																</tr>
																<tr>
																	<td class="left"><?php echo $entry_height; ?></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][height_min]" value="<?php echo $data['height_min']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][height_max]" value="<?php echo $data['height_max']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][height_add]" value="<?php echo $data['height_add']; ?>" size="5" /></td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="oca-entry"><?php echo $entry_categories; ?></div>
													<div class="oca-input" align="center">
														<table class="oca-table-noborder" style="width: 100%;">
															<tbody>
																<tr>
																	<td class="left"><?php echo $entry_category_setting; ?></td>
																	<td class="right">
																		<select name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][category_setting]">
																			<?php foreach ($category_settings as $category_setting) { ?>
																				<?php if ($category_setting['id'] == $data['category_setting']) { ?>
																					<option value="<?php echo $category_setting['id']; ?>" selected="selected"><?php echo $category_setting['name']; ?></option>
																				<?php } else { ?>
																					<option value="<?php echo $category_setting['id']; ?>"><?php echo $category_setting['name']; ?></option>
																				<?php } ?>
																			<?php } ?>
																		</select>
																	</td>
																</tr>
																<tr>
																	<td class="left"><?php echo $entry_cost_setting; ?></td>
																	<td class="right">
																		<select name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][cost_setting]">
																			<?php foreach ($cost_settings as $cost_setting) { ?>
																				<?php if ($cost_setting['id'] == $data['cost_setting']) { ?>
																					<option value="<?php echo $cost_setting['id']; ?>" selected="selected"><?php echo $cost_setting['name']; ?></option>
																				<?php } else { ?>
																					<option value="<?php echo $cost_setting['id']; ?>"><?php echo $cost_setting['name']; ?></option>
																				<?php } ?>
																			<?php } ?>
																		</select>
																	</td>
																</tr>
															</tbody>
														</table>
														<div class="scrollbox" style="width:100%; text-align:left;">
															<?php $class = 'even'; ?>
															<div class="<?php echo $class; ?>">
																<?php if (!empty($data['categories']) && in_array(0, $data['categories'])) { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][categories][]" value="0" checked="checked" />
																	<i><?php echo $text_all_categories; ?></i>
																<?php } else { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][categories][]" value="0" />
																	<i><?php echo $text_all_categories; ?></i>
																<?php } ?>
															</div>
															<?php foreach ($categories as $category) { ?>
																<div class="<?php echo $class; ?>">
																<?php if (!empty($data['categories']) && in_array($category['category_id'], $data['categories'])) { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][categories][]" value="<?php echo $category['category_id']; ?>" checked="checked" />
																	<?php echo $category['name']; ?>
																<?php } else { ?>
																	<input type="checkbox" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][categories][]" value="<?php echo $category['category_id']; ?>" />
																	<?php echo $category['name']; ?>
																	<?php } ?>
																</div>
															<?php } ?>
														</div>
														<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
													</div>
												</td>
												<td class="center" style="vertical-align:top;">
													<div class="oca-entry"><?php echo $entry_rate_settings; ?></div>
													<div class="oca-input" align="center">
														<table class="oca-table-noborder">
															<tbody>
																<tr>
																<?php if (isset($rate_types)) { ?>
																	<tr>
																		<td class="left"><?php echo $entry_rate_type; ?></td>
																		<td class="right">
																			<select name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][rate_type]" onchange="$(this).val() == '4' ? $('#shipping_factor<?php echo $rate_row; ?>').fadeIn('slow') : $('#shipping_factor<?php echo $rate_row; ?>').hide()">
																				<?php foreach ($rate_types as $rate_type) { ?>
																					<?php if ($rate_type['id'] == $data['rate_type']) { ?>
																						<option value="<?php echo $rate_type['id']; ?>" selected="selected"><?php echo $rate_type['name']; ?></option>
																					<?php } else { ?>
																						<option value="<?php echo $rate_type['id']; ?>"><?php echo $rate_type['name']; ?></option>
																					<?php } ?>
																				<?php } ?>
																			</select>
																		</td>
																	</tr>
																<?php } ?>
																</tr>
																<tr>
																	<td class="left"><?php echo $entry_final_cost; ?></td>
																	<td class="right">
																		<select name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][final_cost]">
																			<?php foreach ($final_costs as $final_cost) { ?>
																				<?php if ($final_cost['id'] == $data['final_cost']) { ?>
																					<option value="<?php echo $final_cost['id']; ?>" selected="selected"><?php echo $final_cost['name']; ?></option>
																				<?php } else { ?>
																					<option value="<?php echo $final_cost['id']; ?>"><?php echo $final_cost['name']; ?></option>
																				<?php } ?>
																			<?php } ?>
																		</select>
																	</td>
																</tr>
																<?php if ($display_shipping_factor) { ?>
																	<tr id="shipping_factor<?php echo $rate_row; ?>" <?php if (isset($data['rate_type']) && $data['rate_type'] !== '4' && $extension == 'ocaadvancedshipping') { echo 'style="display: none;"'; } ?>>
																		<td class="left"><?php echo $entry_shipping_factor; ?></td>
																		<td class="right"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][shipping_factor]" value="<?php echo $data['shipping_factor']; ?>" size="5" /></td>
																	</tr>
																<?php } ?>
															</tbody>
														</table>													
													</div>
													<div class="oca-entry"><?php echo $entry_rates; ?></div>
													<div class="oca-input">
														<textarea name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][rates]" cols="45" rows="6"><?php echo $data['rates']; ?></textarea>
													</div>
													<div class="oca-entry"><?php echo $entry_shipping_cost; ?></div>
													<div class="oca-input" align="center">
														<table class="oca-table-noborder">
															<thead>
																<tr>
																	<td class="center"><?php echo $text_min; ?></td>
																	<td class="center"><?php echo $text_max; ?></td>
																	<td class="center"><?php echo $text_add; ?></td>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][cost_min]" value="<?php echo $data['cost_min']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][cost_max]" value="<?php echo $data['cost_max']; ?>" size="5" /></td>
																	<td class="center"><input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][cost_add]" value="<?php echo $data['cost_add']; ?>" size="5" /></td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="oca-entry"><?php echo $entry_freight_fee; ?></div>
													<div class="oca-input">
														<input type="text" name="<?php echo $extension; ?>_rate[<?php echo $rate_row; ?>][freight_fee]" value="<?php echo $data['freight_fee']; ?>" size="5" />
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<?php $rate_row++; ?>
						<?php } ?>
					<?php } ?>
					<div id="oca-foot" class="oca-rate">
						<div class="oca-footer">
							<div class="buttons"><a onclick="$('#form').attr('action', '<?php echo $action; ?>&apply=true'); $('#form').submit();" class="button"><span><?php echo $button_apply; ?></span></a> <a onclick="addRate();" class="button"><span><?php echo $button_add_rate; ?></span></a></div>
						</div>
					</div>
				</form>
				<center><?php echo $text_contact; ?></center>
			</div>
		</div>
	</div>
<?php if ($ocversion >= 150) { ?>
	</div>
<?php } ?>

<script type="text/javascript"><!--
var rate_row = <?php echo $rate_row; ?>;

function addRate() {	
	html  =  '<div id="rate-row'+ rate_row +'" class="oca-rate">';
	html  += ' <div class="oca-head"><?php echo $text_rates; ?> '+ rate_row +' <div class="oca-remove"><a onclick="if (confirm(\'<?php echo $text_confirm_delete; ?>\')) { $(\'#rate-row'+ rate_row +'\').remove(); }"><img src="view/image/oca_remove.png" alt="<?php echo $button_remove_rate; ?>" /></a></div></div>';
	html  += ' <div class="oca-content">';
	html  += '  <table class="oca-table">';
	html  += '   <thead>';
	html  += '    <tr>';
	html  += '     <td class="left" colspan="4" style="border-bottom: 1px solid #DDDDDD;"><?php echo $entry_rate_description; ?> <input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][rate_name]" value="<?php echo $text_rates; ?> '+ rate_row +'" size="115" /></td>';
	html  += '    </tr>';
	html  += '    <tr>';
	html  += '     <td class="center"><?php echo $text_general; ?></td>';
	html  += '	   <td class="center"><?php echo $text_criteria; ?></td>';
	html  += '	   <td class="center"><?php echo $text_parameters; ?></td>';
	html  += '	   <td class="center"><?php echo $text_calculations; ?></td>';
	html  += '	  </tr>';
	html  += '   </thead>';
	html  += '	 <tbody>';
	html  += '	  <tr>';
	html  += '	   <td class="center" style="vertical-align:top;">';
	html  += '		<div class="oca-entry"><?php echo $entry_rate_status; ?></div>';
	html  += '		<div class="oca-input">';
	html  += '		 <select name="<?php echo $extension; ?>_rate['+ rate_row +'][status]">';
	html  += '		  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
	html  += '		  <option value="0"><?php echo $text_disabled; ?></option>';
	html  += '		 </select>';
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_name; ?></div>';
	html  += '		<div class="oca-input">';
					 <?php foreach ($languages as $language) { ?>
	html  += '		  <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][name][<?php echo $language['code']; ?>]" value="" size="25" /><br />';
					 <?php } ?>
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_multirate; ?></div>';
	html  += '		<div class="oca-input">';
	html  += '		 <select name="<?php echo $extension; ?>_rate['+ rate_row +'][multirate]">';
					  <?php foreach ($multirates as $multirate) { ?>
	html  += '		   <option value="<?php echo $multirate['id']; ?>"><?php echo $multirate['name']; ?></option>';
					  <?php } ?>
	html  += '		 </select>';
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_rate_sort_order; ?></div>';
	html  += '		<div class="oca-input"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][sort_order]" value="" size="5" /></div>';
	html  += '      <div class="oca-entry"><?php echo $entry_tax; ?></div>';
	html  += '		<div class="oca-input">';
	html  += '		 <select name="<?php echo $extension; ?>_rate['+ rate_row +'][tax_class_id]">';
	html  += '		  <option value="0"><?php echo $text_none; ?></option>';
					  <?php foreach ($tax_classes as $tax_class) { ?>
	html  += '		   <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo str_replace("'", "&#39;", $tax_class['title']); ?></option>';
					  <?php } ?>
	html  += '		 </select>';
	html  += '		</div>';
	html  += '	   </td>';
	html  += '	   <td class="center" style="vertical-align:top;">';
	html  += '		<div class="oca-entry"><?php echo $entry_stores; ?></div>';
	html  += '		<div class="oca-input">';
	html  += '		 <div class="scrollbox" style="width:100%; text-align:left;">';
					  <?php $class = 'even'; ?>
	html  += '		  <div class="<?php echo $class; ?>"><input type="checkbox" name="<?php echo $extension; ?>_rate['+ rate_row +'][stores][]" value="0" checked="checked" /><?php echo str_replace("'", "&#39;", $this->config->get('config_name')); ?></div>';
					  <?php foreach ($stores as $store) { ?>
	html  += '		   <div class="<?php echo $class; ?>"><input type="checkbox" name="<?php echo $extension; ?>_rate['+ rate_row +'][stores][]" value="<?php echo $store['store_id']; ?>" checked="checked" /><?php echo str_replace("'", "&#39;", $store['name']); ?></div>';
					  <?php } ?>
	html  += '		 </div>';
	html  += '		 <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>';
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_customer_groups; ?></div>';
	html  += '		<div class="oca-input">';
	html  += '		 <div class="scrollbox" style="width:100%; text-align:left;">';
					  <?php $class = 'even'; ?>
	html  += '		  <div class="<?php echo $class; ?>"><input type="checkbox" name="<?php echo $extension; ?>_rate['+ rate_row +'][customer_groups][]" value="0" checked="checked" /><i><?php echo $text_guest_checkout; ?></i></div>';
					  <?php foreach ($customer_groups as $customer_group) { ?>
	html  += '		   <div class="<?php echo $class; ?>"><input type="checkbox" name="<?php echo $extension; ?>_rate['+ rate_row +'][customer_groups][]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" /><?php echo str_replace("'", "&#39;", $customer_group['name']); ?></div>';
					  <?php } ?>
	html  += '		 </div>';
	html  += '		 <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>';
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_geo_zones; ?></div>';
	html  += '		<div class="oca-input">';
	html  += '		 <div class="scrollbox" style="width:100%; text-align:left;">';
					  <?php $class = 'even'; ?>
	html  += '		  <div class="<?php echo $class; ?>"><input type="checkbox" name="<?php echo $extension; ?>_rate['+ rate_row +'][geo_zones][]" value="0" checked="checked" /><i><?php echo $text_all_zones; ?></i></div>';
					  <?php foreach ($geo_zones as $geo_zone) { ?>
	html  += '		   <div class="<?php echo $class; ?>"><input type="checkbox" name="<?php echo $extension; ?>_rate['+ rate_row +'][geo_zones][]" value="<?php echo $geo_zone['geo_zone_id']; ?>" checked="checked" /><?php echo str_replace("'", "&#39;", $geo_zone['name']); ?></div>';
					  <?php } ?>
	html  += '		 </div>';
	html  += '		 <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>';
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_postal_codes; ?></div>';
	html  += '		<div class="oca-input">';
	html  += '		 <select name="<?php echo $extension; ?>_rate['+ rate_row +'][postal_code_type]">';
					  <?php foreach ($postal_code_types as $postal_code_type) { ?>
	html  += '		   <option value="<?php echo $postal_code_type['id']; ?>"><?php echo $postal_code_type['name']; ?></option>';
   					  <?php } ?>
	html  += '		 </select>';
	html  += '		 <br/><textarea name="<?php echo $extension; ?>_rate['+ rate_row +'][postal_codes]" cols="45" rows="3"></textarea>';
	html  += '		</div>';
	html  += '	   </td>';
	html  += '	   <td class="center" style="vertical-align:top;">';
	html  += '		<div class="oca-entry"><?php echo $entry_cart_values; ?></div>';
	html  += '		<div class="oca-input" align="center">';
	html  += '		 <table class="oca-table-noborder">';
	html  += '		  <thead>';
	html  += '		   <tr>';
	html  += '			<td class="left">&nbsp;</td>';
	html  += '			<td class="center"><?php echo $text_min; ?></td>';
	html  += '			<td class="center"><?php echo $text_max; ?></td>';
	html  += '			<td class="center"><?php echo $text_add; ?></td>';
	html  += '		   </tr>';
	html  += '		  </thead>';
	html  += '		  <tbody>';
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_quantity; ?></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][quantity_min]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][quantity_max]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][quantity_add]" value="" size="5" /></td>';
	html  += '		   </tr>';
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_total; ?></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][total_min]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][total_max]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][total_add]" value="" size="5" /></td>';
	html  += '		   </tr>';
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_weight; ?></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][weight_min]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][weight_max]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][weight_add]" value="" size="5" /></td>';
	html  += '		   </tr>';
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_volume; ?></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][volume_min]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][volume_max]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][volume_add]" value="" size="5" /></td>';
	html  += '		   </tr>';
	html  += '		  </tbody>';
	html  += '		 </table>';
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_product_dimensions; ?></div>';
	html  += '		<div class="oca-input" align="center">';
	html  += '		 <table class="oca-table-noborder">';
	html  += '		  <thead>';
	html  += '		   <tr>';
	html  += '			<td class="left">&nbsp;</td>';
	html  += '			<td class="center"><?php echo $text_min; ?></td>';
	html  += '			<td class="center"><?php echo $text_max; ?></td>';
	html  += '			<td class="center"><?php echo $text_add; ?></td>';
	html  += '		   </tr>';
	html  += '		  </thead>';
	html  += '		  <tbody>';
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_length; ?></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][length_min]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][length_max]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][length_add]" value="" size="5" /></td>';
	html  += '		   </tr>';
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_width; ?></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][width_min]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][width_max]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][width_add]" value="" size="5" /></td>';
	html  += '		   </tr>';
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_height; ?></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][height_min]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][height_max]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][height_add]" value="" size="5" /></td>';
	html  += '		   </tr>';
	html  += '		  </tbody>';
	html  += '		 </table>';
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_categories; ?></div>';
	html  += '		<div class="oca-input" align="center">';
	html  += '		 <table class="oca-table-noborder" style="width: 100%;">';
	html  += '		  <tbody>';
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_category_setting; ?></td>';
	html  += '			<td class="right">';
	html  += '			 <select name="<?php echo $extension; ?>_rate['+ rate_row +'][category_setting]">';
						  <?php foreach ($category_settings as $category_setting) { ?>
	html  += '			   <option value="<?php echo $category_setting['id']; ?>"><?php echo $category_setting['name']; ?></option>';
						  <?php } ?>
	html  += '			 </select>';
	html  += '			</td>';
	html  += '		   </tr>';
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_cost_setting; ?></td>';
	html  += '			<td class="right">';
	html  += '			 <select name="<?php echo $extension; ?>_rate['+ rate_row +'][cost_setting]">';
						  <?php foreach ($cost_settings as $cost_setting) { ?>
	html  += '			   <option value="<?php echo $cost_setting['id']; ?>"><?php echo $cost_setting['name']; ?></option>';
						  <?php } ?>
	html  += '			 </select>';
	html  += '			</td>';
	html  += '		   </tr>';
	html  += '		  </tbody>';
	html  += '		 </table>';
	html  += '		 <div class="scrollbox" style="width:100%; text-align:left;">';
					  <?php $class = 'even'; ?>
	html  += '		  <div class="<?php echo $class; ?>"><input type="checkbox" name="<?php echo $extension; ?>_rate['+ rate_row +'][categories][]" value="0" checked="checked" /><i><?php echo $text_all_categories; ?></i></div>';
					  <?php foreach ($categories as $category) { ?>
	html  += '		   <div class="<?php echo $class; ?>"><input type="checkbox" name="<?php echo $extension; ?>_rate['+ rate_row +'][categories][]" value="<?php echo $category['category_id']; ?>" /><?php echo str_replace("'", "&#39;", $category['name']); ?></div>';
					  <?php } ?>
	html  += '		 </div>';
	html  += '		 <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(\':checkbox\').attr(\'checked\', false);"><?php echo $text_unselect_all; ?></a>';
	html  += '		</div>';
	html  += '	   </td>';
	html  += '	   <td class="center" style="vertical-align:top;">';
	html  += '		<div class="oca-entry"><?php echo $entry_rate_settings; ?></div>';
	html  += '		<div class="oca-input" align="center">';
	html  += '		 <table class="oca-table-noborder">';
	html  += '		  <tbody>';
					   <?php if (isset($rate_types)) { ?>
	html  += '		    <tr>';
	html  += '			 <td class="left"><?php echo $entry_rate_type; ?></td>';
	html  += '			 <td class="right">';
	html  += '			  <select name="<?php echo $extension; ?>_rate['+ rate_row +'][rate_type]" onchange="$(this).val() == \'4\' ? $(\'#shipping_factor'+ rate_row +'\').fadeIn(\'slow\') : $(\'#shipping_factor'+ rate_row +'\').hide()">';
						   <?php foreach ($rate_types as $rate_type) { ?>
	html  += '			    <option value="<?php echo $rate_type['id']; ?>"><?php echo $rate_type['name']; ?></option>';
						   <?php } ?>
	html  += '			  </select>';
	html  += '			 </td>';
	html  += '		    </tr>';
					   <?php } ?>
	html  += '		   <tr>';
	html  += '			<td class="left"><?php echo $entry_final_cost; ?></td>';
	html  += '			<td class="right">';
	html  += '			 <select name="<?php echo $extension; ?>_rate['+ rate_row +'][final_cost]">';
						  <?php foreach ($final_costs as $final_cost) { ?>
	html  += '			   <option value="<?php echo $final_cost['id']; ?>"><?php echo $final_cost['name']; ?></option>';
						  <?php } ?>
	html  += '			 </select>';
	html  += '			</td>';
	html  += '		   </tr>';
					   <?php if ($display_shipping_factor) { ?>
	html  += '		    <tr id="shipping_factor'+ rate_row +'" <?php if ($extension == 'ocaadvancedshipping') { echo 'style="display: none;"'; } ?>>';
	html  += '			 <td class="left"><?php echo $entry_shipping_factor; ?></td>';
	html  += '			 <td class="right"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][shipping_factor]" value="" size="5" /></td>';
	html  += '		    </tr>';
					   <?php } ?>
	html  += '		  </tbody>';
	html  += '		 </table>';												
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_rates; ?></div>';
	html  += '		<div class="oca-input"><textarea name="<?php echo $extension; ?>_rate['+ rate_row +'][rates]" cols="45" rows="6"></textarea></div>';
	html  += '		<div class="oca-entry"><?php echo $entry_shipping_cost; ?></div>';
	html  += '		<div class="oca-input" align="center">';
	html  += '		 <table class="oca-table-noborder">';
	html  += '		  <thead>';
	html  += '		   <tr>';
	html  += '			<td class="center"><?php echo $text_min; ?></td>';
	html  += '			<td class="center"><?php echo $text_max; ?></td>';
	html  += '			<td class="center"><?php echo $text_add; ?></td>';
	html  += '		   </tr>';
	html  += '		  </thead>';
	html  += '		  <tbody>';
	html  += '		   <tr>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][cost_min]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][cost_max]" value="" size="5" /></td>';
	html  += '			<td class="center"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][cost_add]" value="" size="5" /></td>';
	html  += '		   </tr>';
	html  += '		  </tbody>';
	html  += '		 </table>';
	html  += '		</div>';
	html  += '		<div class="oca-entry"><?php echo $entry_freight_fee; ?></div>';
	html  += '		<div class="oca-input"><input type="text" name="<?php echo $extension; ?>_rate['+ rate_row +'][freight_fee]" value="" size="5" /></div>';
	html  += '	   </td>';
	html  += '	  </tr>';
	html  += '	 </tbody>';
	html  += '	</table>';
	html  += ' </div>';
	html  += '</div>';
	
	$('#oca-foot').before(html);
	
	rate_row++;
}
//--></script>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery(".oca-content").hide();
		jQuery(".oca-head").click(function() {
			jQuery(this).next(".oca-content").slideToggle(500);
		});
	});
</script>

<script type="text/javascript"><!--
	<?php if ($ocversion >= 150) { ?>
		$('#help a').tabs();
	<?php } else { ?>
		$.tabs('#help a'); 
	<?php } ?>
//--></script>  

<?php echo $footer; ?> 