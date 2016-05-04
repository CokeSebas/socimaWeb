<?php
//echo "Cargando Archivo Cliente";
error_reporting(E_ALL);
header("Content-Type: text/html;charset=utf-8");
set_time_limit(0);
set_include_path(get_include_path() . PATH_SEPARATOR . '../Classes/');
include 'PHPExcel/IOFactory.php';
include 'config.php';
include'AttachMailer.php';
$inputFileName = 'Credito.xls';
$file = fopen("CreditoCliente.txt", "a");
$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
$vConex2 = mysqli_connect($vServer2,$vUser2,$vPassword2,$vBd2);
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$sqlCredito0 = "UPDATE oc_customer SET Credito = 0";
$resultCredito0 = mysqli_query($GLOBALS['vConex2'],$sqlCredito0);

foreach($sheetData as $Indice=>$objCelda)
{
    $vVendedor = $objCelda['B'];	        // A // Vendedor		
    $vRutCliente = $objCelda['C']; 		// B // Rut
    $vNombreCliente = $objCelda['E'];           // E // Nombre Cliente
	$vMaxCredito = $objCelda['O'];
	$vCreditoDebe = $objCelda['L'];
    /*$vDir1= $objCelda['F'];                     // F // Direccion 1 
    $vDir2 = $objCelda['G']; 			// G // Direccion 2
    $vFonoCliente = $objCelda['H']; 		// H // Fono
    $vFaxCliente = $objCelda['I'];              // I // Fax
    $vCiudad = $objCelda['L'];			// L // Ciudad
    $vComentarioCliente = $objCelda['M'];       // M // Comentario
    $vZonaCliente = $objCelda['R'];             // R // Zona Cliente
    $vCorreo = $objCelda['AD'];  		// AD //Correo
    $vMaxCredito = $objCelda['J'];		// J // MaxCredito	
    $vPais = $objCelda['P'];   			// P // Pais*/

    

    echo  "<center> <h2> Sistema de ingreso de clientes </h2> </center>";
	$rutCliente = str_replace(",","",$vRutCliente);
	$CreditoMaximo = str_replace(",","",$vMaxCredito);
	$CreditoDebe = str_replace(",","",$vCreditoDebe);
	//var_dump("dato 1 " . $vMaxCredito);
	//var_dump("dato 2 " . $saldoCliente);
    $vSql = "select * from oc_customer where lastname LIKE '%$rutCliente%';";
    $vResultadoBuscar = mysqli_query($GLOBALS['vConex2'],$vSql);
    $T = $vResultadoBuscar->num_rows;
	
    if($T > 0){	
         echo "<center> Cliente encontrado insertando credito </center>";
         echo "<br><code>".$vSql2 = "update oc_customer set CreditoMaximo = $CreditoMaximo, Credito = (Credito + $CreditoDebe) where lastname = '$rutCliente'";
         echo " </code>";
         $vResultadoBuscar = mysqli_query($GLOBALS['vConex2'],$vSql2);
        
    }else{
		$sqlInsertCliente = "INSERT INTO `oc_customer`(`store_id`, `firstname`, `lastname`,`newsletter`,`customer_group_id`,`status`, `approved`, `date_added`, `CreditoMaximo`) 
							VALUES (0,'" . str_replace("'","", $vNombreCliente) . "','" . $rutCliente . "',1,1,1,1,curdate(),'" . $CreditoMaximo . "')";
		$resultInsert = mysqli_query($GLOBALS['vConex2'], $sqlInsertCliente);
		
		//$sqlUpdateCredito = "update oc_customer set CreditoMaximo = $CreditoMaximo, Credito = (Credito - $CreditoDebe) where lastname = '$rutCliente'";
		$sqlUpdateCredito = "update oc_customer set CreditoMaximo = $CreditoMaximo, Credito = (Credito + $CreditoDebe) where lastname = '$rutCliente'";
        $resultUpdate = mysqli_query($GLOBALS['vConex2'],$sqlUpdateCredito);
		
		fwrite($file, "clientes ingresados Rut => ".$rutCliente."\r\n");
		fclose($file);
		$mailer = new AttachMailer("sistema@socimagestion.com", "odril.jtapia@gmail.com, rodrigoarenas9@gmail.com, admin@socimagestion.com", "Nuevos Clientes Registrados", "Se han registrador nuevos Clientes en el sistema, favor de revisar y completar sus datos.\r\n El correo se ha generado el  : ".date("d-m-Y").";");
		$mailer->attachFile("CreditoCliente.txt");
		$mailer->send() ? "Enviado": "Problema al enviar";
		
		
	}
   
echo "<center> <a href=\"http://socimagestion.com/Mejora/PHPExcel/sistema.php\">volver</a> </center>";

echo "<br> ======================= </center>";    
echo "<hr>";
}