<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
			<tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_id; ?></span></td>
              <td><input type="text" name="id" value="<?php echo $id; ?>" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="required">*</span> <span class="entry"><?php echo $entry_name; ?></span></td>
              <td><input type="text" name="name" value="<?php echo $name; ?>" />
                <?php if ($error_name) { ?>
                <span class="error"><?php echo $error_name; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><span class="entry"><?php echo $entry_area; ?></span></td>
              <td><input type="text" name="area" value="<?php echo $area; ?>" />
                <?php if ($error_area) { ?>
                <span class="error"><?php echo $error_area; ?></span>
                <?php } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_email; ?></td>
              <td><input type="text" name="email" value="<?php echo $email; ?>" />
                <?php if ($error_email) { ?>
                <span class="error"><?php echo $error_email; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_address; ?></td>
              <td><textarea rows="4" cols="28" name="address"><?php if ($error_address) { ?><span class="error"><?php echo $error_address; ?></span><?php } else if ($address){ ?><?php echo $address; ?> <?php } else { ?><?php echo "Please insert full address (Address, City, Post Code, Province/Region)"; ?> <?php } ?></textarea></td>
            </tr>
            <tr>
              <td><?php echo $entry_telephone; ?></td>
              <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />
                <?php if ($error_telephone) { ?>
                <span class="error"><?php echo $error_telephone; ?></span>
                <?php  } ?></td>
            </tr>
            <tr>
              <td><?php echo $entry_fax; ?></td>
              <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
            </tr>

            <tr>
              <td><span class="required">*</span> <?php echo $entry_code; ?></td>
              <td><input type="code" name="code" value="<?php echo $code; ?>"  />
                <?php if ($error_code) { ?>
                <span class="error"><?php echo $error_code; ?></span>
                <?php } ?></td>
            </tr>			
			
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
<!-- v1.1 -->
            <tr>
              <td><?php echo $entry_public; ?></td>
              <td><select name="public">
                  <?php if ($public) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_alert; ?></td>
              <td><select name="alert">
                  <?php if ($alert) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_additional_emails; ?></td>
              <td><textarea name="additional_emails" cols="40" rows="5"><?php echo $additional_emails; ?></textarea></td>
            </tr>			
<!-- v1.1 end -->
			<tr>
              <td><?php echo $entry_cargo; ?></td>
              <td><select name="cargo">
				  <?php if ($cargo) { ?>
					  <option value="0">Seleccione</option>
					  <?php foreach ($statuses as $status) { ?>
						<?php if($status['id_cargo'] == $cargo) { ?>
							<option value="<?php echo $status['id_cargo']; ?>" selected="selected"><?php echo $status['nombre']; ?></option>
				        <?php } else { ?>
							<option value="<?php echo $status['id_cargo']; ?>"><?php echo $status['nombre']; ?></option>	
						<?php } ?>
						<?php } ?>
				  <?php } else { ?>
					  <option value="0">Seleccione</option>
					  <?php foreach ($statuses as $status) { ?>
							<option value="<?php echo $status['id_cargo']; ?>"><?php echo $status['nombre']; ?></option>	
						<?php } ?>
				  <?php } ?>
                </select></td>
            </tr>
			</table>
		</form>
    </div>
  </div>
</div>
<?php echo $footer; ?>