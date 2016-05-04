<?php
error_reporting(E_ALL);
set_time_limit(0);
date_default_timezone_set('Europe/London');
/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../Classes/');
/** PHPExcel_IOFactory */
include 'PHPExcel/IOFactory.php';
include 'config.php';
include'AttachMailer.php';
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//unlink('Productos.txt');
$inputFileName = './inv Vend.xls';
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
$vConex2 = mysqli_connect($vServer2,$vUser2,$vPassword2,$vBd2);
//$file = fopen("invVend.txt", "w");
$file = fopen("Productos.txt", "a");
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$vContadorInsert = 0;
$vContadorUpdate = 0;
$vArreglo ;

$vSql10 = "UPDATE `oc_product` SET `quantity` = 0";
mysqli_query($GLOBALS['vConex2'],$vSql10)or die(mysqli_error($GLOBALS['vConex2']));

$vSql11 = "UPDATE `oc_product` SET `modificado` = 'FALSE'";
mysqli_query($GLOBALS['vConex2'],$vSql11)or die(mysqli_error($GLOBALS['vConex2']));

foreach($sheetData as $Indice=>$objCelda){
    if(($vContadorInsert==0)and($vContadorUpdate==0)){
        $vContadorUpdate = 1;
        $vContadorInsert = 1;
    }
    else{
        
      $CodigoProducto		= $objCelda['A'];
      if($CodigoProducto == 0 or $CodigoProducto =='')
      {break;}
      $DescUno	       		= $objCelda['B'];
      $DescDos			= $objCelda['C'];
	if(isset($objCelda['L'])){
      $FechaProducto		= $objCelda['L'];
	}
      $Piso			= $objCelda['J'];
      $UbDos			= $objCelda['G'];
      $Empaque			= $objCelda['H'];
	if(isset($objCelda['K'])){
		$StockInicial 		= round($objCelda['K']);
	}
      $Stock			= round($objCelda['E']);
      $Precio			= $objCelda['F'];
	  $piso 			= $objCelda['J'];
	if(isset($objCelda['M'])){
		$oferta = $objCelda['M'];
	}
	if(isset($objCelda['I'])){
		$obs = $objCelda['I'];
	}
	      
      //$CodigoBodega = $Piso."-".$UbUno."-".$UbDos."-".$UbTres;
      $vSqlBuscar = "select  * from oc_product where sku = $CodigoProducto";
      $vResultadoBuscar = mysqli_query($GLOBALS['vConex2'],$vSqlBuscar);
        
        $T = $vResultadoBuscar->num_rows;
        if( $T > 0){
		
			/*$vSql10 = "UPDATE `oc_product` SET `quantity` = 0";
			mysqli_query($GLOBALS['vConex2'],$vSql10)or die(mysqli_error($GLOBALS['vConex2'])); */
     	   echo "Stock Actualizado [ Codigo = ".$CodigoProducto."]<br>";
		   $vSql11 = "UPDATE `oc_product` SET `quantity` = '$Stock' WHERE `product_id` = '$CodigoProducto'";
		   //var_dump($vSql11);
		   mysqli_query($GLOBALS['vConex2'],$vSql11)or die(mysqli_error($GLOBALS['vConex2'])); 
			$vSql1 = "update oc_product SET piso = '$piso', upc = '$piso' where sku = '$CodigoProducto' ;";
			mysqli_query($GLOBALS['vConex2'],$vSql1)or die(mysqli_error($GLOBALS['vConex2']));
			
			if(isset($StockInicial)){
				$sql12 = "UPDATE `oc_product` SET `StockInicial` = '$StockInicial' WHERE `product_id` = '$CodigoProducto'";
				mysqli_query($GLOBALS['vConex2'],$sql12)or die(mysqli_error($GLOBALS['vConex2']));
            }
			
			if(isset($obs)){
				$sql15 = "UPDATE `oc_product` SET `obs` = '$obs' WHERE `product_id` = '$CodigoProducto'";
				mysqli_query($GLOBALS['vConex2'],$sql15)or die(mysqli_error($GLOBALS['vConex2']));
            }
			
			if(isset($Precio)){
				$sql16 = "UPDATE `oc_product` SET `price` = '$Precio' WHERE `product_id` = '$CodigoProducto'";
				mysqli_query($GLOBALS['vConex2'],$sql16)or die(mysqli_error($GLOBALS['vConex2']));
            }
			
			if(isset($DescUno)){
				$sql16 = "UPDATE `oc_product_description` SET `name` = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$DescUno)."\", `meta_description` = '$DescDos' WHERE `product_id` = '$CodigoProducto'";
				mysqli_query($GLOBALS['vConex2'],$sql16)or die(mysqli_error($GLOBALS['vConex2']));
            }
			
			if(isset($Empaque)){
				$sql17 = "UPDATE `oc_product_attribute` SET `text` = '$Empaque' WHERE `product_id` = '$CodigoProducto' AND `attribute_id` = '25'";
				mysqli_query($GLOBALS['vConex2'],$sql17)or die(mysqli_error($GLOBALS['vConex2']));
            }

			
			//var_dump($FechaProducto);
			if(isset($FechaProducto)){
				$año = substr($FechaProducto,0,4);
				$mes = substr($FechaProducto,4,-2);
				$dia = substr($FechaProducto,6,6);
				/*var_dump("año : " . $año);
				var_dump("mes : " . $mes);
				var_dump("dia : " . $dia);
				var_Dump("fecha A : ".$año.'-'.$mes.'-'.$dia);*/
				$fecha = $año.'-'.$mes.'-'.$dia;
				
				$sql13 = "UPDATE `oc_product` SET `date_added` = '$fecha' WHERE `product_id` = '$CodigoProducto'";
				mysqli_query($GLOBALS['vConex2'],$sql13)or die(mysqli_error($GLOBALS['vConex2']));
			}
			
			if(isset($oferta)){
				if($oferta != 0){
					$sql14 = "INSERT INTO `oc_product_special`(`product_id`, `customer_group_id`, `priority`, `price`) 
								VALUES ($CodigoProducto,1,1,$oferta)";
					mysqli_query($GLOBALS['vConex2'],$sql14)or die(mysqli_error($GLOBALS['vConex2']));
				}
			}
			
			$vSql11 = "UPDATE `oc_product` SET `modificado` = 'TRUE' WHERE `product_id` = '$CodigoProducto'";
			mysqli_query($GLOBALS['vConex2'],$vSql11)or die(mysqli_error($GLOBALS['vConex2']));
			
            $vContadorUpdate+=1;
			
        }else{
		
          echo "Producto Ingresado [ Codigo = ".$CodigoProducto."]<br>";
		  
			if(isset($FechaProducto)){
				$año = substr($FechaProducto,0,4);
				$mes = substr($FechaProducto,4,-2);
				$dia = substr($FechaProducto,6,6);
				/*var_dump("año : " . $año);
				var_dump("mes : " . $mes);
				var_dump("dia : " . $dia);
				var_Dump("fecha A : ".$año.'-'.$mes.'-'.$dia);*/
				$fecha = $año.'-'.$mes.'-'.$dia;	
			}else{
				$fecha = 'CURDATE()';
			}
			
			if(isset($StockInicial)){
				$StockInicial = $StockInicial;
            }else{
				$StockInicial = 0;
			}
			
			if(isset($obs)){
				$obs = $obs;
            }else{
				$obs = '';
			}

			
			$vSql1 =" insert into  oc_product SET model = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$DescUno)."\", sku = '$CodigoProducto', ean = '', jan = '', isbn = '', mpn = '', location = '', StockInicial= '$StockInicial',quantity = '$Stock', minimum = '1', subtract = '1', stock_status_id = '5', date_available = curdate(), manufacturer_id = '0', shipping = '1', price = '$Precio', points = '0', weight = '0', weight_class_id = '1', length = '0', width = '0', height = '0', length_class_id = '1', status = '1', tax_class_id = '0', sort_order = '0', date_added = '$fecha', product_id= $CodigoProducto, piso = '$piso', obs = '$obs', modificado = 'TRUE' ;";
         
			 $vSql2 =" insert into  oc_product_description SET product_id= $CodigoProducto, language_id = '2', name = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$DescUno)."\", meta_keyword = '', meta_description = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$DescDos)."\", description = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$DescDos)."\", tag = '' ;";

		  //$vSql3 =" insert into oc_product_to_store set product_id= $CodigoProducto, store_id=0";   
		  $vSql4 = "insert into oc_product_attribute set product_id =  $CodigoProducto,  attribute_id = '20',language_id= '2' ; ";
		  $vSql5= "insert into oc_product_attribute set product_id = $CodigoProducto, attribute_id = '25', language_id= '2' ";
		  
		  if(isset($oferta)){
				if($oferta != 0){
					$sql14 = "INSERT INTO `oc_product_special`(`product_id`, `customer_group_id`, `priority`, `price`) 
								VALUES ($CodigoProducto,1,1,$oferta)";
					mysqli_query($GLOBALS['vConex2'],$sql14)or die(mysqli_error($GLOBALS['vConex2']));
				}
			}
 
            mysqli_query($GLOBALS['vConex2'],$vSql1)or die(mysqli_error($GLOBALS['vConex2']));
            mysqli_query($GLOBALS['vConex2'],$vSql2)or die(mysqli_error($GLOBALS['vConex2']));
            //mysqli_query($GLOBALS['vConex2'],$vSql3)or die(mysqli_error($GLOBALS['vConex2']));
            mysqli_query($GLOBALS['vConex2'],$vSql4)or die(mysqli_error($GLOBALS['vConex2']));
            mysqli_query($GLOBALS['vConex2'],$vSql5)or die(mysqli_error($GLOBALS['vConex2']));
            $vContadorInsert+=1;
            fwrite($file, "Codigo => ".$CodigoProducto."\r\n");
        }
    }
}
fclose($file);
echo "<br><center> ======================= ";
echo "<br><h2>        Total de Productos                       </h2>";
echo "<br>=======================";

