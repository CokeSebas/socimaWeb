<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <table class="list">
    <thead>
      <tr>
        <td class="left" colspan="2"><?php echo $text_order_detail; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left" style="width: 50%;"><?php if ($invoice_no) { ?>
          <b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
          <?php } ?>
          <b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
          <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?></td>
        <td class="left" style="width: 50%;"><?php if ($payment_method) { ?>
          <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
          <?php } ?>
          </td>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><?php echo $text_shipping_address; ?></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $payment_address; ?></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><?php echo $shipping_address; ?></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
      <td class="left"><?php echo "Codigo"; ?></td>
        <td class="left"><?php echo "Imagen"; ?></td>
        <td class="left"><?php echo $column_name; ?></td>
        <td class="left"><?php echo $column_model; ?></td>
        <td class="right"><?php echo $column_quantity; ?></td>
        <td class="right"><?php echo $column_price; ?></td>
        <td class="right"><?php echo $column_total; ?></td>
        <?php if ($products) { ?>
        <td style="width: 1px;"></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $product) { ?>
      <tr>
      <td class="left"><?php echo $product['product_id']; ?></td>
            	
      	
      	<?php 
      	include('basededatos.php');
      	 $vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
      	 
      	 $vSqlImagen = "select image from oc_product where product_id =\"". $product['product_id']."\";";
	      $Resultado =  mysqli_query($vConex,$vSqlImagen);
	      $R = "";
	      while($vArreglo = mysqli_fetch_row($Resultado))
	      {
	          $R = "http://socimagestion.com/image/$vArreglo[0]";
	         
	      }
      	
      	?>

      	<td class="image">     	
            <a href="<?php echo $product['href']; ?>"><img style ="width:90px; height:90px; margin-top: 10px; margin-bottom: 10px;"src="<?php echo $R; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"</a>
            </td>
        <td class="left"><?php echo $product['name']; ?>
          <?php foreach ($product['option'] as $option) { ?>
          <br />
          &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
          <?php } ?></td>
        
        <td class="left"><?php echo $product['model']; ?></td>
        <td class="right"><?php echo $product['quantity']; ?></td>
        <td class="right"><?php echo $product['price']; ?></td>
        <td class="right"><?php echo $product['total']; ?></td>
        <td class="right"><a href="<?php echo $product['return']; ?>"><img src="catalog/view/theme/default/image/return.png" alt="<?php echo $button_return; ?>" title="<?php echo $button_return; ?>" /></a></td>
      </tr>
      <?php } ?>
      <?php foreach ($vouchers as $voucher) { ?>
      <tr>
      </tbody>
        <td class="left"><?php echo $voucher['description']; ?></td>
        <td class="left"></td>
        <td class="right">1</td>
        <td class="right"><?php echo $voucher['amount']; ?></td>
        <td class="right"><?php echo $voucher['amount']; ?></td>
        <?php if ($products) { ?>
        <td></td>
        <?php } ?>
      </tr>
      <?php } ?>
    <tfoot>
      <?php 
			if($dcto != 0){
				if(strlen($dcto) == 1){
					$ValorIva2 = str_replace("$","",$totals[0]['text']);
					$ValorIva1 = str_replace(".","",$ValorIva2);
					$PDcto = '0.0'.$dcto;
					$valorDelDcto = $ValorIva1 * $PDcto;				
					$totalConDcto = $ValorIva1 - $valorDelDcto;
					$iva = round(str_replace(",","",number_format(round($totalConDcto))) * 0.19); 
					$ValorSinIva = (str_replace(",","",number_format(round($totalConDcto)))) - (str_replace('.','',$iva)); 
				}else{
					$ValorIva2 = str_replace("$","",$totals[0]['text']);
					$ValorIva1 = str_replace(".","",$ValorIva2);
					$PDcto = '0.'.$dcto;
					$valorDelDcto = $ValorIva1 * $PDcto;				
					$totalConDcto = $ValorIva1 - $valorDelDcto;
					$iva = round(str_replace(",","",number_format(round($totalConDcto))) * 0.19); 
					$ValorSinIva = (str_replace(",","",number_format(round($totalConDcto)))) - (str_replace('.','',$iva)); 
				}
			} else {
				$ValorIva1 = str_replace("$","",$totals[0]['text']);
				$iva = number_format(round(str_replace(".","",$ValorIva1) * 0.19),0,',','.'); 
				$ValorSinIva = (str_replace('.', '',$ValorIva1)) - (str_replace('.','',$iva)); 
			}
	    ?>
	  <?php if($dcto != 0){ ?>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "% Dcto Aplicado: "; ?></b></td>
			<td align="right" colspan="5" class="total"><?php echo "% " . $dcto; ?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "Total sin Dcto: "; ?></b></td>
			<td align="right" colspan="5" class="total"><?php echo "$ " . $ValorIva2; ?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "Valor del Descuento: "; ?></b></td>
			<td align="right" colspan="5" class="total"><?php echo "$ " . number_format($valorDelDcto,0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $totals[0]['title']); ?></b></td>
			<td align="right" colspan="5" class="total"><?php if($totals[0]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo $totals[0]['text'];} ?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "IVA 19%"; ?>:</b></td>
			<td align="right" colspan="5" class="total"><?php echo "$ ".number_format($iva,0,',','.');?></td>	
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $totals[2]['title']); ?></b></td>
			<td align="right" colspan="5" class="total"><?php if($totals[2]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo "$ " . number_format($totalConDcto ,0,',','.');} ?></td>
		  </tr>
	  <?php } else { ?>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $totals[0]['title']); ?></b></td>
			<td align="right" colspan="5" class="total"><?php if($totals[0]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo $totals[0]['text'];} ?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "IVA 19%"; ?>:</b></td>
			<td align="right" colspan="5" class="total"><?php echo "$ ".$iva;?></td>	
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $totals[2]['title']); ?></b></td>
			<td align="right" colspan="5" class="total"><?php if($totals[2]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo "$ " . $ValorIva1;} ?></td>
		  </tr>
	  <?php } ?>
    </tfoot>
  </table>
  <?php if ($comment) { ?>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $text_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $comment; ?></td>
      </tr>
    </tbody>
  </table>
  <?php } ?>
  <?php if ($histories) { ?>
  <h2><?php echo $text_history; ?></h2>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><?php echo $column_date_added; ?></td>
        <td class="left"><?php echo $column_status; ?></td>
        <td class="left"><?php echo $column_comment; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($histories as $history) { ?>
      <tr>
        <td class="left"><?php echo $history['date_added']; ?></td>
        <td class="left"><?php echo $history['status']; ?></td>
        <td class="left"><?php echo $history['comment']; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } ?>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?> 