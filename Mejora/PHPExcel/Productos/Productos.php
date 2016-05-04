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
<?

$inputFileName = './Productos.xls';
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
$vConex2 = mysqli_connect($vServer2,$vUser2,$vPassword2,$vBd2);
mysqli_set_charset($vConex2,"utf8");
//$file = fopen("Productos.txt", "w");
$file = fopen("Productos.txt", "a");
//$file2 = fopen("RegistroDespacho.txt", "a");
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$vContadorInsert = 0;
$vContadorUpdate = 0;
$vArreglo ;

foreach($sheetData as $Indice=>$objCelda)
{
    if(($vContadorInsert==0)and($vContadorUpdate==0))
    {

        $vContadorUpdate = 1;
        $vContadorInsert = 1;

    }
    else
    {
        
      $CodigoProducto		= $objCelda['A'];
      if($CodigoProducto == 0 or $CodigoProducto =='')
      {break;}
	  $NombreP 			= $objCelda['B'];
      $DescUno	       	= $objCelda['C'];
      $DescDos			= $objCelda['D'];	
      $FechaProducto	= $objCelda['E'];
      $Piso			    = $objCelda['F'];
      $UbUno			= $objCelda['G'];
      $UbDos			= $objCelda['H'];
      $UbTres			= $objCelda['I'];
      $StockInicial 	= round($objCelda['J']);
      $Stock			= round($objCelda['K']);
      $PrecioT			= $objCelda['L'];
      $Packs			= $objCelda['M'];
      $CantidadRecomendada	= $objCelda['N'];
      $Ancho			= $objCelda['O'];
      $Largo			= $objCelda['P'];
      $Diam			    = $objCelda['Q'];
      $Volumen			= $objCelda['R'];
      $Material			= $objCelda['S'];
      $Funcion			= $objCelda['T'];
      $ColorDis			= $objCelda['U'];
      $LineaDis 		= $objCelda['V'];
      $Adicional		= $objCelda['W'];
      $ProductoRelacionados	= $objCelda['X'];
      $Etiqueta			= $objCelda['Y'];
      $Categoria		= $objCelda['Z'];
	  $Marca            = $objCelda['AA'];
	  $imagen1			= $objCelda['AB'];
	  $imagen2			= $objCelda['AC'];
	  $imagen3			= $objCelda['AD'];
	  $imagen4			= $objCelda['AE'];
	  $imagen5			= $objCelda['AF'];
	 
	 
	
		 
	  if($PrecioT == null){
		$Precio = 0;
	  }else{
		$Precio = $objCelda['L'];
	  }
     
      $CodigoBodega = $Piso."-".$UbUno."-".$UbDos."-".$UbTres;
      $vSqlBuscar = "select * from oc_product where sku = $CodigoProducto;";
      $vResultadoBuscar = mysqli_query($GLOBALS['vConex2'],$vSqlBuscar);
	  $descripcionP = $DescUno . " " . $DescDos;
	  
	  $T = $vResultadoBuscar->num_rows;
	  
        if( $T > 0){
     	   echo "Producto Actualizado [ Codigo = ".$CodigoProducto."]<br>";
		   
		   
		   if(isset($Marca)){
				$sqlMarca = "SELECT `manufacturer_id` FROM `oc_manufacturer` WHERE `name` = '$Marca'";	
				if($resultMarca = mysqli_query($GLOBALS['vConex2'],$sqlMarca)){
					while ($row = mysqli_fetch_row($resultMarca)) {
						$IdMarca = $row[0];
					}
				}				
			}else{
				$IdMarca = 0;
			}

		   
			$vSql1 = "update oc_product SET model = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$NombreP)."\", upc = '$CodigoBodega', quantity = $Stock, date_available = '$FechaProducto', price = $Precio, manufacturer_id = '$IdMarca' where sku = $CodigoProducto;";

			//$vSql4 = "update oc_product_attribute  SET attribute_id = 20, text = '$Packs' where product_id =  $CodigoProducto and attribute_id = 20;";

			$vSqlPack = "Select * from oc_product_attribute where product_id = $CodigoProducto and attribute_id = 20";
			$vResultadoPack = mysqli_query($GLOBALS['vConex2'],$vSqlPack);
				$FPack = $vResultadoPack->num_rows;
				
					
			//$vSql5 = "update oc_product_attribute  SET attribute_id = 25, text = '$cantidad' where product_id = $CodigoProducto and attribute_id =25;";
				

			$vSqlCantidadRc = "Select * from oc_product_attribute where product_id = $CodigoProducto and attribute_id = 25";
			$vResultadoCRc = mysqli_query($GLOBALS['vConex2'],$vSqlCantidadRc);
			$FCRc = $vResultadoCRc->num_rows;

	        mysqli_query($GLOBALS['vConex2'],$vSql1)or die(mysqli_error($GLOBALS['vConex2']));
        }else{
          echo "Producto Ingresado [ Codigo = ".$CodigoProducto."]<br>";
          $valorImagen = 'data/'.$imagen2.'.jpg';
		  
		  
			if(isset($Marca)){
				$sqlMarca = "SELECT `manufacturer_id` FROM `oc_manufacturer` WHERE `name` = '$Marca'";	
				if($resultMarca = mysqli_query($GLOBALS['vConex2'],$sqlMarca)){
					while ($row = mysqli_fetch_row($resultMarca)) {
						$IdMarca = $row[0];
					}
				}				
			}else{
				$IdMarca = 0;
			}
		  
		  
			$vSql1 =" insert into  oc_product SET model = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$NombreP)."\", sku = '$CodigoProducto', upc = '$CodigoBodega', ean = '', jan = '', isbn = '', mpn = '', location = '', StockInicial= '$StockInicial',quantity = '$Stock', minimum = '1', subtract = '1', stock_status_id = '5', image = '$valorImagen', date_available = curdate(), manufacturer_id = '$IdMarca', shipping = '1', price = '$Precio', points = '0', weight = '0', weight_class_id = '1', length = '0', width = '$Ancho', height = '$Largo', length_class_id = '1', status = '1', tax_class_id = '0', sort_order = '0', date_added = '$FechaProducto',product_id= $CodigoProducto ;";

			mysqli_query($GLOBALS['vConex2'],$vSql1)or die(mysqli_error($GLOBALS['vConex2']));
		  
			 $vSql2 =" insert into  oc_product_description SET product_id= $CodigoProducto, language_id = '2', name = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$NombreP)."\", meta_keyword = '', meta_description = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$DescDos)."\", description = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$descripcionP)."\", tag = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$Etiqueta) . "' ;";
			 
			 //var_dump($vSql2);
			 //exit();
		  //$vSql3 =" insert into oc_product_to_store set product_id= $CodigoProducto, store_id=0";   
		  //$vSql4 = "insert into oc_product_attribute set product_id =  $CodigoProducto,  attribute_id = '20',language_id= '2', text ='$Packs' ; ";
		  //$vSql5= "insert into oc_product_attribute set product_id = $CodigoProducto, attribute_id = '25', language_id= '2', text = '$CantidadRecomendada'; ";

            
            mysqli_query($GLOBALS['vConex2'],$vSql2)or die(mysqli_error($GLOBALS['vConex2']));
            //mysqli_query($GLOBALS['vConex2'],$vSql3)or die(mysqli_error($GLOBALS['vConex2']));
            //mysqli_query($GLOBALS['vConex2'],$vSql4)or die(mysqli_error($GLOBALS['vConex2']));
            //mysqli_query($GLOBALS['vConex2'],$vSql5)or die(mysqli_error($GLOBALS['vConex2']));
            $vContadorInsert+=1;
			//var_dump("Codigo => ".$CodigoProducto);
            fwrite($file, "Codigo => ".$CodigoProducto."\r\n");
			//fwrite($file2, "test");
            //fwrite($file, "test");
			//exit();
        }	  
	  
	  if($Packs == null){
	    $pack = 0;
	  }else{
		$pack = $Packs;
	  }
	  	  
	  if($Packs != null){
	    $Select0 = "SELECT COUNT(*) FROM oc_product_attribute WHERE  product_id =  $CodigoProducto and attribute_id = 20;";
		if ($result0 = mysqli_query($GLOBALS['vConex2'],$Select0)) {
			while ($row = mysqli_fetch_row($result0)) {
				$count03 = $row;
			}
			mysqli_free_result($result0);
		}
		if ($count03[0] == 1){
			//var_dump('error 27');
			$Sql1 = "update oc_product_attribute  SET attribute_id = 20, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$pack) . "' where product_id =  $CodigoProducto and attribute_id = 20;";
			mysqli_query($GLOBALS['vConex2'],$Sql1)or die(mysqli_error($GLOBALS['vConex2']));
		}else{
			//var_dump('error 26');
			$Sql1 = "INSERT INTO oc_product_attribute SET product_id = '$CodigoProducto', attribute_id = 20, language_id = 2, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$pack) . "';";
			mysqli_query($GLOBALS['vConex2'],$Sql1)or die(mysqli_error($GLOBALS['vConex2']));
			//var_dump($Sql1);
		}
	  }
	  
	  //var_dump("check 1");
	  if($CantidadRecomendada == null){
	    $cantidad = 0;
	  }else{
		$cantidad = $CantidadRecomendada;
	  }
	  
	  if($CantidadRecomendada != null){
	    $Select0 = "SELECT COUNT(*) FROM oc_product_attribute WHERE  product_id =  $CodigoProducto and attribute_id = 25;";
		if ($result0 = mysqli_query($GLOBALS['vConex2'],$Select0)) {
			while ($row = mysqli_fetch_row($result0)) {
				$count03 = $row;
			}
			mysqli_free_result($result0);
		}
		if ($count03[0] == 1){
			//var_dump('error 27');
			$Sql1 = "update oc_product_attribute  SET attribute_id = 25, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$cantidad) . "' where product_id =  $CodigoProducto and attribute_id = 25;";
			mysqli_query($GLOBALS['vConex2'],$Sql1)or die(mysqli_error($GLOBALS['vConex2']));
		}else{
			//var_dump('error 26');
			$Sql1 = "INSERT INTO oc_product_attribute SET product_id = '$CodigoProducto', attribute_id = 25, language_id = 2, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$cantidad) . "';";
			mysqli_query($GLOBALS['vConex2'],$Sql1)or die(mysqli_error($GLOBALS['vConex2']));
			//var_dump($Sql1);
		}
	  }
	  
	  //var_dump("check 2");
	  	  
	  if($Material != null){
	    $Select1 = "SELECT COUNT(*) FROM oc_product_attribute WHERE  product_id =  $CodigoProducto and attribute_id = 19;";
		if ($result1 = mysqli_query($GLOBALS['vConex2'],$Select1)) {
			while ($row = mysqli_fetch_row($result1)) {
				$count3 = $row;
			}
			mysqli_free_result($result1);
		}
		if ($count3[0] == 1){
			//var_dump('error 27');
			$Sql1 = "update oc_product_attribute  SET attribute_id = 19, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$Material) . "' where product_id =  $CodigoProducto and attribute_id = 19;";
			mysqli_query($GLOBALS['vConex2'],$Sql1)or die(mysqli_error($GLOBALS['vConex2']));
		}else{
			//var_dump('error 26');
			$Sql1 = "INSERT INTO oc_product_attribute SET product_id = '$CodigoProducto', attribute_id = 19, language_id = 2, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$Material) . "';";
			mysqli_query($GLOBALS['vConex2'],$Sql1)or die(mysqli_error($GLOBALS['vConex2']));
			//var_dump($Sql1);
		}
	  }
	  
	  //var_dump("check 3");
	  
	  if($Funcion != null){
		$Select2 = "SELECT COUNT(*) FROM oc_product_attribute WHERE  product_id = $CodigoProducto and attribute_id = 16;";
		if ($result2 = mysqli_query($GLOBALS['vConex2'],$Select2)) {
			while ($row = mysqli_fetch_row($result2)) {
				$count4 = $row;
			}
			mysqli_free_result($result2);
		}
		if($count4[0] == 1){
			//var_dump('error 25');
			$Sql2 = "update oc_product_attribute  SET attribute_id = 16, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$Funcion) . "' where product_id =  $CodigoProducto and attribute_id = 16;";
			mysqli_query($GLOBALS['vConex2'],$Sql2)or die(mysqli_error($GLOBALS['vConex2']));
		}else{
			//var_dump('error 24');
			$Sql2 = "INSERT INTO oc_product_attribute SET product_id = '$CodigoProducto', attribute_id = 16, language_id = 2, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$Funcion) . "';";
			mysqli_query($GLOBALS['vConex2'],$Sql2)or die(mysqli_error($GLOBALS['vConex2']));
		}
	  }
	  
	  //var_dump("check 4");
	  
	  if($ColorDis != null){
	    $Select3 = "SELECT COUNT(*) FROM oc_product_attribute WHERE  product_id = $CodigoProducto and attribute_id = 13;";
		if ($result3 = mysqli_query($GLOBALS['vConex2'],$Select3)) {
			while ($row = mysqli_fetch_row($result3)) {
				$count5 = $row;
			}
			mysqli_free_result($result3);
		}
		if($count5[0] == 1){
			//var_dump('error 23');
			$Sql3 = "update oc_product_attribute SET attribute_id = 13, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$ColorDis) . "' where product_id =  $CodigoProducto and attribute_id = 13;";
			mysqli_query($GLOBALS['vConex2'],$Sql3)or die(mysqli_error($GLOBALS['vConex2']));
		}else{
			//var_dump('error 22');
			$Sql3 = "INSERT INTO oc_product_attribute SET product_id = '$CodigoProducto', attribute_id = 13, language_id = 2, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$ColorDis) . "';";
			mysqli_query($GLOBALS['vConex2'],$Sql3)or die(mysqli_error($GLOBALS['vConex2']));
		}
	  }
	  
	  //var_dump("check 5");
	  
	  if($LineaDis != null){
	    $Select4 = "SELECT COUNT(*) FROM oc_product_attribute WHERE  product_id = $CodigoProducto and attribute_id = 18;";
		if ($result4 = mysqli_query($GLOBALS['vConex2'],$Select4)) {
			while ($row = mysqli_fetch_row($result4)) {
				$count6 = $row;
			}
			mysqli_free_result($result4);
		}
	  	if($count6[0]== 1){
			//var_dump('error 21');
			$Sql4 = "update oc_product_attribute  SET attribute_id = 18, text = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$LineaDis)."\" where product_id = $CodigoProducto and attribute_id = 18;";
			//var_dump($Sql4);
			mysqli_query($GLOBALS['vConex2'],$Sql4)or die(mysqli_error($GLOBALS['vConex2']));
	  	}else{
			//var_dump('error 20');
			$Sql4 = "INSERT INTO oc_product_attribute SET product_id = '$CodigoProducto', attribute_id = 18, language_id = 2, text = \"".mysqli_real_escape_string($GLOBALS['vConex2'],$LineaDis)."\";";
			mysqli_query($GLOBALS['vConex2'],$Sql4)or die(mysqli_error($GLOBALS['vConex2']));
		}
	  }
	  
	  //var_dump("check 6");
	  
	  if($Adicional != null){
	    $Select5 = "SELECT COUNT(*) FROM oc_product_attribute WHERE product_id = $CodigoProducto and attribute_id = 12;";
		
		if ($result5 = mysqli_query($GLOBALS['vConex2'],$Select5)) {
			while ($row = mysqli_fetch_row($result5)) {
				$count7 = $row;
			}
			mysqli_free_result($result5);
		}
		if($count7[0] == 1){
			//var_dump('error 19');
			$Sql5 = "update oc_product_attribute  SET attribute_id = 12, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$Adicional) . "' where product_id = $CodigoProducto and attribute_id = 12;";
			//var_dump($Sql5);
			mysqli_query($GLOBALS['vConex2'],$Sql5)or die(mysqli_error($GLOBALS['vConex2']));
		}else{
			//var_dump('error 18');
			$Sql5 = "INSERT INTO oc_product_attribute SET product_id = '$CodigoProducto', attribute_id = 12, language_id = 2, text = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$Adicional) . "';";
			//var_dump($Sql5);
			mysqli_query($GLOBALS['vConex2'],$Sql5)or die(mysqli_error($GLOBALS['vConex2']));
		}
	  }
	  
	 //var_dump("check 7");
	  
	if($ProductoRelacionados != null){
		$relacions = explode(",", $ProductoRelacionados);

		if(count($relacions) == 1){
			$sql0 = "SELECT COUNT(*) AS total FROM `oc_product` WHERE `product_id` = $relacions[0]";
			if ($rst0 = mysqli_query($GLOBALS['vConex2'], $sql0)) {
				while ($row = mysqli_fetch_row($rst0)) {
					$test = $row;
				}
				mysqli_free_result($rst0);
			}
			//var_dump("prueba 1 " . $test[0]);
			if($test[0] !=0){
			
				$sql = "SELECT COUNT(*) FROM oc_product_related WHERE product_id = $CodigoProducto AND related_id = $relacions[0];";
			
				if ($result6 = mysqli_query($GLOBALS['vConex2'], $sql)) {
					while ($row = mysqli_fetch_row($result6)) {
						$count = $row;
					}
					mysqli_free_result($result6);
				}
				if($count[0] == 1){
					//var_dump('error 17');
					$Sql6 = "UPDATE oc_product_related SET product_id = $CodigoProducto, related_id = $relacions[0] where product_id =  $CodigoProducto AND related_id = $relacions[0];";
					mysqli_query($GLOBALS['vConex2'],$Sql6)or die(mysqli_error($GLOBALS['vConex2']));
				}else{
					//var_dump('error 16');
					$Sql7 = "INSERT INTO oc_product_related SET product_id = $CodigoProducto, related_id = $relacions[0];";
					mysqli_query($GLOBALS['vConex2'],$Sql7)or die(mysqli_error($GLOBALS['vConex2']));
				}
			}
		}else{
			foreach($relacions as $relacion){
				$sql0 = "SELECT COUNT(*) AS total FROM `oc_product` WHERE `product_id` = $relacion";
				if ($rst0 = mysqli_query($GLOBALS['vConex2'], $sql0)) {
					while ($row = mysqli_fetch_row($rst0)) {
						$test2 = $row;
					}
					mysqli_free_result($rst0);
				}
				//var_dump("prueba 2 " . $test2[0]);
			
				if($test2[0] != 0){
					$sql10 = "SELECT COUNT(*) FROM oc_product_related WHERE product_id = $CodigoProducto AND related_id = $relacion;";
					if ($result7 = mysqli_query($GLOBALS['vConex2'], $sql10)) {
						while ($row = mysqli_fetch_row($result7)) {
							$count2 = $row;
						}
						mysqli_free_result($result7);
					}
					
					if($count2[0] == 1){
						//var_dump('error 15');
						$Sql8 = "UPDATE oc_product_related SET product_id = $CodigoProducto, related_id = $relacion where product_id =  $CodigoProducto AND related_id = $relacion;";
						mysqli_query($GLOBALS['vConex2'],$Sql8)or die(mysqli_error($GLOBALS['vConex2']));
					}else{
						//var_dump('error 14');
						$Sql9 = "INSERT INTO oc_product_related SET product_id = $CodigoProducto, related_id = $relacion;";
						mysqli_query($GLOBALS['vConex2'],$Sql9)or die(mysqli_error($GLOBALS['vConex2']));
					}
				}
			}
		}
	}
	
	//var_dump("check 8");
	
	if($Categoria != null){

		$categorias = explode(",", $Categoria);
		if(count($categorias) == 1){
		
			$sqlt = "SELECT * FROM `oc_category_description` WHERE `name` = '$categorias[0]'";
				if ($result8 = mysqli_query($GLOBALS['vConex2'], $sqlt)) {
					while ($row = mysqli_fetch_row($result8)) {
						$categoryid = $row;
					}
					mysqli_free_result($result8);
				}
				//var_dump('category : ' . $categoryid[0]);

				$sqlCount = "SELECT COUNT(*) FROM `oc_product_to_category` WHERE `product_id` = $CodigoProducto AND `category_id` = $categoryid[0]";
				//var_dump($sqlCount);
				if ($result10 = mysqli_query($GLOBALS['vConex2'], $sqlCount)) {
					while ($row = mysqli_fetch_row($result10)) {
						$countP = $row;
					}
					mysqli_free_result($result10);
				}
				//var_dump($sqlCount);
				//var_dump($countP[0]);
				if($countP[0] == 1){
					//var_dump('error 13');
					$Sql10 = "UPDATE `oc_product_to_category` SET `product_id` = $CodigoProducto, `category_id` = $categoryid[0] WHERE `product_id` = $CodigoProducto AND `category_id` = $categoryid[0];";
					mysqli_query($GLOBALS['vConex2'],$Sql10)or die(mysqli_error($GLOBALS['vConex2']));
					//var_dump($Sql10);
				}else{
					//var_dump('error 12');
					$Sql11 = "INSERT INTO `oc_product_to_category`(`product_id`, `category_id`) VALUES ($CodigoProducto, $categoryid[0]);";
					mysqli_query($GLOBALS['vConex2'],$Sql11)or die(mysqli_error($GLOBALS['vConex2']));
					//var_dump($Sql11);
					//var_dump('guardo categoria');
				}
		}else{
		
			foreach($categorias as $ctg){
				//var_dump($ctg);
				$tofind = "ÀÁÂÄÅàáâäÒÓÔÖòóôöÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ";
				$replac = "AAAAAaaaaOOOOooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn";
				$ctg2 = utf8_encode(strtr(utf8_decode($ctg), utf8_decode($tofind), $replac));
				//var_dump($ctg2);
				//$sqlt = "SELECT * FROM `oc_category_description` WHERE `name` = '$ctg2'";
				$sqlt = "SELECT * FROM `oc_category_description` WHERE `name` = '" . mysqli_real_escape_string($GLOBALS['vConex2'],$ctg) . "'";
				if ($result8 = mysqli_query($GLOBALS['vConex2'], $sqlt)) {
					while ($row = mysqli_fetch_row($result8)) {
						$categoryid = $row;
					}
					mysqli_free_result($result8);
				}
				//var_dump('category : ' . $categoryid[0]);

				if(isset($categoryid[0])){
				
					$sqlCount = "SELECT COUNT(*) FROM `oc_product_to_category` WHERE `product_id` = $CodigoProducto AND `category_id` = $categoryid[0]";
					//var_dump($sqlCount);
					if ($result10 = mysqli_query($GLOBALS['vConex2'], $sqlCount)) {
						while ($row = mysqli_fetch_row($result10)) {
							$countP = $row;
						}
						mysqli_free_result($result10);
					}
					//var_dump($countP[0]);
					if($countP[0] == 1){
						//var_dump('error 11');
						$Sql10 = "UPDATE `oc_product_to_category` SET `product_id` = $CodigoProducto, `category_id` = $categoryid[0] WHERE `product_id` = $CodigoProducto AND `category_id` = $categoryid[0];";
						mysqli_query($GLOBALS['vConex2'],$Sql10)or die(mysqli_error($GLOBALS['vConex2']));
						//var_dump($Sql10);
					}else{
						//var_dump('error 10');
						$Sql11 = "INSERT INTO `oc_product_to_category`(`product_id`, `category_id`) VALUES ($CodigoProducto, $categoryid[0]);";
						mysqli_query($GLOBALS['vConex2'],$Sql11)or die(mysqli_error($GLOBALS['vConex2']));
						//var_dump('guardo categoria');
					}
					unset($categoryid);
				}
			}
		}
	}
	
	//var_dump("check 9");
		
	if($imagen1 != null){
	
		if(@getimagesize('http://socimagestion.com/image/data/'.$imagen1.'.jpg') != false){
			$valorImage = 'data/'.$imagen1.'.jpg';
			$sql = "SELECT COUNT(*) FROM `oc_product_image` WHERE product_id = $CodigoProducto AND `image` = '$valorImage';";
			if ($result = mysqli_query($GLOBALS['vConex2'], $sql)) {
				while ($row = mysqli_fetch_row($result)) {
					$countI = $row;
				}
				mysqli_free_result($result);
			}
			
			if($countI[0] == 1){
				$sqlU = "UPDATE oc_product_image SET product_id = $CodigoProducto, image = '$valorImage', sort_order = 1 WHERE product_id = $CodigoProducto AND image = '$valorImage';";
				mysqli_query($GLOBALS['vConex2'],$sqlU)or die(mysqli_error($GLOBALS['vConex2']));
				//var_dump('actualizar');
			}else{
				$sqlG = "INSERT INTO oc_product_image SET product_id = $CodigoProducto, image = '$valorImage', sort_order = 1;";
				mysqli_query($GLOBALS['vConex2'],$sqlG)or die(mysqli_error($GLOBALS['vConex2']));
				//var_dump('guardo imagen');
			}
		}
	}
	
	//var_dump("check 10");
	
	if($imagen2 != null){
		if(@getimagesize('http://socimagestion.com/image/data/'.$imagen2.'.jpg') != false) {
			
			$valorImage2 = 'data/'.$imagen2.'.jpg';
			$sql = "SELECT COUNT(*) FROM `oc_product_image` WHERE product_id = $CodigoProducto AND `image` = '$valorImage2';";
			if ($result = mysqli_query($GLOBALS['vConex2'], $sql)) {
				while ($row = mysqli_fetch_row($result)) {
					$countI = $row;
				}
				mysqli_free_result($result);
			}
			
			if($countI[0] == 1){
				$sqlU = "UPDATE oc_product_image SET product_id = $CodigoProducto, image = '$valorImage2', sort_order = 1 WHERE product_id = $CodigoProducto AND image = '$valorImage2';";
				mysqli_query($GLOBALS['vConex2'],$sqlU)or die(mysqli_error($GLOBALS['vConex2']));
				//var_dump('actualizar');
			}else{
				$sqlG = "INSERT INTO oc_product_image SET product_id = $CodigoProducto, image = '$valorImage2', sort_order = 1;";
				mysqli_query($GLOBALS['vConex2'],$sqlG)or die(mysqli_error($GLOBALS['vConex2']));
				//var_dump('guardo imagen');
			}
		}
	}
	//var_dump("check 11");
	
	if($imagen3 != null){
	if(@getimagesize('http://socimagestion.com/image/data/'.$imagen3.'.jpg') != false) {
		$valorImage3 = 'data/'.$imagen3.'.jpg';
		$sql = "SELECT COUNT(*) FROM `oc_product_image` WHERE product_id = $CodigoProducto AND `image` = '$valorImage3';";
		if ($result = mysqli_query($GLOBALS['vConex2'], $sql)) {
			while ($row = mysqli_fetch_row($result)) {
				$countI = $row;
			}
			mysqli_free_result($result);
		}
		if($countI[0] == 1){
			$sqlU = "UPDATE oc_product_image SET product_id = $CodigoProducto, image = '$valorImage3', sort_order = 1 WHERE product_id = $CodigoProducto AND image = '$valorImage3';";
			mysqli_query($GLOBALS['vConex2'],$sqlU)or die(mysqli_error($GLOBALS['vConex2']));
			//var_dump('actualizar');
		}else{
			$sqlG = "INSERT INTO oc_product_image SET product_id = $CodigoProducto, image = '$valorImage3', sort_order = 1;";
			mysqli_query($GLOBALS['vConex2'],$sqlG)or die(mysqli_error($GLOBALS['vConex2']));
			//var_dump('guardo imagen');
		}
		}
	}
	
	//var_dump("check 12");
	
	if($imagen4 != null){
	if(@getimagesize('http://socimagestion.com/image/data/'.$imagen4.'.jpg') != false) {
		$valorImage4 = 'data/'.$imagen4.'.jpg';
		$sql = "SELECT COUNT(*) FROM `oc_product_image` WHERE product_id = $CodigoProducto AND `image` = '$valorImage4';";
		if ($result = mysqli_query($GLOBALS['vConex2'], $sql)) {
			while ($row = mysqli_fetch_row($result)) {
				$countI = $row;
			}
			mysqli_free_result($result);
		}
		if($countI[0] == 1){
			$sqlU = "UPDATE oc_product_image SET product_id = $CodigoProducto, image = '$valorImage4', sort_order = 1 WHERE product_id = $CodigoProducto AND image = '$valorImage4';";
			mysqli_query($GLOBALS['vConex2'],$sqlU)or die(mysqli_error($GLOBALS['vConex2']));
			//var_dump('actualizar');
		}else{
			$sqlG = "INSERT INTO oc_product_image SET product_id = $CodigoProducto, image = '$valorImage4', sort_order = 1;";
			mysqli_query($GLOBALS['vConex2'],$sqlG)or die(mysqli_error($GLOBALS['vConex2']));
			//var_dump('guardo imagen');
		}
			}
	}
	
	//var_dump("check 13");
	
	if($imagen5 != null){
	if(@getimagesize('http://socimagestion.com/image/data/'.$imagen5.'.jpg') != false) {
		$valorImage5 = 'data/'.$imagen5.'.jpg';
		$sql = "SELECT COUNT(*) FROM `oc_product_image` WHERE product_id = $CodigoProducto AND `image` = '$valorImage5';";
		if ($result = mysqli_query($GLOBALS['vConex2'], $sql)) {
			while ($row = mysqli_fetch_row($result)) {
				$countI = $row;
			}
			mysqli_free_result($result);
		}
		if($countI[0] == 1){
			$sqlU = "UPDATE oc_product_image SET product_id = $CodigoProducto, image = '$valorImage5', sort_order = 1 WHERE product_id = $CodigoProducto AND image = '$valorImage5';";
			mysqli_query($GLOBALS['vConex2'],$sqlU)or die(mysqli_error($GLOBALS['vConex2']));
			//var_dump('actualizar');
		}else{
			$sqlG = "INSERT INTO oc_product_image SET product_id = $CodigoProducto, image = '$valorImage5', sort_order = 1;";
			mysqli_query($GLOBALS['vConex2'],$sqlG)or die(mysqli_error($GLOBALS['vConex2']));
			//var_dump('guardo imagen');
		}
	}	
	}
	
	//var_dump("check 14");
	  
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
    $mailer = new AttachMailer("sistema@socimagestion.com", "rodrigoarenas9@gmail.com, diseno@socimagestion.com, odril.jtapia@socima.com", "Nuevos Productos Registrados", "Se han registrador nuevos productos en el sistema, favor de revisar.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
    //$mailer = new AttachMailer("sistema@socimagestion.com", "jtapia@odril.com", "Nuevos Productos Registrados", "Se han registrador nuevos productos en el sistema, favor de revisar.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
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