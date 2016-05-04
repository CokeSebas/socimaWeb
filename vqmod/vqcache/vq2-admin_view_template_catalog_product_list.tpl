<?php echo $header; ?>

                
                <style>
              
                input[name=filter_quantity] {
                    width:60px;
                }
                .ajax-edit input.quantity {
                    width:56px;
                }
                .ajax-edit input.price {
                    width:73px;
                }
                select[name=filter_manufacturer] {
                    width:100px;
                }
                .manufacturer-column .ajax-edit select {
                    width:95px;
                }
                #category_filter_column {
                  width:150px;
                }
                input[name=filter_model] {
                  width:80px;
                }
                select[name=filter_status] {
                  width:60px;
                }
                </style>
		
                
            
<div id="content">
<?php if ($success) { ?>
  <!--<div class="success"><?php echo $success; ?></div>-->
  <!--<div class="success"><a target="_blank" href="http://socimagestion.com/Movil/index.php"><?php echo "Recuerde actualizar los datos para el sistema Movil"; ?></div>-->
  <div class="success"><a target="_blank" href="http://socimagestion.com/Movil/Sistema.php"><?php echo "Recuerde actualizar los datos para el sistema Movil"; ?></div>
  <?php } ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  
  <div class="box">
    <div class="heading" style="margin: 4px;">
      <h1>         
                 <?php echo $heading_title; ?>:&nbsp;
                 <select name="filter_category_id_head" id="category_filter_head" onchange="$('#category_filter_column').val($(this).val());filter();">
                    <option value="">&nbsp;</option>
                    <?php foreach($categories as $c) { ?>
                    <option value="<?php echo $c['category_id']?>" <?php echo ($c['category_id'] == $filter_category_id ? 'selected' : '') ?>><?php echo $c['name'] ?></option>
                    <?php } ?>
                 </select>         
                 </h1>
                 <input type="hidden" id="show_category_column" value="<?php echo $show_category_column ?>" />
                 <div title="<?php echo $column_category;  ?>" id="show_category_column_button" style="float:left;height:35px;width:24px;cursor:pointer;background:url('view/image/category.png') no-repeat center bottom" ></div>
                 <input type="hidden" id="show_manufacturer_column" value="<?php echo $show_manufacturer_column ?>" />
                 <div title="<?php echo $column_manufacturer;  ?>" id="show_manufacturer_column_button" style="float:left;height:35px;width:24px;cursor:pointer;background:url('view/image/product.png') no-repeat center bottom" ></div>
                 <input type="hidden" id="show_upc_column" value="<?php echo $show_upc_column ?>" />
            <br>
      <div class="buttons"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('#form').attr('action', '<?php echo $copy; ?>'); $('#form').submit();" class="button"><?php echo $button_copy; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
