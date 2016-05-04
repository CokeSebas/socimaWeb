<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<div class="box">
		<div class="heading">
			<h1><img src="view/image/admin_theme/base5builder_circloid/icon-dashboard.png" alt="Dashboard Editor" width="32" height="32" /> <?php echo $heading_dashboard_editor; ?></h1>
		</div>
		<div class="content">
			<div id="dashboard-editor">
				<div class="hidden text_confirm"><?php echo $text_confirm; ?></div>
				<div class="dashboard-editor-content">
					<?php if(isset($this->session->data['success'])){ ?>
					<div class="success"><?php echo $this->session->data['success']; ?></div>
					<?php unset($this->session->data['success']); ?>
					<?php } ?>

					<?php if(isset($this->session->data['error'])){ ?>
					<div class="warning"><?php echo $this->session->data['error']; ?></div>
					<?php unset($this->session->data['error']); ?>
					<?php } ?>
					<div class="htabs" id="tabs">
						<a href="#tab-circloid-settings" class="active"><?php echo $heading_circloid_settings ?></a>
						<a href="#tab-color-profiles" class=""><?php echo $heading_color_profile ?></a>
						<a href="#tab-widget-editor" class=""><?php echo $heading_widget_editor ?></a>
					</div>
					<div class="dashboard-editor-setting" id="tab-circloid-settings">
						<div class="sub-heading">
							<div class="loading">
								<img src='view/image/admin_theme/base5builder_circloid/loading.gif' width="32" height="32" alt="Loading" />
							</div>
							<h2><?php echo $heading_circloid_settings ?></h2>
							<?php if($circloid_settings){ ?>
							<div class="buttons">
								<a id="settings-save" href="#" role="button" class="btn btn-success"><?php echo $button_save; ?></a>
								<a class="btn btn-danger dashboard-close" href="<?php echo $return_dashboard; ?>"><?php echo $button_edit_close; ?></a>
							</div>
							<?php } ?>
						</div>
						<div class="circloid-settings-content">

							<?php if(!$circloid_settings){ ?>
							<p>
								<?php echo $text_installation_info; ?>
							</p>
							<p>
								<a href="<?php echo $install_circloid_settings; ?>" role="button" class="btn btn-primary"><?php echo $button_update; ?></a>
							</p>
							<?php }else{ ?>
							<table class="table">

								<?php
								foreach($circloid_settings as $circloid_setting){
									switch ($circloid_setting['name']) {
										default:
										case 'out_stock':
										?>

										<tr>
											<td><?php echo $text_out_stock; ?></td>
											<td>
												<select id="out-stock-control">
													<?php
													if($circloid_setting['value'] == "1"){
														?>
														<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
														<option value="0"><?php echo $text_disabled; ?></option>
														<?php
													}else{
														?>
														<option value="1"><?php echo $text_enabled; ?></option>
														<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
														<?php
													}
													?>
												</select>
											</td>
										</tr>

										<?php
										break;

										case 'low_stock':
										?>

										<tr>
											<td><?php echo $text_low_stock; ?></td>
											<td>
												<select id="low-stock-control">
													<?php
													if($circloid_setting['value'] == "1"){
														?>
														<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
														<option value="0"><?php echo $text_disabled; ?></option>
														<?php
													}else{
														?>
														<option value="1"><?php echo $text_enabled; ?></option>
														<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
														<?php
													}
													?>
												</select>
											</td>
										</tr>

										<?php
										break;

										case 'low_stock_count':
										?>

										<tr>
											<td><?php echo $text_low_stock_count; ?></td>
											<td>
												<input id="low-stock-count" type="text" value="<?php echo $circloid_setting['value']; ?>" name="low_stock_count">
											</td>
										</tr>

										<?php
										break;

										case 'menu_event_type':
										?>
										<tr>
											<td><?php echo $text_menu_event_type; ?></td>
											<td>
												<select id="menu-event-type-control">
													<?php
													if($circloid_setting['value'] == "click"){
														?>
														<option value="click" selected="selected"><?php echo $text_click; ?></option>
														<option value="hover"><?php echo $text_hover; ?></option>
														<?php
													}else{
														?>
														<option value="click"><?php echo $text_click; ?></option>
														<option value="hover" selected="selected"><?php echo $text_hover; ?></option>
														<?php
													}
													?>
												</select>
											</td>
										</tr>

										<?php
										break;
									}
								}
								?>
								<tr>
									<td><?php echo $text_import_menu_intro; ?></td>
									<td>
										<a href="<?php echo $link_import_menu ?>" class="btn"><?php echo $button_import_menu; ?></a>
									</td>
								</tr>
							</table>
							<?php } ?>
						</div>
					</div>
					<div class="dashboard-editor-color-profile" id="tab-color-profiles">
						<div class="sub-heading">
							<div class="loading">
								<img src='view/image/admin_theme/base5builder_circloid/loading.gif' width="32" height="32" alt="Loading" />
							</div>
							<h2><?php echo $heading_color_profile ?></h2>
							<div class="buttons">
								<a class="btn btn-danger dashboard-close" href="<?php echo $return_dashboard; ?>"><?php echo $button_edit_close; ?></a>
							</div>
						</div>
						<table class="list">
							<thead>
								<tr>
									<td class="left"><?php echo $title_profile_name; ?></td>
									<td class="left"><?php echo $title_status; ?></td>
									<td class="right"><?php echo $title_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php

								foreach($color_profile as $profile){
									?>
									<tr>
										<td class="left"><?php echo $profile['preset_name'] ?></td>
										<td class="left">
											<?php
											if($profile['enabled'] == "1"){
												echo "<span class='enabled'>" . $text_enabled . "</span>";
												echo "<span class='disabled hidden'>" . $text_disabled . "</span>";
											}else{
												echo "<span class='disabled'>" . $text_disabled . "</span>";
												echo "<span class='enabled hidden'>" . $text_enabled . "</span>";
											}
											?>
										</td>
										<td class="action right">
											<?php
											if($profile['enabled'] != "1"){
												echo "<span class=''>[ <a href='#' class='enable-color-profile' data-id='" . $profile['id'] . "'>" . $text_enable . "</a> ]</span>";
											}else{												
												echo "<span class='hidden'>[ <a href='#' class='enable-color-profile' data-id='" . $profile['id'] . "'>" . $text_enable . "</a> ]</span>";
											}
											?>
										</td>
									</tr>
									<?php
								}

								?>
							</tbody>
						</table>
					</div>
					<div class="dashboard-editor-widget-editor" id="tab-widget-editor">
						<div class="sub-heading">
							<div class="loading">
								<img src='view/image/admin_theme/base5builder_circloid/loading.gif' width="32" height="32" alt="Loading" />
							</div>
							<h2><?php echo $heading_widget_editor ?></h2>
							<div class="buttons">
								<a class="btn btn-danger dashboard-close" href="<?php echo $return_dashboard; ?>"><?php echo $button_edit_close; ?></a>
							</div>
							<div class="buttons">
								<a href="#create-new-layout-modal" role="button" class="btn btn-primary dashboard-new-layout" data-toggle="modal"><?php echo $text_create_new_layout; ?></a>
							</div>
						</div>
						<div class="short-description"><?php echo $text_widget_editor_intro; ?></div>
						<table class="list">
							<thead>
								<tr>
									<td class="left"><?php echo $title_layout_name; ?></td>
									<td class="left"><?php echo $title_description; ?></td>
									<td class="left"><?php echo $title_status; ?></td>
									<td class="right"><?php echo $title_action; ?></td>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($widget_data as $list_item){
									?>
									<tr>
										<td class="left"><?php echo $list_item['layout_name']; ?></td>
										<td class="left"><?php echo $list_item['description']; ?></td>
										<td class="left">
											<?php
											if($list_item['enabled'] == 1){
												echo "<span class='enabled'>" . $text_enabled . "</span>";
												echo "<span class='disabled hidden'>" . $text_disabled . "</span>";
											}else{
												echo "<span class='disabled'>" . $text_disabled . "</span>";
												echo "<span class='enabled hidden'>" . $text_enabled . "</span>";
											}
											?>
										</td>
										<td class="action right">
											<?php


											if($list_item['creator'] == "user"){
												echo '[ <a href="' . $edit_widget_layout . $list_item['id'] . '" class="edit-widget-layout" data-id="' . $list_item['id'] . '">' . $text_edit . '</a> ]';
												echo '[ <a href="#" class="delete-widget-layout" data-id="' . $list_item['id'] . '">' . $text_delete . '</a> ]';
											}

											if($list_item['enabled'] != "1"){
												echo "<span class=''>&nbsp;&nbsp;&nbsp;[ <a href='#' class='enable-widget-layout' data-id='" . $list_item['id'] . "'>" . $text_enable . "</a> ]</span>";
											}else{												
												echo "<span class='hidden'>&nbsp;&nbsp;&nbsp;[ <a href='#' class='enable-widget-layout' data-id='" . $list_item['id'] . "'>" . $text_enable . "</a> ]</span>";
											}
											?>
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
						<div id="create-new-layout-modal-outer">
							<div id="create-new-layout-modal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h3>Create New Layout</h3>
								</div>
								<div class="modal-body">
									<div class="loading">
										<img src='view/image/admin_theme/base5builder_circloid/loading.gif' width="32" height="32" alt="Loading" />
									</div>
									<form>
										<div class="form-item">
											<label for="old-layouts"><?php echo $text_new_layout_copy_from; ?></label>
											<select id="old-layouts">
												<?php
												foreach($widget_data as $list_item){
													?>

													<option value="<?php echo $list_item['id'] ?>">
														<?php echo $list_item['layout_name'] ?>
													</option>

													<?php
												}
												?>
											</select>
											<div class="clearfix"></div>
										</div>
										<div class="form-item">
											<label for="new-layout-name"><?php echo $text_new_layout_name; ?></label>
											<input type="text" name="new-layout-name" id="new-layout-name" class="input-block-level" placeholder="New Layout Name (20 characters max.)" value="" maxlength="35">
											<div class="clearfix"></div>
										</div>
										<div class="form-item">
											<label for="new-description"><?php echo $text_new_layout_description; ?></label>
											<input type="text" name="new-description" id="new-description" class="input-block-level" placeholder="Description (100 characters max.)" value="" maxlength="100">
											<div class="clearfix"></div>
										</div>
									</form>
								</div>
								<div class="modal-footer">
									<input id="cancel-new-layout" type="button" value="Cancel" class="btn" data-dismiss="modal">
									<input id="create-layout" type="button" value="Create" class="btn btn-success">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 
<?php echo $footer; ?>
