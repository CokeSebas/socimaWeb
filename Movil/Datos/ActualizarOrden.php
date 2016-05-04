<?php
//include('funciones_db_movilToMaster.php');
include('ConfigV2.php');
include('AttachMailer.php');

$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
//var_dump($vConex);
/*$Datos = array();
$Noticias = array();*/

if (mysqli_connect_errno()){
    $Extras['vConex'] = 0;
    //$Datos['Estado'][] = $Extras;
	//var_dump('incorrecto');
	$Datos['valor'] = 'error';
}else{
	$idOrden = $_POST['idOrden'];
	$idCliente = $_POST['idCliente'];
	$direccionF = $_POST['direccionF'];
	$tipoP = $_POST['tipoP'];
	$total = $_POST['total'];
	//$estado = $POST['estado'];
	$estado = '5';
	$FFI = $_POST['FFI'];
	$FFM = $_POST['FFM'];
	$comentario = $_POST['comentario'];
	$idVendedor = $_POST['idVendedor'];
	$direccionE = $_POST['direccionE'];
	$dcto = $_POST['dcto'];
	
	/*//$idOrden = '2142735809';
	$idOrden = '000000000';
	$idCliente = '29';
	$direccionF = 'IRRAZABAL 3636- Ñuñoa- Region Metropolitana';
	$tipoP = 'Pago Habitual';
	$total = '5360';
	$estado = '5';
	$FFI = '2015-11-09';
	$FFM = '2015-11-09';
	$comentario = '';
	$idVendedor = '1';
	$direccionE = 'IRRAZABAL 3636- Ñuñoa- Region Metropolitana';
	$dcto = '5'*/
	
    //Existe Conexion con la base de datos
    $Extras['vConex'] = 1;
	
	$sql = "SELECT COUNT(*) FROM oc_order WHERE order_id = " . $idOrden . " AND total = " . $total;
	//$sql = "SELECT COUNT(*) FROM oc_order_product WHERE order_id = 868210410 AND product_id = 140661";
	//var_dump($sql);
	
	$resultado = mysqli_query($vConex, $sql);
	
	if($resultado != false){
		$fila = mysqli_fetch_row($resultado);
	}
	//if($fila[0] == 0){
	if($fila[0] != null){
		if($fila[0] == 0){
			
			$sqlGetCliente = "SELECT firstname,lastname, email, telephone,customer_group_id
							  FROM oc_customer 
							  WHERE customer_id = '" . $idCliente . "'";
			
			$resultCliente = mysqli_query($vConex, $sqlGetCliente);
			$cliente = mysqli_fetch_row($resultCliente);
			
			
			$sqlGetAddress = "SELECT firstname, lastname, address_1, city, country_id, zone_id
							FROM oc_address 
							WHERE customer_id = '" . $idCliente . "'";
							
			$resultAddress = mysqli_query($vConex, $sqlGetAddress);
			$address = mysqli_fetch_row($resultAddress);
			
			if($tipoP == 'Pago Habitual'){
				$codigoPago = 'bank_transfer';
			}else if($tipoP == 'Transferencia'){
				$codigoPago = 'bank_trasnfer';
			}else if ($tipoP == 'Efectivo'){
				$codigoPago = 'cheque';
			}
			
			$sqlGetVendedor = "SELECT `name`, `username` FROM `oc_salesrep` WHERE `salesrep_id` = '" . $idVendedor . "'";
							
			$sqlresultVendedor = mysqli_query($vConex, $sqlGetVendedor);
			$vendedor = mysqli_fetch_row($sqlresultVendedor);
								
			$sql2 = "INSERT INTO oc_order(order_id, invoice_no, invoice_prefix, store_id, store_name, store_url, customer_id, customer_group_id, firstname, lastname, email, telephone,
					fax, payment_firstname, payment_lastname,payment_address_1, payment_city, payment_country, payment_country_id, payment_zone, payment_zone_id, payment_method, payment_code,
					shipping_firstname, shipping_lastname, shipping_address_1, shipping_city,  shipping_country, shipping_country_id, shipping_zone, shipping_zone_id, shipping_method, shipping_code, comment, total, order_status_id, affiliate_id, commission, language_id, currency_id, currency_code, currency_value, ip, user_agent, accept_language, date_added, date_modified, salesrep_id, dcto)
					VALUES ('" . $idOrden . "', '0', 'INV-2013-00', '0', 'Socima', 'http://socimagestion.com/', '" . $idCliente . "', '" . $cliente[4] . "', '" . $cliente[0] . "', '" . $cliente[1] . "', '" . $cliente[2] . "',
					'" . $cliente[3] . "', '0', '" . $direccionF . "', '" . $address[1] . "', '" . $address[2] . "', '" . $address[3] . "', (SELECT name FROM oc_country WHERE country_id = '" . $address[4] . "'), '" . $address[4] . "', (SELECT name FROM oc_zone WHERE zone_id = '" . $address[5] . "'), '" . $address[5] . "', '" . $tipoP . "', '" . $codigoPago . "', '" . $direccionE . "', '" . $address[1] . "',
					'" . $address[2] . "', '" . $address[3] . "', (SELECT name FROM oc_country WHERE country_id = '" . $address[4] . "'), '" . $address[4] . "', (SELECT name FROM oc_zone WHERE zone_id = '" . $address[5] . "'), '" . $address[5] . "', 'Retirar en Socima', 'pickup.pickup', '" . $comentario . "', '" . $total . "', '" . $estado . "', '0', '0.0000', '2', '2', 'CLP', '1.00000000', '181.160.211.128', 
					'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'es-CL,es;q=0.8,en-US;q=0.5,en;q=0.3', '" . $FFI . "', '" . $FFM . "', '" . $idVendedor . "', '" . $dcto . "')";
			
			$text = '$'.$total;
			
			$sql3 = "INSERT INTO `oc_order_total`(`order_id`, `code`, `title`, `text`, `value`, `sort_order`) 
					VALUES ($idOrden, 'sub_total', 'Sub-Total:','$text',$total,1)";
					
			$sql4 = "INSERT INTO `oc_order_total`(`order_id`, `code`, `title`, `text`, `value`, `sort_order`) 
					VALUES ($idOrden, 'shipping', 'Retirar en Socima:','$0',0,3)";
					
			$sql5 = "INSERT INTO `oc_order_total`(`order_id`, `code`, `title`, `text`, `value`, `sort_order`) 
					 VALUES ($idOrden, 'total', 'Total:','$text',$total,9)";
			
			
			$sqlGetLocalidad = "SELECT localidad FROM oc_salesrep WHERE salesrep_id = '" . $idVendedor . "'";
			$resultLocalidad = mysqli_query($vConex, $sqlGetLocalidad);
			$localidad = mysqli_fetch_row($resultLocalidad);		
			if($localidad[0] == 'STGO'){
				if(mysqli_query($vConex, $sql2)) {
					mysqli_query($vConex, $sql3);
					mysqli_query($vConex, $sql4);
					mysqli_query($vConex, $sql5);
					mysqli_close($vConex);
					$Datos['valor'] = 1;
					//$Correo = "odril.jtapia@gmail.com";
					$Correo = "rodrigoarenas9@gmail.com, odril.jtapia@gmail.com, santiago@socimagestion.com";
					$Titulo = "Nuevo Pedido Santiago del Vendedor " . $vendedor[0] . ' - ' .  $idOrden;
					$Mensaje = "<p>Estimados</p> Se ha procesado el siguiente pedido adjunto:  http://socimagestion.com/admin/view/template/sale/excel_orders2.php?orderid=".$idOrden;
					$Nombre = "Nuevo Pedido Santiago del Vendedor " . $vendedor[0] . ' - ' .  $idOrden;

					$mailer = new AttachMailer("sistema@socimagestion.com", "$Correo", "$Titulo", "<p>".$Mensaje."</p>  El correo se ha generado el  : ".date("d-m-Y"));
					$mailer->send() ? "Enviado": "Problema al enviar";
					
					//$correoCliente = $cliente[2];
					$correoCliente = "clientes@socimagestion.com";
					$tituloCliente = "Nueva orden Ingresada";
					$mensajeCliente = "Se a registrado el siguiente pedido : http://socimagestion.com/Movil/order_info.php?order_id=".$idOrden;
					$nombreCliente = "Nueva orden Ingresada";
					
					$mailerCliente = new AttachMailer("sistema@socimagestion.com", "$correoCliente", "$tituloCliente", "<p>".$mensajeCliente."<p> El correo se ha generado el : ".date("d-m-Y"));
					$mailerCliente->send() ? "Enviado" : "Problema al enviar";
				}else{
					mysqli_close($vConex);
					$Datos['valor'] = 0;
				}
			}else if($localidad[0] == 'REG'){
				if(mysqli_query($vConex, $sql2)) {
					mysqli_query($vConex, $sql3);
					mysqli_query($vConex, $sql4);
					mysqli_query($vConex, $sql5);
					mysqli_close($vConex);
					$Datos['valor'] = 1;
					//$Correo = "cokesebas@gmail.com";
					$Correo = "rodrigoarenas9@gmail.com, cokesebas@gmail.com, region@socimagestion.com";
					$Titulo = "Nuevo Pedido Region del Vendedor " . $vendedor[0] . ' - ' .  $idOrden;
					$Mensaje = "<p>Estimados</p> Se ha procesado el siguiente pedido adjunto:  http://socimagestion.com/admin/view/template/sale/excel_orders2.php?orderid=".$idOrden;
					$Nombre = "Nuevo Pedido Region del Vendedor " . $vendedor[0] . ' - ' .  $idOrden;
					$mailer = new AttachMailer("sistema@socimagestion.com", $Correo, $Titulo, "<p>".$Mensaje."</p>  El correo se ha generado el  : ".date("d-m-Y"));
					$mailer->send() ? "Enviado": "Problema al enviar";

					//$correoCliente = $cliente[2];
					$correoCliente = "clientes@socimagestion.com";
					$tituloCliente = "Nueva orden Ingresada";
					$mensajeCliente = "Se a registrado el siguiente pedido : http://socimagestion.com/Movil/order_info.php?order_id=".$idOrden;
					$nombreCliente = "Nueva orden Ingresada";
					
					$mailerCliente = new AttachMailer("sistema@socimagestion.com", "$correoCliente", "$tituloCliente", "<p>".$mensajeCliente."<p> El correo se ha generado el : ".date("d-m-Y"));
					$mailerCliente->send() ? "Enviado" : "Problema al enviar";
				}else{
					mysqli_close($vConex);
					$Datos['valor'] = 0;
				}
			}
		
		}else{
			$Datos['valor'] = 0;
		}
	}else{
		$Datos['valor'] = 0;
	}
	//var_dump($sql);
}
 echo json_encode($Datos);
	
?>