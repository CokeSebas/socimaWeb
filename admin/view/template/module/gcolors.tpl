<head><script type="text/javascript" src="view/javascript/jscolor/jscolor.js"></script></head>
<?php
//==============================================================================
// Gsearch Plugin
// 
// Author: Onjection Solutions
// E-mail: gaurav@onjection.com
// Website: http://www.onjection.com
//==============================================================================


 echo $header; ?>
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
      <h1><?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="location = '<?php echo $cart_button; ?>';" class="button"><span><?php echo "Chart Dashboard"; ?></span></a><a onclick="location = '<?php echo $gshistory; ?>';" class="button"><span><?php echo $button_history; ?></span></a><a onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
  <?php
    if(isset($color_id)){
      $color = $color_id;
    }
    else{
      $color = "6621DD";
    }
  ?>
   <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
      <tr>
            <td><?php echo $choose_color_id; ?></td>
            <td><input type="text" name="color_id" class="color" value="<?php echo $color; ?>" size="45" />
              <?php if ($error_color_id) { ?>
              <span class="error"><?php echo $error_color_id; ?></span>
              <?php } ?></td>

      </tr>

      <tr>
          <td><?php echo $color_status; ?></td>
          <td><select name="gcolors_status">
              <?php if ($gcolors_status) { ?>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <option value="0"><?php echo $text_disabled; ?></option>
              <?php } else { ?>
              <option value="1"><?php echo $text_enabled; ?></option>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <?php } ?>
            </select></td></tr>
    <tr>
    <tr>
      <td>Limit:</td> 
      <td><input type="text" value="<?php  echo $this->config->get('history_limit'); ?>" name="history_limit" /></td>
        </tr>
       
    </form>
    <tr>
    
    </tr>
      </table>
  </div>
</div>
<?php echo $footer; ?>