<div id="response" class="success"> </div>
        <table class="list" id="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="center"><?php echo $column_image; ?></td>
              <td class="left"><?php if ($sort == 'pd.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>

                <td class="left category-column"><?php echo $column_category; ?></td>
                
                <td class="left manufacturer-column"><?php if ($sort == 'm.name') { ?>
                <a href="<?php echo $sort_manufacturer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_manufacturer; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_manufacturer; ?>"><?php echo $column_manufacturer; ?></a>
                <?php } ?></td>

            
              <td class="left"><?php if ($sort == 'p.model') { ?>
                <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_model; ?>"><?php echo 'Descripción'; ?></a>
                <?php } ?></td>
               

              <td class="left"><?php if ($sort == 'p.sku') { ?>
                <a href="<?php echo $sort_sku; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sku; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_sku; ?>"><?php echo $column_sku; ?></a>
                <?php } ?></td>				
		
              <td class="left"><?php if ($sort == 'p.price') { ?>
                <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'p.quantity') { ?>
                <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'p.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>


                <td class="category-column"><select name="filter_category_id" id="category_filter_column" >
                    <option value="">&nbsp;</option>
                    <?php foreach($categories as $c) { ?>
                    <option value="<?php echo $c['category_id']?>" <?php echo ($c['category_id'] == $filter_category_id ? 'selected' : '') ?>><?php echo $c['name'] ?></option>
                    <?php } ?>
                 </select></td>
                
                <td class="manufacturer-column"><select name="filter_manufacturer">
                    <option value="">&nbsp;</option>
                    <?php foreach($manufacturers as $m) { ?>
                    <option value="<?php echo $m['manufacturer_id']?>" <?php echo ($m['manufacturer_id'] == $filter_manufacturer ? 'selected' : '') ?>><?php echo $m['name'] ?></option>
                    <?php } ?>
                 </select></td>
                
               
            
              <td><input type="text" name="filter_model" value="<?php echo $filter_model; ?>" /></td>
              
<td align="left"><input type="text" name="filter_sku" value="<?php echo $filter_sku; ?>" /></td>
              <td align="left"><input type="text" name="filter_price" value="<?php echo $filter_price; ?>" size="8"/></td>
              
              
              <td align="right"><input type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" style="text-align: right;" /></td>
              
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
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($products) { ?>
            <?php foreach ($products as $product) { ?>
            <tr>

            <tr id="arrayorder_<?php echo $product['product_id'] ?>">
			
              <td style="text-align: center;"><?php if ($product['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                <?php } ?></td>
              <td class="center"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
              
                <?php /* <td class="left"><?php echo $product['name']; ?></td> */ ?>         
                <td class="left">
                <?php 
                foreach ($languages as $language) { ?>
                   <div class="product-name-lang">
                      <span id="product-name-lang-<?php echo $language['language_id']; ?>"><?php echo $product_description[$product['product_id']][$language['language_id']]['name']; ?></span>
                      &nbsp;<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> 
                      </br>
                      <?php //echo $product['name']; ?>
                   </div>
                <?php } ?>
                </td>
                

                <td class="category-column" style="padding:2px;" nowrap="nowrap" >
                    <span>
                    <?php $found = false; ?>
                    <?php foreach ($categories as $category) { ?>
                        <?php if(in_array($category['category_id'],$product['categories'])) { ?>
                            <?php $found = true ?>
                            <div><?php echo $category['name']; ?></div>
                        <?php } ?>
                    <?php } ?>
                    <?php if(!$found) {; ?>- - -<?php } ?>
                    </span>                
                </td>

                <!-- manufacturer -->
                <td class="manufacturer-column">
                    <span><?php echo $product['manufacturer_name'];  ?></span>
                </td>
                
         
                
            
              <td class="left"><?php echo $product['model']; ?></td>
<td class="left"><?php echo $product['sku']; ?></td>
             
              <td class="left"><?php if ($product['special']) { ?>
                <span style="text-decoration: line-through;"><?php echo '$' . number_format($product['price'],0,',','.'); ?></span><br/>
                <span style="color: #b00;"><?php echo '$'. number_format($product['special'],0,',','.'); ?></span>
                <?php } else { ?>
                <?php echo '$' . number_format($product['price'],0, ',', '.'); ?>
                <?php } ?></td>
              <td class="right"><?php if ($product['quantity'] <= 0) { ?>
                <span style="color: #FF0000;"><?php echo $product['quantity']; ?></span>
                <?php } elseif ($product['quantity'] <= 5) { ?>
                <span style="color: #FFA500;"><?php echo $product['quantity']; ?></span>
                <?php } else { ?>
                <span style="color: #008000;"><?php echo $product['quantity']; ?></span>
                <?php } ?></td>
              <td class="left"><?php echo $product['status']; ?></td>
              
			  <td class="right"><?php foreach ($product['action'] as $action) { ?>
                <?php if($group_user == 16 OR $group_user == 1){ ?> [<a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ] <?php } ?>
                <?php } ?></td>
            </tr>
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
<script type="text/javascript">
$(document).ready(function(){ 	
	  function slideout(){
  setTimeout(function(){
  $("#response").slideUp("slow", function () {
      });
    
}, 2000);}
	
    $("#response").hide();
	$(function() {
	$("#list tbody").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			
			var order = $(this).sortable("serialize") + '&update=update'; 
			$.post("index.php?route=catalog/product/updateOrder&token=<?php echo $token; ?>", order, function(theResponse){
				$("#response").html(theResponse);
				$("#response").slideDown('slow');
				slideout();
			});
		}								  
		});
	});

});	
</script>
<script type="text/javascript"><!--

                              

                    $(document).ready(function() {
                        <?php if(!$show_category_column) {?>$('.category-column').hide();<?php } ?>
                        <?php if(!$show_manufacturer_column) {?>$('.manufacturer-column').hide();<?php } ?>   
                                       
                        $('#show_category_column_button').click(function() {                        
                            var show_category_column = $('#show_category_column ').attr('value');
                            
                            if(show_category_column == '1') {
                                $('#show_category_column ').attr('value','0');
                                $('.category-column').fadeOut();
                            }                        
                            else {
                                $('#show_category_column ').attr('value','1');
                                $('.category-column').fadeIn();
                            }                                                    
                        });                        

                        $('#show_manufacturer_column_button').click(function() {                        
                            var show_manufacturer_column = $('#show_manufacturer_column ').attr('value');
                            
                            if(show_manufacturer_column == '1') {
                                $('#show_manufacturer_column ').attr('value','0');
                                $('.manufacturer-column').fadeOut();
                            }                        
                            else {
                                $('#show_manufacturer_column ').attr('value','1');
                                $('.manufacturer-column').fadeIn();
                            }                                                    
                        });                        

                        $('#show_upc_column_button').click(function() {                        
                            var show_upc_column = $('#show_upc_column ').attr('value');
                            
                            if(show_upc_column == '1') {
                                $('#show_upc_column ').attr('value','0');
                                $('.upc-column').fadeOut();
                            }                        
                            else {
                                $('#show_upc_column ').attr('value','1');
                                $('.upc-column').fadeIn();
                            }                                                    
                        });                        
                                                
                    });

                
            
function filter() {
	url = 'index.php?route=catalog/product&token=<?php echo $token; ?>';
	

                var show_category_column = $('#show_category_column').attr('value');
                if(show_category_column) {
                    url += '&show_category_column=' + encodeURIComponent(show_category_column);
                }

                var show_manufacturer_column = $('#show_manufacturer_column').attr('value');
                if(show_manufacturer_column) {
                    url += '&show_manufacturer_column=' + encodeURIComponent(show_manufacturer_column);
                }

                                
                var filter_category_id = $('select[name=\'filter_category_id\']').attr('value');
                if (filter_category_id) {
                    url += '&filter_category_id=' + encodeURIComponent(filter_category_id);
                }
                

                var filter_manufacturer = $('select[name=\'filter_manufacturer\']').attr('value');
                if (filter_manufacturer) {
                    url += '&filter_manufacturer=' + encodeURIComponent(filter_manufacturer);
                }
               
            
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_model = $('input[name=\'filter_model\']').attr('value');

              var filter_sku = $('input[name=\'filter_sku\']').attr('value');
	
	if (filter_sku) {
		url += '&filter_sku=' + encodeURIComponent(filter_sku);
	}				
		
	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
	
	var filter_price = $('input[name=\'filter_price\']').attr('value');
	
	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}
	
	var filter_quantity = $('input[name=\'filter_quantity\']').attr('value');
	
	if (filter_quantity) {
		url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript">
$(document).ready(function(){ 	
	  function slideout(){
  setTimeout(function(){
  $("#response").slideUp("slow", function () {
      });
    
}, 2000);}
	
    $("#response").hide();
	$(function() {
	$("#list tbody").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			
			var order = $(this).sortable("serialize") + '&update=update'; 
			$.post("index.php?route=catalog/product/updateOrder&token=<?php echo $token; ?>", order, function(theResponse){
				$("#response").html(theResponse);
				$("#response").slideDown('slow');
				slideout();
			});
		}								  
		});
	});

});	
</script>
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript">
$(document).ready(function(){ 	
	  function slideout(){
  setTimeout(function(){
  $("#response").slideUp("slow", function () {
      });
    
}, 2000);}
	
    $("#response").hide();
	$(function() {
	$("#list tbody").sortable({ opacity: 0.8, cursor: 'move', update: function() {
			
			var order = $(this).sortable("serialize") + '&update=update'; 
			$.post("index.php?route=catalog/product/updateOrder&token=<?php echo $token; ?>", order, function(theResponse){
				$("#response").html(theResponse);
				$("#response").slideDown('slow');
				slideout();
			});
		}								  
		});
	});

});	
</script>
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_name\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'filter_model\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.model,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_model\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

//--></script> 
<?php echo $footer; ?>