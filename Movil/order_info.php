<?php 

include('Datos/ConfigV2.php');

$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);

$order_id = $_GET['order_id'];

function getOrder($vConex, $order_id){

	$sql = "SELECT * FROM oc_order WHERE order_id = $order_id";

	$resultado = mysqli_query($vConex, $sql);	

	$orden = mysqli_fetch_row($resultado);

	return $orden;
}
$orden = getOrder($vConex,$order_id);
//var_dump($orden);

function getProductsOrder($vConex, $order_id){

	$sql = "SELECT * FROM oc_order_product WHERE order_id = $order_id";

	$resultado = mysqli_query($vConex, $sql);	

	while($products = mysqli_fetch_array($resultado)){
		$productos[] = $products;
	}

	return $productos;
}
$products = getProductsOrder($vConex, $order_id);
//var_dump($products);

function getVoucher($vConex, $order_id){

	$sql = "SELECT * FROM oc_order_voucher WHERE order_id = $order_id";

	$resultado = mysqli_query($vConex, $sql);

	while($voucherss = mysqli_fetch_array($resultado)){
		$vourcher[] = $voucherss;
	}
	return $vourcher;
}
$vouchers = getVoucher($vConex, $order_id);
//var_dump($vouchers);


function getOrderTotal($vConex, $order_id){
	$sql = "SELECT * FROM oc_order_total WHERE order_id = $order_id";
	
	$resultado = mysqli_query($vConex, $sql);

	while($totals = mysqli_fetch_array($resultado)){
		$totales[] = $totals;
	}

	return $totales;
}
$totals = getOrderTotal($vConex, $order_id);

$date = new DateTime($orden[56]);
$dateAdded = $date->format('Y-m-d');
$payment_method = $orden[27];
$shipping_method = $orden[41];
$payment_address = $orden[18];
$shipping_address = $orden[32];
$direccionPago = $orden[13];
$direccionEnvio = $orden[29];
$ciudadPago = $orden[20];
$ciudadEnvio = $orden[34];
$regionPago = $orden[24];
$regionEnvio = $orden[38];
$paisPago = $orden[22];
$paisEnvio = $orden[36];
$dcto = $orden[59];
?>

<html dir="ltr" lang="es">
<head>
<meta charset="UTF-8" />
<title>Información</title>
<base href="http://socimagestion.com/" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/styles.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<script type="text/javascript" src="catalog/view/javascript/ajaxsearch2.js"></script>
<script type="text/javascript" src="catalog/view/javascript/script.js"></script>

<div class="anchooc"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>  
  <img src="catalog/view/theme/default/image/logosocima.png"/>
  <table class="list">
    <thead>
      <tr>
        <td class="left" colspan="2"><?php echo 'Detalle del Pedido'; ?></td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left" style="width: 50%;"><?php if ($invoice_no) { ?>
          <b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
          <?php } ?>
          <b><?php echo 'Numero de Orden: '; ?></b> #<?php echo $order_id; ?><br />
          <b><?php echo 'Fecha a&ntilde;adida: '; ?></b> <?php echo $dateAdded; ?></td>
        <td class="left" style="width: 50%;"><?php if ($payment_method) { ?>
          <b><?php echo 'M&eacute;todo de pago: '; ?></b> <?php echo utf8_encode($payment_method); ?><br />
          <?php } ?>
          <?php if ($shipping_method) { ?>
          <b><?php echo 'Tipo de Envio: '; ?></b> <?php echo $shipping_method; ?>
          <?php } ?></td>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
        <td class="left"><b><?php echo 'Direci&oacute;n de facturaci&oacute;n: '; ?></b></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><b><?php echo 'Direci&oacute;n de env&iacute;o: '; ?></b></td>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="left"><?php echo $payment_address; ?><br/>
		<!--<?php echo utf8_encode($direccionPago); ?><br/>-->
		<?php echo utf8_encode($ciudadPago); ?><br/>
		<?php echo $regionPago; ?><br/>
		<?php echo $paisPago; ?></td>
        <?php if ($shipping_address) { ?>
        <td class="left"><?php echo $shipping_address; ?><br/>
		<!--<?php echo utf8_encode($direccionEnvio); ?><br/>-->
		<?php echo utf8_encode($ciudadEnvio); ?><br/>
		<?php echo $regionEnvio; ?><br/>
		<?php echo $paisEnvio; ?></td>
        <?php } ?>
      </tr>
    </tbody>
  </table>
  <table class="list">
    <thead>
      <tr>
      <td class="left"><?php echo "Codigo"; ?></td>
        <td class="left"><?php echo "Imagen"; ?></td>
        <td class="left"><?php echo 'Nombre'; ?></td>
        <td class="left"><?php echo 'Modelo'; ?></td>
        <td class="right"><?php echo 'Cantidad'; ?></td>
        <td class="right"><?php echo 'Precio'; ?></td>
        <td class="right"><?php echo 'Total'; ?></td>
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
      	 $vSqlImagen = "select image from oc_product where product_id =\"". $product['product_id']."\";";
	      $Resultado =  mysqli_query($vConex,$vSqlImagen);
	      $R = "";
	      while($vArreglo = mysqli_fetch_row($Resultado)){
	          $R = "http://socimagestion.com/image/$vArreglo[0]";
	      }
      	?>
      	<td class="image">     	
            <a href="<?php echo $product['href']; ?>"><img style ="width:90px; height:90px; margin-top: 10px; margin-bottom: 10px;"src="<?php echo $R; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"</a>
            </td>
        <td class="left"><?php echo utf8_encode($product['name']); ?></td>
        <td class="left"><?php echo utf8_encode($product['model']); ?></td>
        <td class="right"><?php echo $product['quantity']; ?></td>
        <td class="right"><?php echo '$'.number_format($product['price'],0,'','.'); ?></td>
        <td class="right"><?php echo '$'.number_format($product['total'],0,'','.'); ?></td>
      </tr>
      <?php } ?>
	  <?php if(isset($vouchers)){
		foreach ($vouchers as $voucher) { ?>
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
      <?php }
		}?>
    <tfoot width="960px">
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
			<td align="right" colspan="5" class="total"><?php echo "$ " . number_format($ValorIva2,0,',','.'); ?></td>
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
  </div>
</html>