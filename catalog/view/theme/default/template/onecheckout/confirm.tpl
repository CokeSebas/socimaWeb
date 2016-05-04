 <?php
	     include('basededatos.php');
	     $vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
?>
<?php if ($success) { ?>
<div class="success"><?php echo $success; ?></div>
<?php } ?>
<div class="onecheckout-product">
  <table>
    <thead>
      <tr>
        <td class="name"><?php echo $column_name; ?></td>
        <td class="quantity"><?php echo $column_quantity; ?></td>
        <td class="price"><?php echo $column_price; ?></td>
        <td class="total"><?php echo $column_total; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
        <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?></td>
        <td class="quantity"><?php echo $product['quantity']; ?></td>
        <td class="price"><?php echo $product['price']; ?></td>
        <td class="total"><?php echo $product['total']; ?></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
        <td class="name"><?php echo $voucher['description']; ?></td>
        <td class="quantity">1</td>
        <td class="price"><?php echo $voucher['amount']; ?></td>
        <td class="total"><?php echo $voucher['amount']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
    <tfoot>
		<?php $ValorIva1 = str_replace("$","",$totals[0]['text']);
			  $iva = number_format(round(str_replace(".","",$ValorIva1) * 0.19),0,',','.'); 
			  $ValorSinIva = (str_replace('.', '',$ValorIva1)) - (str_replace('.','',$iva)); 
	    ?>
	  <tr>
        <td colspan="2" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $totals[0]['title']); ?></b></td>
        <td colspan="2" class="total"><label id="VsIva"><?php if($totals[0]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo $totals[0]['text'];} ?></label></td>
      </tr>
	  <tr>
		<td colspan="2" class="price"><b><?php echo "IVA 19%"; ?>:</b></td>
		<td colspan="2" class="total"><label id="iva"><?php echo "$".$iva;?></label></td>	
      </tr>
	  <tr>
        <td colspan="2" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $totals[2]['title']); ?></b></td>
        <td colspan="2" class="total"><label id="total"><?php if($totals[2]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo "$ " . $ValorIva1;} ?></label></td>
      </tr>
	  <tr>
		<td colspan="2" class="price"><img src="catalog/view/theme/default/image/update.png"><b><?php echo " Descuento : "; ?></b></td>
		<td colspan="2" class="total"><input type="text" name="dcto" id="dcto" value="0" maxlength="2" size="4" onkeypress="return justNumbers(event);" onchange="dcto()">
	  </tr>
	  <tr>
		<td colspan="2" class="price"><b><?php echo 'Credito Disponible'; ?></b></td>
		<?php
       $vSqlCredito= "select CreditoMaximo AS Credito from oc_customer where customer_id = \"".$_SESSION['Cienteid'] ."\" ";
	     $ResultadoCredito =  mysqli_query($vConex,$vSqlCredito);
	     $Credito = "";
	     while($vArreglo = mysqli_fetch_row($ResultadoCredito ))
	      {
	         if($vArreglo[0]==0)
	         {
	        	 $Credito = "Sin Credito";
	        	 echo "<td colspan=\"2\" class=\"price\">".$Credito."</td></tr>";
	     	 }
	     	 else
	     	 {
	     	 	$Credito = $vArreglo[0];
	     	 	echo "<td colspan=\"2\" class=\"price\"> $ ".number_format($Credito,0, ',', '.')."</td></tr>";
	     	 }
	      }
      ?>
    </tfoot>
  </table>
</div>
<?php echo $cartmodule; ?>
<?php if ($text_agree) { ?>
<div class="buttons" style="width: 120px; float: right;">  
    <?php 
    if ($agree) 
    { 
    ?>
    <input type="checkbox" name="agree" value="1" checked="checked" style="display: none" />
    <?php 
    } 
    else { 
    ?>
    <input type="checkbox" name="agree" value="1" checked="checked" style="display: none" />
    <?php 
    } ?>
 <div class="right divclear">
	<a id="button-confirmorder" class="button"><span><?php echo $button_confirm; ?></span></a>	
  </div>
</div>
<?php } else { ?>

<div class="buttons"  style="width: 100px; float: left;">
  <div class="left"><a id="button-cancelar" class="button3" onclick="cancelar()"><span>CANCELAR VENTA</span></a></div>
</div>
<div class="buttons"  style="width: 100px; float: left;">
  <div class="left"><a id="button-penorder" class="button2"><span>VENTA PENDIENTE</span></a></div>
</div>
<div class="buttons"  style="width: 100px; float: right;">
  <div class="right"><a id="button-confirmorder" class="button"><span>CONFIRMAR VENTA</span></a></div>
</div>
<input type="hidden" value="" id="statusOrder">
<?php } ?>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 640,
	height: 480
});

function cancelar(){
	$.ajax({
		url: 'index.php?route=onecheckout/confirm/cancelarOrden',
		dataType: 'json',
		success: function(json) {
			alert('La orden ha sido Cancelada');
			location.reload();
		},
		error: function(xhr, ajaxOptions, thrownError) {			
			$('#button-confirmorder').attr('disabled', false);
			$('.wait').remove();
			alert(thrownError);
		}
	});
}

function justNumbers(e){
   var keynum = window.event ? window.event.keyCode : e.which;
   if ((keynum == 8) || (keynum == 46))
        return true;
    return /\d/.test(String.fromCharCode(keynum));
}

function dcto(){	
var descuento = $("#dcto").val();
var VsIva2 = document.all("VsIva").innerHTML;
var VsIva1 = VsIva2.replace("$","");
var VsIva = VsIva1.replace(".","");
var iva2 = document.all("iva").innerHTML;
var iva1 = iva2.replace("$","");
var iva = iva1.replace(".","");
var total2 = document.all("total").innerHTML;
var total1 = total2.replace("$","");
var total = total1.replace(".","");
//alert(total);
//alert(descuento);
	if(descuento == 0){
		document.all('VsIva').innerHTML = '<?php echo "$ " . number_format($ValorSinIva,0,',','.'); ?>';
		document.all('iva').innerHTML = '<?php echo "$ " . $iva ?>';
		document.all('total').innerHTML =  '<?php echo "$ " . $ValorIva1; ?>';
	}else if(descuento.length == '1'){
		var dscto = '0.0'+descuento;
		var Vdcto = total * dscto;
		var nTotal = total - Vdcto;
		var nIva = nTotal * 0.19;
		var nVsIva = nTotal - nIva;
		document.all('VsIva').innerHTML = "$ " + addCommas(Math.round(nVsIva));
		document.all('iva').innerHTML = "$ " + addCommas(Math.round(nIva));
		document.all('total').innerHTML =  "$ " + addCommas(Math.round(nTotal));
	}else if(descuento.length == 2){
		var dscto = '0.'+descuento;
		var Vdcto = total * dscto;
		var nTotal = total - Vdcto;
		var nIva = nTotal * 0.19;
		var nVsIva = nTotal - nIva;
		document.all('VsIva').innerHTML = "$ " + addCommas(Math.round(nVsIva));
		document.all('iva').innerHTML = "$ " + addCommas(Math.round(nIva));
		document.all('total').innerHTML =  "$ " + addCommas(Math.round(nTotal));	
	}else{
		document.all('VsIva').innerHTML = '<?php echo "$ " . number_format($ValorSinIva,0,',','.'); ?>';
		document.all('iva').innerHTML = '<?php echo "$ " . $iva ?>';
		document.all('total').innerHTML =  '<?php echo "$ " . $ValorIva1; ?>';
	}
}

function addCommas(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + '.' + '$2');
	}
	return x1 + x2;
}

//--></script>