<?php

error_reporting(E_ALL);
set_time_limit(0);
set_include_path(get_include_path() . PATH_SEPARATOR . '../Classes/');
include 'PHPExcel/IOFactory.php';
include 'config.php';
include'AttachMailer.php';
$inputFileName = './Despacho.xls';
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
$vConex2 = mysqli_connect($vServer2,$vUser2,$vPassword2,$vBd2);
$file = fopen("RegistroDespacho.txt", "a");
$file2 = fopen("NuevosClientes.txt","a");
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$vContadorUpdate = 0;
$vArreglo ;
//var_dump('test');
foreach($sheetData as $Indice=>$objCelda)
{
	if($objCelda['A'] != ''){
		if ($vContadorUpdate==0){
			/*$vArrelo[0] = $objCelda['A']; //ID
			$vArrelo[1] = $objCelda['J']; //TIPO TRANSPORTE > COMENTARIO
			$vArrelo[2] = $objCelda['K']; //NOTA DE VENTA > COMENTARIO
			$vArrelo[3] = $objCelda['L']; //GLOSA 4 > COMENTARIO
			$vArrelo[4] = $objCelda['M']; //NOMBRE DE LA CIUDAD
			$vArrelo[5] = $objCelda['N']; //NUMERO DE BULTOS
			$vArrelo[6] = $objCelda['O']; //PESO BULTO
			$vArrelo[7] = $objCelda['P']; //MONTO NETO FINAL
			$vArrelo[8] = $objCelda['Q']; //MONTO VENTA FINAL
			$vArrelo[9] = $objCelda['R']; //GLOSA
			$vArrelo[10] = $objCelda['S']; // GLOSA 1
			$vArrelo[10] = $objCelda['T']; // GLOSA 2
			$vArrelo[10] = $objCelda['U']; // GLOSA 3
			$vArrelo[10] = $objCelda['X']; // NUMERO VENTA*/
			
			$vArrelo[0] = $objCelda['A']; //ID
			$vArrelo[1] = $objCelda['I']; //TIPO TRANSPORTE > COMENTARIO I
			$vArrelo[2] = $objCelda['J']; //NOTA DE VENTA > COMENTARIO J
			$vArrelo[3] = $objCelda['K']; //GLOSA 4 > COMENTARIO K
			$vArrelo[4] = $objCelda['L']; //NOMBRE DE LA CIUDAD L
			$vArrelo[5] = $objCelda['M']; //NUMERO DE BULTOS M
			$vArrelo[6] = $objCelda['N']; //PESO BULTO N
			$vArrelo[7] = $objCelda['O']; //MONTO NETO FINAL O
			$vArrelo[8] = $objCelda['P']; //MONTO VENTA FINAL P
			$vArrelo[9] = $objCelda['Q']; //GLOSA Q
			$vArrelo[10] = $objCelda['R']; // GLOSA 1 R
			$vArrelo[10] = $objCelda['S']; // GLOSA 2 S
			$vArrelo[10] = $objCelda['T']; // GLOSA 3 T
			$vArrelo[10] = $objCelda['U']; // NUMERO VENTA U
			//$vArrelo[11] = $objCelda['V']; //NUMERO VENDEDOR
			//var_dump($objCelda['V']);
			$vContadorUpdate = 1;
		}
		else {
			//$rut = $objCelda['B'] . $objCelda['C'];
			$rut = $objCelda['B'];
		
			//$sqlCliente = "SELECT COUNT(*) FROM oc_customer WHERE lastname = '" . $rut . "'";
			$sqlCliente = "SELECT COUNT(*) FROM oc_customer WHERE lastname LIKE '%" . $rut . "%'";
			$resultadoCliente = mysqli_query($GLOBALS['vConex2'],$sqlCliente);
			$countCliente = mysqli_fetch_row($resultadoCliente);
			if($countCliente[0] == 0){
			
				$sqlInsertCliente = "INSERT INTO `oc_customer`(`store_id`, `firstname`, `lastname`, `newsletter`, `customer_group_id`, `status`, `approved`, `date_added`) 
									VALUES (0,'" . str_replace("'", "", $objCelda['E']) . "','" . $rut . "',0,1,1,1,curdate())";
				$insertC = mysqli_query($GLOBALS['vConex2'],$sqlInsertCliente);
				
				$customer_id = mysqli_insert_id($GLOBALS['vConex2']);
				
				$sqlInsertAddress = "INSERT INTO `oc_address`(`customer_id`, `firstname`, `lastname`, `city`, `country_id`) 
									VALUES ('" . $customer_id . "','" . str_replace("'", "", $objCelda['E']) . "','" . $rut . "','" . $objCelda['L'] . "',43)";
				$insertA = mysqli_query($GLOBALS['vConex2'],$sqlInsertAddress);
				
				$sqlNumeroV = "SELECT `salesrep_id` FROM `oc_salesrep` WHERE `numeroV1` = " . $objCelda['V'] . " OR `numeroV2` = " . $objCelda['V'] . " OR `numeroV3` = " . $objCelda['V'] . " OR `numeroV4` = " . $objCelda['V'] . " OR `numeroV5` = " . $objCelda['V'] . " OR `numeroV6` = " . $objCelda['V'] . " OR `numeroV7` = " . $objCelda['V'] . " OR `numeroV8` = " . $objCelda['V'] . " OR `numeroV9` = " . $objCelda['V'] . "";
				
				echo "clientes ingresados[ rut = ".$rut."]<br>";
				fwrite($file2, "clientes ingresados Rut => ".$rut."\r\n");
				
									
				$resultNumero = mysqli_query($GLOBALS['vConex2'], $sqlNumeroV);
				
				$numeroVendedor = mysqli_fetch_row($resultNumero);
				
				//var_dump($numeroVendedor[0]);
				
				if($numeroVendedor[0]==null){
					$vendedor = 100220;
				}else{
					$vendedor = $numeroVendedor[0];
				}
				
				//var_dump($vendedor);
				
				
				$sqlGetCliente = "SELECT firstname,lastname, email, telephone,customer_group_id, customer_id
								  FROM oc_customer WHERE lastname = '" . $rut . "'";
				
				$resultCliente = mysqli_query($GLOBALS['vConex2'], $sqlGetCliente);
				$cliente = mysqli_fetch_row($resultCliente);
				
				$sqlGetAddress = "SELECT firstname, lastname, address_1, city, country_id, zone_id
								FROM oc_address 
								WHERE lastname = '" . $rut . "'";
								
				$resultAddress = mysqli_query($GLOBALS['vConex2'], $sqlGetAddress);
				$address = mysqli_fetch_row($resultAddress);
				
				$FFI = $objCelda['F']."-".$objCelda['G']."-".$objCelda['H'];
				$FFM = $objCelda['F']."-".$objCelda['G']."-".$objCelda['H'];
						
				$sql = "INSERT INTO oc_order(order_id, invoice_no, invoice_prefix, store_id, store_name, store_url, customer_id, customer_group_id, firstname, lastname, email, telephone,
						fax, payment_firstname, payment_lastname,payment_address_1, payment_city, payment_country, payment_country_id, payment_zone, payment_zone_id, payment_method, payment_code,
						shipping_firstname, shipping_lastname, shipping_address_1, shipping_city,  shipping_country, shipping_country_id, shipping_zone, shipping_zone_id, shipping_method, shipping_code, comment, total, order_status_id, affiliate_id, commission, language_id, currency_id, currency_code, currency_value, ip, user_agent, accept_language, date_added, date_modified, salesrep_id )
						VALUES ('" . $objCelda['A'] . "', '0', 'INV-2013-00', '0', 'Socima', 'http://socimagestion.com/', '" . $cliente[5] . "', '" . $cliente[4] . "', '" . str_replace("'", "", $cliente[0]) . "', '" . $cliente[1] . "', '" . $cliente[2] . "',
						'" . $cliente[3] . "', '0', '" .  str_replace("'", "", $address[0]) . "', '" . $address[1] . "', '" . str_replace("'","",$address[2]) . "', '" . str_replace("'", "", $address[3]) . "', (SELECT name FROM oc_country WHERE country_id = '" . $address[4] . "'), '" . $address[4] . "', (SELECT name FROM oc_zone WHERE zone_id = '" . $address[5] . "'), '" . $address[5] . "', '" . $objCelda['Q'] . "', '" . $objCelda['Q'] . "', '" . str_replace("'", "", $address[2]) . "', '" . $address[1] . "',
						'" . str_replace("'", "", $address[2]) . "', '" . str_replace("'", "", $address[3]) . "', (SELECT name FROM oc_country WHERE country_id = '" . $address[4] . "'), '" . $address[4] . "', (SELECT name FROM oc_zone WHERE zone_id = '" . $address[5] . "'), '" . $address[5] . "', 'Retirar en Socima', 'pickup.pickup', '\"" . mysqli_real_escape_string($GLOBALS['vConex2'],$objCelda['R']) . "\"', '" . $objCelda['P'] . "', '15', '0', '0.0000', '2', '2', 'CLP', '1.00000000', '181.160.211.128', 
						'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'es-CL,es;q=0.8,en-US;q=0.5,en;q=0.3', '" . $FFI . "', '" . $FFM . "', '" . $vendedor . "')";
				//var_dump($sql);
				
				$test = mysqli_query($GLOBALS['vConex2'],$sql)or die(mysqli_error($GLOBALS['vConex2']));
				fwrite($file, "Codigo => ".$objCelda['A']."\n Nombre => ".$objCelda['F']."\n  Nota de Venta => ".$objCelda['K']."\n Fecha => ".date('d-m-Y')."\r\n"  );
				echo "Ordenes ingresadas[ Codigo = ".$objCelda['A']."]<br>";
				
				//$mailer = new AttachMailer("sistema@socimagestion.com", "rodrigoarenas9@gmail.com, admin@socimagestion.com, odril.jtapia@gmail.com", "Nuevos Clientes Registrados", "Se han registrador nuevos Clientes en el sistema, favor de revisar y completar sus datos.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
				$mailer = new AttachMailer("sistema@socimagestion.com", "jtapia@odril.com", "Nuevos Clientes Registrados", "Se han registrador nuevos Clientes en el sistema, favor de revisar y completar sus datos.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
				$mailer->attachFile("NuevosClientes.txt");
				$mailer->send() ? "Enviado": "Problema al enviar";
			
			}else{
		
				//var_dump($objCelda['V']);
				$vSqlBuscar = "select  * from oc_order where order_id = ".$objCelda['A'].";";
				$vResultadoBuscar = mysqli_query($GLOBALS['vConex2'],$vSqlBuscar);

				$T = $vResultadoBuscar->num_rows;
				//var_dump($objCelda['V']);
				if($T>0){
				
					$vSql1 =  "UPDATE oc_order SET  order_status_id = 15 where order_id = \"".$objCelda['A']."\"  ";
					$vSql2 = "Insert into oc_order_history set order_id = ".$objCelda['A'].",order_status_id = 5, notify = 1,
					comment=\"Numero Factura : ".$objCelda['A']." \r\n Tipo de Transporte : ".$objCelda['I']." \n\r Nota de venta : ".$objCelda['J']."
					\r\n Glosa 4 : ".$objCelda['U']." \r\n Nombre Ciudad: ".$objCelda['L']." \r\n Numero de Bultos : ".$objCelda['M']."
					 \r\n Peso Bulto : ".$objCelda['N']." \r\n Monto Neto Final : ".$objCelda['O']." \r\n Monto venta final : ".$objCelda['P']."
					  \r\n Glosa : ".mysqli_real_escape_string($GLOBALS['vConex2'],$objCelda['Q'])." \r\n Glosa 1 : ".$objCelda['R']." \r\n Glosa 2 : ".$objCelda['D']." \r\n Glosa 3 : ".$objCelda['T']."
					   \r\n Numero Ven : ".$objCelda['W']."\",date_added = curdate();";
				//var_dump($vSql2);
					$test = mysqli_query($GLOBALS['vConex2'],$vSql1)or die(mysqli_error($GLOBALS['vConex2']));
					$test = mysqli_query($GLOBALS['vConex2'],$vSql2)or die(mysqli_error($GLOBALS['vConex2']));
					fwrite($file, "Codigo => ".$objCelda['A']."\n Nombre => ".$objCelda['E']."\n  Nota de Venta => ".$objCelda['J']."\n Fecha => ".date('d-m-Y')."\r\n"  );
					echo "Despacho Actualizado [ Codigo = ".$objCelda['A']."]<br>";
					
				}else{
					//var_dump($objCelda['V']);
					
					$sqlNumeroV = "SELECT `salesrep_id` FROM `oc_salesrep` WHERE `numeroV1` = " . $objCelda['V'] . " OR `numeroV2` = " . $objCelda['V'] . " OR `numeroV3` = " . $objCelda['V'] . " OR `numeroV4` = " . $objCelda['V'] . " OR `numeroV5` = " . $objCelda['V'] . " OR `numeroV6` = " . $objCelda['V'] . " OR `numeroV7` = " . $objCelda['V'] . " OR `numeroV8` = " . $objCelda['V'] . " OR `numeroV9` = " . $objCelda['V'] . "";
									
					$resultNumero = mysqli_query($GLOBALS['vConex2'], $sqlNumeroV);
					
					$numeroVendedor = mysqli_fetch_row($resultNumero);
					
					//var_dump($numeroVendedor[0]);
					
					if($numeroVendedor[0]==null){
						$vendedor = 100220;
					}else{
						$vendedor = $numeroVendedor[0];
					}
					
					//var_dump($vendedor);
					
					
					$sqlGetCliente = "SELECT firstname,lastname, email, telephone,customer_group_id, customer_id
									  FROM oc_customer WHERE lastname = '" . $rut . "'";
					
					$resultCliente = mysqli_query($GLOBALS['vConex2'], $sqlGetCliente);
					$cliente = mysqli_fetch_row($resultCliente);
					
					$sqlGetAddress = "SELECT firstname, lastname, address_1, city, country_id, zone_id
									FROM oc_address 
									WHERE lastname = '" . $rut . "'";
									
					$resultAddress = mysqli_query($GLOBALS['vConex2'], $sqlGetAddress);
					$address = mysqli_fetch_row($resultAddress);
					
					$FFI = $objCelda['F']."-".$objCelda['G']."-".$objCelda['H'];
					$FFM = $objCelda['F']."-".$objCelda['G']."-".$objCelda['H'];
							
					$sql = "INSERT INTO oc_order(order_id, invoice_no, invoice_prefix, store_id, store_name, store_url, customer_id, customer_group_id, firstname, lastname, email, telephone,
							fax, payment_firstname, payment_lastname,payment_address_1, payment_city, payment_country, payment_country_id, payment_zone, payment_zone_id, payment_method, payment_code,
							shipping_firstname, shipping_lastname, shipping_address_1, shipping_city,  shipping_country, shipping_country_id, shipping_zone, shipping_zone_id, shipping_method, shipping_code, comment, total, order_status_id, affiliate_id, commission, language_id, currency_id, currency_code, currency_value, ip, user_agent, accept_language, date_added, date_modified, salesrep_id )
							VALUES ('" . $objCelda['A'] . "', '0', 'INV-2013-00', '0', 'Socima', 'http://socimagestion.com/', '" . $cliente[5] . "', '" . $cliente[4] . "', '" . str_replace("'", "", $cliente[0]) . "', '" . $cliente[1] . "', '" . $cliente[2] . "',
							'" . $cliente[3] . "', '0', '" .  str_replace("'", "", $address[0]) . "', '" . $address[1] . "', '" . str_replace("'", "", $address[2]). "', '" . str_replace("'", "", $address[3]) . "', (SELECT name FROM oc_country WHERE country_id = '" . $address[4] . "'), '" . $address[4] . "', (SELECT name FROM oc_zone WHERE zone_id = '" . $address[5] . "'), '" . $address[5] . "', '" . $objCelda['Q'] . "', '" . $objCelda['Q'] . "', '" . str_replace("'", "", $address[2]) . "', '" . $address[1] . "',
							'" . str_replace("'", "", $address[2]) . "', '" . str_replace("'", "", $address[3]) . "', (SELECT name FROM oc_country WHERE country_id = '" . $address[4] . "'), '" . $address[4] . "', (SELECT name FROM oc_zone WHERE zone_id = '" . $address[5] . "'), '" . $address[5] . "', 'Retirar en Socima', 'pickup.pickup', '\"" . mysqli_real_escape_string($GLOBALS['vConex2'],$objCelda['R']) . "\"', '" . $objCelda['P'] . "', '15', '0', '0.0000', '2', '2', 'CLP', '1.00000000', '181.160.211.128', 
							'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0', 'es-CL,es;q=0.8,en-US;q=0.5,en;q=0.3', '" . $FFI . "', '" . $FFM . "', '" . $vendedor . "')";
					//var_dump($sql);
					
					$test = mysqli_query($GLOBALS['vConex2'],$sql)or die(mysqli_error($GLOBALS['vConex2']));
					fwrite($file, "Codigo => ".$objCelda['A']."\n Nombre => ".$objCelda['F']."\n  Nota de Venta => ".$objCelda['K']."\n Fecha => ".date('d-m-Y')."\r\n"  );
					echo "Ordenes ingresadas[ Codigo = ".$objCelda['A']."]<br>";
					
				}
			}
		}
	}
}
/*$mailer = new AttachMailer("sistema@socimagestion.com", "rodrigoarenas9@gmail.com, admin@socimagestion.com, odril.jtapia@gmail.com", "Nuevos Clientes Registrados", "Se han registrador nuevos Clientes en el sistema, favor de revisar y completar sus datos.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
$mailer->attachFile("NuevosClientes.txt");
$mailer->send() ? "Enviado": "Problema al enviar";*/
				

fclose($file);
fclose($file2);
unset($file);
unset($file2);

echo "<br><center> ======================= ";
echo "<br><h2>        Despacho Cargado                      </h2>";
echo "<br>=======================";

echo "<br>El archivo [ RegistroDespacho.txt ] fue creado con exito";
echo "<center><a href='RegistroDespacho.txt'> <small>Ver Registro de Despacho</small> </a></center>";
echo "<center> <a href=\"http://socimagestion.com/Mejora/PHPExcel/sistema.php\">volver</a> </center>";

echo "<br> ======================= </center>";


