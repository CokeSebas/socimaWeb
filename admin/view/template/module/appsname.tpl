<?php echo $header; ?>
<style>
#tooltips{color:#222;font-size:11px;text-shadow:1px 1px 0 #fff;border:1px solid #666;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;background-color:#EFEFEF;-moz-box-shadow:0 0 4px #bbb;-webkit-box-shadow:0 0 4px #bbb;box-shadow:0 0 4px #bbb;line-height:1.2em;padding:5px;position:absolute;z-index:100000;display:none}
</style>
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
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
		<tr>
          <td><?php echo $entry_apps_fbl_limit; ?></td>
		  <td><input type="text" name="apps_fbl_name_limit" value="<?php echo isset($apps_fbl_name_limit) ? $apps_fbl_name_limit : '33'; ?>" size="10"></td>	
	    </tr>
		
		<tr>
          <td><?php echo $entry_apps_cat_limit; ?></td>
		  <td><input type="text" name="apps_cat_limit" value="<?php echo isset($apps_cat_limit) ? $apps_cat_limit : '60'; ?>" size="10"></td>	
	    </tr>
		
        <tr>
          <td><?php echo $entry_status; ?></td>
          <td><select name="appsname_status">
                <?php if ($appsname_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>	  
	    </tr>
        </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>