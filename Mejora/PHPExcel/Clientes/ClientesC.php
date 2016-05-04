<?php
//echo "Cargando Archivo Cliente";
error_reporting(E_ALL);
header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
set_include_path(get_include_path() . PATH_SEPARATOR . '../Classes/');
include 'PHPExcel/IOFactory.php';
include 'config.php';
include'AttachMailer.php';
$inputFileName = 'Credito.csv';
$file = fopen("CreditoClienteC.txt", "a");
$vConex2 = mysqli_connect($vServer2,$vUser2,$vPassword2,$vBd2);
/*$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);*/

$sqlCredito0 = "UPDATE oc_customer SET Credito = 0";
$resultCredito0 = mysqli_query($GLOBALS['vConex2'],$sqlCredito0);

// Lee los nombres de los campos
//$creditoC = fopen($inputFileName, "r");

// Lee los registros
$fila = 1;
if (($creditoC = fopen($inputFileName, "r")) !== FALSE) {
	while (($datos = fgetcsv($creditoC, 1000, ",")) !== FALSE) {
		$numero = count($datos);
		//echo "<p> $numero de campos en la línea $fila: <br /></p>\n";
        $fila++;
		$registros[] = $datos;
	}
	fclose($creditoC);
}
//fclose($creditoC);
//var_dump($registros);
//echo "Leidos " . count($registros) . " registros\n";

foreach($registros AS $registro ){

	/*$clientes = explode(',',$registro[0]);
	//var_dump($clientes);
	$vRutCliente = $clientes[0];        
    $vNombreCliente = $clientes[3] . ' ' . $clientes[2];
	if(isset($clientes[11])){
		$vMaxCredito = $clientes[11];
	}else{
		$vMaxCredito = '0';
	}
	$vCreditoDebe = $clientes[9];
	$IR = substr($clientes[0],0,2);*/
	//var_Dump($registro);
    $vRutCliente = $registro[0];        
    $vNombreCliente = $registro[2];
	if(isset($registro[10])){
		$vMaxCredito = $registro[10];
	}else{
		$vMaxCredito = '0';
	}	
	$vCreditoDebe = $registro[8];    
	$IR = substr($registro[0],0,2);

    echo  "<center> <h2> Sistema de ingreso de clientes </h2> </center>";
	
	
	if($IR == '00'){
		//$rutCliente = substr($vRutCliente,2).$registro[1];
		$rutCliente = substr($vRutCliente,2);
	}elseif($IR == '01'){
		//$rutCliente = substr($vRutCliente,1).$registro[1];
		$rutCliente = substr($vRutCliente,1);
	}
	$CreditoMaximo = str_replace(",","",$vMaxCredito);
	$CreditoDebe = str_replace(",","",$vCreditoDebe);
	/*var_dump("dato 1 " . $vMaxCredito);
	var_dump("dato 2 " . $CreditoDebe);
	var_dump("dato 3 " . $rutCliente);*/
	
	//var_dump($vNombreCliente);
    //$vSql = "select * from oc_customer where lastname = '$rutCliente';";
    $vSql = "select * from oc_customer where lastname LIKE '%$rutCliente%';";
    $vResultadoBuscar = mysqli_query($GLOBALS['vConex2'],$vSql);
    $T = $vResultadoBuscar->num_rows;
    if($T > 0){
         echo "<center> Cliente encontrado insertando credito </center>";
         echo "<br><code>".$vSql2 = "update oc_customer set CreditoMaximo = $CreditoMaximo, Credito = (Credito + $CreditoDebe) where lastname LIKE '%$rutCliente%'";
         echo " </code>";
         $vResultadoBuscar = mysqli_query($GLOBALS['vConex2'],$vSql2);
       
    }else{
		$sqlInsertCliente = "INSERT INTO `oc_customer`(`store_id`, `firstname`, `lastname`,`newsletter`,`customer_group_id`,`status`, `approved`, `date_added`, `CreditoMaximo`)
		VALUES (0,'" . str_replace("'","", $vNombreCliente) . "','" . $rutCliente.'-'.$registro[1] . "',1,1,1,1,curdate(),'" . $CreditoMaximo . "')";
		$resultInsert = mysqli_query($GLOBALS['vConex2'], $sqlInsertCliente);
		
		$customer_id = mysqli_insert_id($GLOBALS['vConex2']);
				
		$sqlInsertAddress = "INSERT INTO `oc_address`(`customer_id`, `firstname`, `lastname`, `city`, `country_id`) 
							VALUES ('" . $customer_id . "','" .str_replace("'","", $vNombreCliente) . "','" . $rutCliente . "','',43)";
		$insertA = mysqli_query($GLOBALS['vConex2'],$sqlInsertAddress);		
		
		$sqlUpdateCredito = "update oc_customer set CreditoMaximo = $CreditoMaximo, Credito = (Credito + $CreditoDebe) where lastname = '$rutCliente'";
		$resultUpdate = mysqli_query($GLOBALS['vConex2'],$sqlUpdateCredito);
		
		fwrite($file, "clientes ingresados Rut => ".$rutCliente.'-'.$registro[1]."\r\n");
		fclose($file);
		$mailer = new AttachMailer("sistema@socimagestion.com", "odril.jtapia@gmail.com, rodrigoarenas9@gmail.com, admin@socimagestion.com", "Nuevos Clientes Registrados", "Se han registrador nuevos Clientes en el sistema, favor de revisar y completar sus datos.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
		//$mailer = new AttachMailer("sistema@socimagestion.com", "jtapia@odril.com", "Nuevos Clientes Registrados", "Se han registrador nuevos Clientes en el sistema, favor de revisar y completar sus datos.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
		$mailer->attachFile("CreditoClienteC.txt");
		$mailer->send() ? "Enviado": "Problema al enviar";
	}
	
}
   
echo "<center> <a href=\"http://socimagestion.com/Mejora/PHPExcel/sistema.php\">volver</a> </center>";

echo "<br> ======================= </center>";    
echo "<hr>";
?>