<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/invoice.css" />
</head>
<body>
<?php foreach ($orders as $order) { ?>
<div style="page-break-after: always;">
  <h1><?php echo $text_invoice; ?></h1>
  <table class="store">
    <tr>
      <td><?php echo $order['store_name']; ?><br />
        <?php echo $order['store_address']; ?><br />
        <?php echo $text_telephone; ?> <?php echo $order['store_telephone']; ?><br />
        <?php if ($order['store_fax']) { ?>
        <?php echo $text_fax; ?> <?php echo $order['store_fax']; ?><br />
        <?php } ?>
        <?php echo $order['store_email']; ?><br />
        <?php echo $order['store_url']; ?></td>
      <td align="right" valign="top"><table>
          <tr>
            <td><b><?php echo $text_date_added; ?></b></td>
            <td><?php echo $order['date_added']; ?></td>
          </tr>
          <?php if ($order['invoice_no']) { ?>
          <tr>
            <td><b><?php echo $text_invoice_no; ?></b></td>
            <td><?php echo $order['invoice_no']; ?></td>
          </tr>
          <?php } ?>
          <tr>
            <td><b><?php echo $text_order_id; ?></b></td>
            <td><?php echo $order['order_id']; ?></td>
          </tr>
          <tr>
            <td><b><?php echo $text_payment_method; ?></b></td>
            <td><?php echo $order['payment_method']; ?></td>
          </tr>
          <?php if ($order['shipping_method']) { ?>
          <tr>
            <td><b><?php echo $text_shipping_method; ?></b></td>
            <td><?php echo $order['shipping_method']; ?></td>
          </tr>
          <?php } ?>
        </table></td>
    </tr>
  </table>
  <table class="address">
    <tr class="heading">
      <td width="50%"><b><?php echo $text_to; ?></b></td>
      <td width="50%"><b><?php echo $text_ship_to; ?></b></td>
    </tr>
    <tr>
      <td><?php echo $order['payment_address']; ?><br/>
        <?php echo $order['email']; ?><br/>
        <?php echo $order['telephone']; ?>
        <?php if ($order['payment_company_id']) { ?>
        <br/>
        <br/>
        <?php echo $text_company_id; ?> <?php echo $order['payment_company_id']; ?>
        <?php } ?>
        <?php if ($order['payment_tax_id']) { ?>
        <br/>
        <?php echo $text_tax_id; ?> <?php echo $order['payment_tax_id']; ?>
        <?php } ?></td>
      <td><?php echo $order['shipping_address']; ?></td>
    </tr>
  </table>
  <table class="product">
    <tr class="heading">
	  <td><b><?php echo 'Código'; ?></b></td>
      <td><b><?php echo $column_product; ?></b></td>
      <td><b><?php echo $column_model; ?></b></td>
      <td align="right"><b><?php echo $column_quantity; ?></b></td>
      <td align="right"><b><?php echo $column_price; ?></b></td>
      <td align="right"><b><?php echo $column_total; ?></b></td>
    </tr>
    <?php foreach ($order['product'] as $product) { ?>
    <tr>
	  <td><?php echo $product['codigo']; ?>
      <td><?php echo $product['name']; ?>
        <?php foreach ($product['option'] as $option) { ?>
        <br />
        &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
        <?php } ?></td>
      <td><?php echo $product['model']; ?></td>
      <td align="right"><?php echo $product['quantity']; ?></td>
      <td align="right"><?php echo $product['price']; ?></td>
      <td align="right"><?php echo $product['total']; ?></td>
    </tr>
    <?php } ?>
    <?php foreach ($order['voucher'] as $voucher) { ?>
    <tr>
      <td align="left"><?php echo $voucher['description']; ?></td>
      <td align="left"></td>
      <td align="right">1</td>
      <td align="right"><?php echo $voucher['amount']; ?></td>
      <td align="right"><?php echo $voucher['amount']; ?></td>
    </tr>
    <?php } ?>
	<?php 
		if($order['dcto'] != 0){
			if(strlen($order['dcto']) == 1){
				$ValorIva2 = str_replace("$","",$order['total'][0]['text']);
				$ValorIva1 = str_replace(".","",$ValorIva2);
				$PDcto = '0.0'.$order['dcto'];
				$valorDelDcto = $ValorIva1 * $PDcto;
				$totalConDcto = $ValorIva1 - $valorDelDcto;
				$iva = round(str_replace(",","",number_format(round($totalConDcto))) * 0.19); 
				$ValorSinIva = (str_replace(",","",number_format(round($totalConDcto)))) - (str_replace('.','',$iva)); 
			}else{
				$ValorIva2 = str_replace("$","",$order['total'][0]['text']);
				$ValorIva1 = str_replace(".","",$ValorIva2);
				$PDcto = '0.'.$order['dcto'];
				$valorDelDcto = $ValorIva1 * $PDcto;
				$totalConDcto = $ValorIva1 - $valorDelDcto;
				$iva = round(str_replace(",","",number_format(round($totalConDcto))) * 0.19); 
				$ValorSinIva = (str_replace(",","",number_format(round($totalConDcto)))) - (str_replace('.','',$iva)); 			
				var_dump($ValorIva1);
				var_dump($PDcto);
				var_dump($valorDelDcto);
			}
		}else{
			$ValorIva1 = str_replace("$","",$order['total'][0]['text']);
			$iva = number_format(round(str_replace(".","",$ValorIva1) * 0.19),0,',','.'); 
			$ValorSinIva = (str_replace('.', '',$ValorIva1)) - (str_replace('.','',$iva)); 
		}	  
	    ?>
	 <?php if($order['dcto'] != 0) { ?>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "% Dcto Aplicado: "; ?></b></td>
			<td align="right" colspan="5" class="total"><?php echo "% " . $order['dcto'];?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "Total sin Dcto: "; ?></b></td>
			<td align="right" colspan="5" class="total"><?php echo "$ " . number_format($ValorIva2,0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "Valor del Descuento: "; ?></b></td>
			<td align="right" colspan="5" class="total"><?php echo "$ " . number_format($valorDelDcto,0,',','.'); ?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $order['total'][0]['title']); ?></b></td>
			<td align="right" class="total"><?php if($order['total'][0]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo $order['total'][0]['text'];} ?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "IVA 19%"; ?>:</b></td>
			<td align="right" colspan="5" class="total"><?php echo "$ ".number_format($iva,0,',','.');?></td>	
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $order['total'][2]['title']); ?></b></td>
			<td align="right" colspan="5" class="total"><?php if($order['total'][2]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo "$ " . number_format($totalConDcto ,0,',','.');} ?></td>
		  </tr>
	  <?php }else{ ?>
		<tr>
			<td align="right" colspan="5" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $order['total'][0]['title']); ?></b></td>
			<td align="right" class="total"><?php if($order['total'][0]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo $order['total'][0]['text'];} ?></td>
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo "IVA 19%"; ?>:</b></td>
			<td align="right" class="total"><?php echo "$ ".$iva;?></td>	
		  </tr>
		  <tr>
			<td align="right" colspan="5" class="price"><b><?php echo str_replace("Sub-Total", "Valor sin IVA", $order['total'][2]['title']); ?></b></td>
			<td align="right" class="total"><?php if($order['total'][2]['code'] == 'sub_total'){ echo "$ " . number_format($ValorSinIva,0,',','.'); } else { echo "$ " . $ValorIva1;} ?></td>
		  </tr>
  <?php } ?>
  </table>
  <?php if ($order['comment']) { ?>
  <table class="comment">
    <tr class="heading">
      <td><b><?php echo $column_comment; ?></b></td>
    </tr>
    <tr>
      <td><?php echo $order['comment']; ?></td>
    </tr>
  </table>
  <?php } ?>
</div>
<?php } ?>
</body>
</html>