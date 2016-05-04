<?php
//include('funciones_db_movilToMaster.php');
include('ConfigV2.php');

$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
/*$Datos = array();
$Noticias = array();*/
if (mysqli_connect_errno())
{
    $Extras['vConex'] = 0;
    //$Datos['Estado'][] = $Extras;
	//var_dump('incorrecto');
	//$Datos['valor'] = 'error';
	$Datos[]=array("valor"=>0);
}
else
{
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
	
    //Existe Conexion con la base de datos
    $Extras['vConex'] = 1;
	
	$sql2 = "SELECT COUNT(*) FROM oc_order WHERE order_id = " . $idOrden . " AND total = " . $total;
	//$sql = "SELECT COUNT(*) FROM oc_order_product WHERE order_id = 868210410 AND product_id = 140661";
	
	$resultado = mysqli_query($vConex, $sql);
	$fila = mysqli_fetch_row($resultado);
	
	if($fila[0] ==0){
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
		
		$sql = "INSERT INTO oc_order(order_id, invoice_no, invoice_prefix, store_id, store_name, store_url, customer_id, customer_group_id, firstname, lastname, email, telephone,
				fax, payment_firstname, payment_lastname,payment_address_1, payment_city, payment_country, payment_country_id, payment_zone, payment_zone_id, payment_method, payment_code,
				shipping_firstname, shipping_lastname, shipping_address_1, shipping_city,  shipping_country, shipping_country_id, shipping_zone, shipping_zone_id, shipping_method, shipping_code, comment, total, order_status_id, affiliate_id, commission, language_id, currency_id, currency_code, currency_value, ip, user_agent, accept_language, date_added, date_modified, salesrep_id )
				VALUES ('" . $idOrden . "', '0', 'INV-2013-00', '0', 'Socima', 'http://socimagestion.com/', '" . $idCliente . "', '" . $clente[4] . "', '" . $cliente[0] . "', '" . $cliente[1] . "', '" . $cliente[2] . "',
				'" . $cliente[3] . "', '0', '" . $direccionF . "', '" . $address[1] . "', '" . $address[2] . "', '" . $address[3] . "', (SELECT name FROM oc_country WHERE country_id = '" . $address[4] . "'), '" . $address[4] . "', (SELECT name FROM oc_zone WHERE zone_id = '" . $address[5] . "'), '" . $address[5] . "', '" . $tipoP . "', '" . $codigoPago . "', '" . $direccionE . "', '" . $address[1] . "',
				'" . $address[2] . "', '" . $address[3] . "', (SELECT name FROM oc_country WHERE country_id = '" . $address[4] . "'), '" . $address[4] . "', (SELECT name FROM oc_zone WHERE zone_id = '" . $address[5] . "'), '" . $address[5] . "', 'Retirar en Socima', 'pickup.pickup', '" . $comentario . "', '" . $total . "', '" . $estado . "', '0', '0.0000', '2', '2', 'CLP', '1.00000000', '181.160.211.128', 
				'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'es-CL,es;q=0.8,en-US;q=0.5,en;q=0.3', '" . $FFI . "', '" . $FFM . "', '0')";
		
		if(mysqli_query($vConex, $sql)) {
			mysqli_close($vConex);
			//$Datos['valor'] = 1;
			$Datos[]=array("valor"=>1);
		}else{
			mysqli_close($vConex);
			//$Datos['valor'] = 0;
			$Datos[]=array("valor"=>0);
		}
	}
	//var_dump($sql);
}
 echo json_encode($Datos);
	
?>