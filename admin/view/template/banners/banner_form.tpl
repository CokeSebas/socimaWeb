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
    <div class="heading">
      <h1><img src="view/image/user.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_banner1; ?></td>
			<td><input type="file" name="imagen1" id="imagen1" size="20" />
				<!--<input name="enviar" type="submit" value="Upload File" />-->
				<input name="action" type="hidden" value="upload" />
			<?php if ($_SESSION['banner1']) { ?>
				<span class="error"><?php echo 'Debe subir una imagen'; ?></span>
            <?php } ?></td>
            <td><span class="required">*</span><input type="text" name="banner1" value="Banner1" /><input type="hidden" name="idBanner1" value="1"><input type="hidden" name="valueBanner1" value="">
              <?php if ($_SESSION['banner1']) { ?>
				<span class="error"><?php echo 'Debe seleccionar una Categoria'; ?></span>
              <?php } ?></td>
			  <!--<td><input type="button" onclick="guardar(this.id)" id="guardar1" value="<?php echo $button_subir; ?>"></td>-->
			  <td><input type="button" onclick="$('#form').submit();" id="guardar1" value="<?php echo $button_subir; ?>"></td>
			  <td><input type="button" value="<?php echo $button_limpiar; ?>" id="limpiar1" onclick="limpiar(this.id)" ></td>
          </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_banner2; ?></td>
            <td><input type="file" name="imagen2" id="imagen2" size="20" />
				<!--<input name="enviar" type="submit" value="Upload File" />-->
				<input name="action" type="hidden" value="upload" />
			<?php if ($_SESSION['banner2']) { ?>
				<span class="error"><?php echo 'Debe subir una imagen'; ?></span>
            <?php } ?></td>
			<td><span class="required">*</span><input type="text" name="banner2" value="Producto1" /><input type="hidden" name="idBanner2" value="2"><input type="hidden" name="valueBanner2" value="">
              <?php if ($_SESSION['banner2']) { ?>
				<span class="error"><?php echo 'Debe seleccionar un Producto'; ?></span>
              <?php } ?></td>
			  
			  <!--<td><input type="button" onclick="guardar(this.id)" id="guardar2" value="<?php echo $button_subir; ?>"></td>-->
			  <td><input type="button" onclick="$('#form').submit();" id="guardar2" value="<?php echo $button_subir; ?>"></td>
			  <td><input type="button" value="<?php echo $button_limpiar; ?>" id="limpiar2" onclick="limpiar(this.id)"></td>
			  </tr>
          <tr>
            <td><span class="required">*</span> <?php echo $entry_banner3; ?></td>
			<td><input type="file" name="imagen3" id="imagen3" size="20" />
				<input name="action" type="hidden" value="upload" />
			<?php if ($_SESSION['banner3']) { ?>
				<span class="error"><?php echo 'Debe subir una imagen'; ?></span>
            <?php } ?></td>				
            <td><span class="required">*</span><input type="text" name="banner3" id="banner3" value="Producto2" /><input type="hidden" name="idBanner3" value="3"><input type="hidden" id="valueBanner3" name="valueBanner3" value="">
              <?php if ($_SESSION['banner3']) { ?>
				<span class="error"><?php echo 'Debe seleccionar un Producto'; ?></span>
              <?php } ?></td>
			  <!--<td><input type="button" onclick="guardar(this.id)" id="guardar3" value="<?php echo $button_subir; ?>"></td>-->
			  <td><input type="button" onclick="$('#form').submit();" id="guardar3" value="<?php echo $button_subir; ?>"></td>
			  <td><input type="button" value="<?php echo $button_limpiar; ?>" id="limpiar3" onclick="limpiar(this.id)"></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?> 

<script>
$('input[name=\'banner2\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			//url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			url: 'index.php?route=banners/banners/autocompleteProduct&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.model+' '+item.product_id,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'banner2\']').val(ui.item.label);
		$('input[name=\'valueBanner2\']').val(ui.item.value);
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'banner3\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			//url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			url: 'index.php?route=banners/banners/autocompleteProduct&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.model+' '+item.product_id,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'banner3\']').val(ui.item.label);
		$('input[name=\'valueBanner3\']').val(ui.item.value);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'banner1\']').autocomplete({
	delay: 500,
	source: function(request, response) {		
		$.ajax({
			url: 'index.php?route=banners/banners/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					'category_id':  0,
					'name':  '--Ninguno--'
				});
				
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.category_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'banner1\']').val(ui.item.label);
		$('input[name=\'valueBanner1\']').val(ui.item.value);
		$('input[name=\'parent_id\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

function limpiar(idBoton){
	var boton = idBoton;
	//alert(boton);
	$.ajax({
		url: 'index.php?route=banners/banners/limpiar&token=<?php echo $token; ?>&idBanner=' +  boton,
		dataType: 'json',
		success: function(json) {
			if(json != 0){
				alert('Banner a sido eliminado');
			}
		}
	});	
}

/*function guardar(idBotton){
	var botton = idBotton;
	//alert(botton);
	var valor = document.getElementById("valueBanner3");
	//alert(valor.value);
	//var imagen = '<?php echo $_FILES['imagen3']['tmp_name']; ?>';
	//var imagen = document.getElementById("imagen3");
	var imagen = document.getElementById("imagen3");
	alert(imagen.value);
	
	$.ajax({
		url: 'index.php?route=banners/banners/guardar&token=<?php echo $token; ?>&imagen='+imagen+'&name='+valor.value,
		dataType: 'json',
		success: function(json) {
			if(json != 0){
				//alert(json);
				alert('A actualizado el banner');
			}
		}
	});
}*/
</script>