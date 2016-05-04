 <?php
	     include('basededatos.php');
	     $vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
?>
              
<div id="cart">
  <div class="heading">
    <h4><?php echo 'Su pedido'; ?></h4>
    <a><span id="cart-total"><?php echo $text_items; ?></span></a></div>
  <div class="content">
    <?php if ($products || $vouchers) { ?>
    <div class="mini-cart-info">
      <table>
        <?php foreach ($products as $product) { ?>
        <tr>
          <td class="image"><?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
            <?php } ?></td>
          <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
          <?php 
             
             
	     $vSqlCantidadRecomendada = "select meta_description from oc_product_description where product_id = \"".$product['key']."\" ";
	     $Resultado =  mysqli_query($vConex,$vSqlCantidadRecomendada);
	     $R = "";
	     while($vArreglo = mysqli_fetch_row($Resultado))
	      {
	         echo $R = "<br><span style=\"font-size:.7em\">$vArreglo[0] </span> ";
	      }
          ?>
            <div>
              <?php foreach ($product['option'] as $option) { ?>
              - <small><?php echo $option['name']; ?> <?php echo $option['value']; ?></small><br />
              <?php } ?>
              <?php if ($product['recurring']): ?>
             
              - <small><?php echo $text_payment_profile ?> <?php echo $product['profile']; ?></small><br />
              <?php endif; ?>
            </div></td>
          <td class="quantity">x&nbsp;<?php echo $product['quantity']; ?></td>
          
          <td class="total"><?php echo $product['total']; ?></td>
          <td class="remove"><img src="catalog/view/theme/default/image/remove-small.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $product['key']; ?>' : $('#cart').load('index.php?route=module/cart&remove=<?php echo $product['key']; ?>' + ' #cart > *');" /></td>
        </tr>
        <?php } ?>
        <?php foreach ($vouchers as $voucher) { ?>
        <tr>
          <td class="image"></td>
          <td class="name"><?php echo $voucher['description']; ?></td>
          <td class="quantity">x&nbsp;1</td>
          <td class="total"><?php echo $voucher['amount']; ?></td>
          <td class="remove"><img src="catalog/view/theme/default/image/remove-small.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" onclick="(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=<?php echo $voucher['key']; ?>' : $('#cart').load('index.php?route=module/cart&remove=<?php echo $voucher['key']; ?>' + ' #cart > *');" /></td>
        </tr>
        <?php } ?>
      </table>
    </div>
    <div class="mini-cart-total">
      <table>
         <?php $C = 0;foreach ($totals as $total) {

		 if($C >0) { ?>	
      <?php
      } else { ?>
      <tr>
        <td class="right"><b><?php echo "Valor sin IVA"; ?>:</b></td>
        <td class="right">
        <?php
        
         $ValorIva1 = str_replace("$","",$total['text']);
         $ValorIva2 = str_replace(".","",$ValorIva1);
         $ValorIva3 =  (int)$ValorIva2;
		 ?>
		 
		 <?php 
         $ValorFinal = ($ValorIva3 / 100) * 19;
         $ValorFinal = (string)ceil(($ValorIva3 - $ValorFinal));
         $Largo = strLen($ValorFinal);
         $ValorFinal2 = "$";
         $C2 = 0;
         for($i = 0; $i < $Largo;$i++){ 
         
          if($Largo == 4 && $C2 == 1 ){
          
            $ValorFinal2 .=".".$ValorFinal[$i]; 
          }elseif($Largo == 5 && $C2 == 2 ){
            $ValorFinal2 .=".".$ValorFinal[$i]; 
          } else {
           $ValorFinal2.= $ValorFinal[$i];
          }
           $C2++;
         }
         echo  $ValorFinal2;
          ?></td>
           </tr>
      <?php 
      $C++;
      }
      }  
       ?>
<tr>
	<td class="right"><b><?php echo "IVA 19%"; ?>:</b></td>
	<td class="right"><?php echo "$" . number_format(round(str_replace(".","",$ValorIva1) * 0.19),0,',','.'); ?></td>	
</tr>
<tr>
	<td class="right"><b><?php echo $total['title']; ?>:</b></td>
	<!--<td class="right"><?php echo $total['text']; ?></td>-->
	<td class="right"><?php echo '$' . $ValorIva1; ?></td>
</tr>

        <tr>
 <td class="right"><b><?php echo "Credito Disponible"; ?>:</b></td>
 <?php
       $vSqlCredito= "select CreditoMaximo AS Credito from oc_customer where customer_id = \"".$_SESSION['Cienteid'] ."\" ";
	     $ResultadoCredito =  mysqli_query($vConex,$vSqlCredito);
	     $Credito = "";
	     while($vArreglo = mysqli_fetch_row($ResultadoCredito ))
	      {
	         if($vArreglo[0]==0)
	         {
	        	 $Credito = "Sin Credito";
	        	 echo "<td class=\"right\">".$Credito."</td></tr>";
	     	 }
	     	 else
	     	 {
	     	 	$Credito = $vArreglo[0];
	     	 	echo "<td class=\"right\">$".number_format($Credito,0, ',', '.')."</td></tr>";
	     	 }
	      }
      ?>
       
      </table>
    </div>
    <div class="checkout"><a href="<?php echo $cart; ?>">Carro de compra</a> | <a href="<?php echo $checkout; ?>"><?php echo 'Terminar Venta';   ?></a></div>
    <?php } else { ?>
    <div class="empty"><?php echo $text_empty; ?></div>
    <?php } ?>
  </div>
</div>