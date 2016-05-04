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
	$idOrden	= $_POST['idOrden'];
	$productId = $_POST['productId'];
	$nombreProducto = $_POST['nombreProducto'];
	$modelProducto 	= $_POST['nombreProducto'];
	$cantidad 		= $_POST['cantidad'];
	$precio			= $_POST['precio'];
	$total			= $_POST['total'];
	
	/*$idOrden	= 1250431533;
	$productId = 6;
	$nombreProducto = "resr";
	$modelProducto 	= "TEST";
	$cantidad 		= 6;
	$precio			= 45;
	$total			= 90;*/
	
	$sql = "SELECT COUNT(*) FROM oc_order_product WHERE order_id = " . $idOrden . " AND product_id = " . $productId;
	//$sql = "SELECT COUNT(*) FROM oc_order_product WHERE order_id = 868210410 AND product_id = 140661";
	
	$resultado = mysqli_query($vConex, $sql);
	$fila = mysqli_fetch_row($resultado);
	
	if($fila[0] == 0){
		$sql2 = "INSERT INTO `oc_order_product`(`order_id`, `product_id`, `name`, `model`, `quantity`, `price`, `total`) 
			 VALUES (" . $idOrden . ", " . $productId . ", '" . $nombreProducto . "', '" . $modelProducto . "', " . $cantidad . ", " . $precio . ", " . $total . ");";
			 
		if(mysqli_query($vConex, $sql2)) {
			mysqli_close($vConex);
			//$Datos['valor'] = 2;
			$Datos[]=array("valor"=>2);
		}else{
			mysqli_close($vConex);
			//$Datos['valor'] = 0;
			$Datos[]=array("valor"=>0);
		}
	}
	
	/*$sql2 = "INSERT INTO `oc_order_product`(`order_id`, `product_id`, `name`, `model`, `quantity`, `price`, `total`) 
			 VALUES (" . $idOrden . ", " . $productId . ", '" . $nombreProducto . "', '" . $modelProducto . "', " . $cantidad . ", " . $precio . ", " . $total . ");";
			 
	if(mysqli_query($vConex, $sql2)) {
		mysqli_close($vConex);
		$Datos['valor'] = 2;
	}else{
		mysqli_close($vConex);
		$Datos['valor'] = 0;
	}*/
	
	//var_dump($sql);
}
 echo json_encode($Datos);



?>