echo "<br>Productos Ingresados  :".($vContadorInsert - 1) ;
echo"<br>Productos Actualizados : ".($vContadorUpdate - 1) ;
$vTotal = $vContadorInsert + $vContadorUpdate;
echo "<br> Total de productos : ".($vTotal - 2) ;

$resta = $vContadorInsert -1;
if($resta>0)
{
    //$mailer = new AttachMailer("sistema@socimagestion.com", "rodrigoarenas9@gmail.com, diseno@socimagetion.com, odril.jtapia@gmail.com", "Nuevos Productos Registrados", "Se han registrador nuevos productos en el sistema, favor de revisar.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
    $mailer = new AttachMailer("sistema@socimagestion.com", "jtapia@odril.com", "Nuevos Productos Registrados", "Se han registrador nuevos productos en el sistema, favor de revisar.\r\n El correo se ha generado el  : ".date("d-m-Y").", A estos productos debe rellenar los datos que no contiene el excel de Inventario tales como Categoria, Etiquetas(tags), material, ancho, largo,stock inicial,packs, Código Bodega, cantidad recomendada,  etc.");
     $mailer->attachFile("Productos.txt");
    $mailer->send() ? "Enviado": "Problema al enviar";
}/*else{
	$mailer = new AttachMailer("sistema@socimagestion.com", "odril.jtapia@gmail.com", "Nuevos Productos Registrados", "Se han registrador nuevos productos en el sistema, favor de revisar.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
     //$mailer->attachFile("NuevosProductos.txt");
	 
     $mailer->attachFile("Productos.txt");
    $mailer->send() ? "Enviado": "Problema al enviar";
}*/
echo "<center> <a href=\"http://socimagestion.com/Mejora/PHPExcel/sistema.php\">volver</a> </center>";

echo "<br> ======================= </center>";
?>