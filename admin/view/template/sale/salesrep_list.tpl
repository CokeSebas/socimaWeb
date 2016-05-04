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
  <?php if ($success) { ?>
  <!--<div class="success"><?php echo $success; ?></div>-->
  <div class="success"><a target="_blank" href="http://socimagestion.com/Movil/Sistema.php"><?php echo "Recuerde actualizar los datos para el sistema Movil"; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading" style="margin: 4px;">
<!-- v1.1 -->	
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><!-- <a onclick="$('form').attr('action', '<?php echo $public; ?>'); $('form').submit();" class="button"><span><?php echo $button_public; ?></span></a><a onclick="$('form').attr('action', '<?php echo $alert; ?>'); $('form').submit();" class="button"><span><?php echo $button_alert; ?></span></a>--><a onclick="location = '<?php echo $insert; ?>'" class="button"><span><?php echo $button_insert; ?></span></a><a onclick="$('form').attr('action', '<?php echo $delete; ?>'); $('form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
<!-- v1.1 end -->
	  </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
          <tr>
            <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
            <td class="left"><?php if ($sort == 'name') { ?>
              <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'email') { ?>
              <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
              <?php } ?></td>
           <!-- <td class="left"><?php if ($sort == 'area') { ?>
              <a href="<?php echo $sort_area; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_area; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_area; ?>"><?php echo $column_area; ?></a>
              <?php } ?></td>   -->            
            <td class="left"><?php if ($sort == 'status') { ?>
              <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
              <?php } ?></td>
<!-- v1.1 -->
            <td class="left"><?php if ($sort == 'public') { ?>
              <a href="<?php echo $sort_public; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_public; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_public; ?>"><?php echo $column_public; ?></a>
              <?php } ?></td>
            <td class="left"><?php if ($sort == 'alert') { ?>
              <a href="<?php echo $sort_alert; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_alert; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_alert; ?>"><?php echo $column_alert; ?></a>
              <?php } ?></td>			  
<!-- v1.1 end -->
			  <td class="left"><?php if ($sort == 'telephone') { ?>
              <a href="<?php echo $sort_telephone; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_telephone; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_telephone; ?>"><?php echo $column_telephone; ?></a>
              <?php } ?></td>              
            <td class="left"><?php if ($sort == 'date_added') { ?>
              <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
              <?php } ?></td>
            <td class="right"><?php echo $column_action; ?></td>
          </tr>
          </thead>
          <tbody>
          <tr class="filter">
            <td></td>
            <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
            <td><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>
          <!--  <td><input type="text" name="filter_area" value="<?php echo $filter_area; ?>" /></td> -->
            <td><select name="filter_status">
                <option value="*"></option>
                <?php if ($filter_status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <?php } ?>
                <?php if (!is_null($filter_status) && !$filter_status) { ?>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select></td>
<!-- v1.1 -->			  
            <td><select name="filter_public">
                <option value="*"></option>
                <?php if ($filter_public) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if (!is_null($filter_public) && !$filter_public) { ?>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
            <td><select name="filter_alert">
                <option value="*"></option>
                <?php if ($filter_alert) { ?>
                <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_yes; ?></option>
                <?php } ?>
                <?php if (!is_null($filter_alert) && !$filter_alert) { ?>
                <option value="0" selected="selected"><?php echo $text_no; ?></option>
                <?php } else { ?>
                <option value="0"><?php echo $text_no; ?></option>
                <?php } ?>
              </select></td>
<!-- v1.1 end -->			  
            <td><input type="text" name="filter_telephone" value="<?php echo $filter_telephone; ?>" /></td>            <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
            <td align="right"><a onclick="filter();" class="button"><span><?php echo $button_filter; ?></span></a></td>
          </tr>
        <?php if ($salesreps) { ?>
			<?php foreach ($salesreps as $salesrep) { ?>
				<?php if ($salesrep['salesrep_id'] > 0 ) { ?>		  
				  <tr>
					<td style="text-align: center;"><?php if ($salesrep['selected']) { ?>
					  <input type="checkbox" name="selected[]" value="<?php echo $salesrep['salesrep_id']; ?>" checked="checked" />
					  <?php } else { ?>
					  <input type="checkbox" name="selected[]" value="<?php echo $salesrep['salesrep_id']; ?>" />
					  <?php } ?></td>
					<td class="left"><?php echo $salesrep['name']; ?></td>
					<td class="left"><?php echo $salesrep['email']; ?></td>
					<!-- <td class="left"><?php echo $salesrep['area']; ?></td> -->
					<td class="left"><?php echo $salesrep['status']; ?></td>
<!-- v1.1 -->
					<td class="left"><?php echo $salesrep['public']; ?></td>
					<td class="left"><?php echo $salesrep['alert']; ?></td>
<!-- v1.1 end -->
					<td class="left"><?php echo $salesrep['telephone']; ?></td>
					<td class="left"><?php echo $salesrep['date_added']; ?></td>
					<td class="right"><?php foreach ($salesrep['action'] as $action) { ?>
					  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
					  <?php } ?></td>
				  </tr>
				<?php } ?>				  
			<?php } ?>
		<?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=sale/salesrep&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_email = $('input[name=\'filter_email\']').attr('value');
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').attr('value');
	
	if (filter_customer_group_id != '*') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}	
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}	

	var filter_public = $('select[name=\'filter_public\']').attr('value');
	
	if (filter_public != '*') {
		url += '&filter_public=' + encodeURIComponent(filter_public); 
	}	

	var filter_alert = $('select[name=\'filter_alert\']').attr('value');
	
	if (filter_alert != '*') {
		url += '&filter_alert=' + encodeURIComponent(filter_alert); 
	}		
	
	var filter_approved = $('select[name=\'filter_approved\']').attr('value');
	
	if (filter_approved != '*') {
		url += '&filter_approved=' + encodeURIComponent(filter_approved);
	}	
	
	var filter_ip = $('input[name=\'filter_ip\']').attr('value');
	
	if (filter_ip) {
		url += '&filter_ip=' + encodeURIComponent(filter_ip);
	}
		
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<?php echo $footer; ?> 