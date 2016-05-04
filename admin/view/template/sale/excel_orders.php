<?php
require_once 'Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();
 
/////////////////////////////////////////////////////
//Conexion a base de datos
   function conectar_mysql(){	
		$db_hostname = 'localhost';
		$db_user = 'socimage_tienda3';
		$db_pass = '.10CORzHl2^%';
		$db_name = 'socimage_tienda3';

		$link = new mysqli($db_hostname, $db_user, $db_pass, $db_name);

		if(!$link){
			printf('no se conecto, error: %s\n', mysqli_connect_error());
			exit();
		}
		return $link;
	}
//var_dump(conectar_mysql());	

$order_id = $_GET['filter_order_id'];
$cliente = $_GET['filter_customer'];
$statusOrder = $_GET['filter_order_status_id'];
$total = $_GET['filter_total'];
$fechaA = $_GET['filter_date_added'];
$fechaM = $_GET['filter_date_modified'];

//var_dump($order_id);
//var_dump($cliente);
/*var_dump($statusOrder);
var_dump($total);
var_dump($fechaA);*/
//var_dump($fechaM);

//////////////////////////////////////////////////////////////////
//Funciones para rescatar los datos a colocar en el excel
	function getDatosOrderProcesadas($order_id, $cliente, $statusOrder, $total, $fechaA, $fechaM){
		$link = conectar_mysql();	
			  		
		$sql = "SELECT o.order_id, o.date_added, c.firstname, c.lastname AS rut, a.address_1, a.city, z.name, o.payment_method, o.comment
				FROM oc_order o JOIN oc_customer c ON (o.customer_id = c.customer_id)
				JOIN oc_address a ON(c.customer_id = a.customer_id)
				JOIN oc_zone z ON (z.zone_id = a.zone_id)";
				
		if($order_id == ''){
			$sql .= " WHERE o.order_id != 0";
		}else{
			$sql .= " WHERE o.order_id = " . $order_id;
		}
		
		if($cliente != ''){
			$sql .= " AND CONCAT(c.firstname, ' ', c.lastname) = '" . $cliente . "'";
		}
		
		if($statusOrder != '*'){
			$sql .= " AND  o.order_status_id = " . $statusOrder;
		}
		
		if($total != ''){
			$sql .= " AND o.total = " . $total;
		}
		
		if($fechaA != ''){
			$date = new DateTime($fechaA);
			$dateAdded =  $date->format('Y-m-d');
			$sql .= " AND DATE(o.date_added) = DATE('" . $dateAdded . "')";
		}
		
		if($fechaM != ''){
			$dateM = new DateTime($fechaM);
			$dateModified = $dateM->format('Y-m-d');
			$sql .= " AND DATE(o.date_modified) = DATE('" . $dateModified . "')";
		}
		
		//var_dump($sql);
		
		if($result = mysqli_query($link, $sql)){
			while($rows = mysqli_fetch_row($result)){
				$row[] = $rows;
			}
		}
		return $row;
		
		//$query = $this->db->query($sql);

		//return $query->row;
	}
	
	//Jorge
	function getOrderProcesadas($order_id){
		$link = conectar_mysql();	
		
		//$sql = "SELECT op.*, p.piso FROM oc_order_product op JOIN oc_product p ON (op.product_id = p.product_id) WHERE order_id = " . $order_id;
		$sql = "SELECT op.order_product_id, op.order_id, op.product_id, op.name, pd.meta_description, op.quantity, op.price, op.total, op.tax, op.reward, p.piso, 
				CONCAT( op.name,  ' ', pd.meta_description ) AS description, p.obs, (p.quantity-op.quantity) AS stock FROM oc_order_product op
				JOIN oc_product p ON ( op.product_id = p.product_id ) 
				JOIN oc_product_description pd ON ( p.product_id = pd.product_id ) 
				WHERE order_id = " . $order_id;
		
		if($result = mysqli_query($link, $sql)){
			while($rows = mysqli_fetch_row($result)){
				$row[] = $rows;
				}
		}
		return $row;
	}
      
$results = getDatosOrderProcesadas($order_id, $cliente, $statusOrder, $total, $fechaA, $fechaM);
//var_dump($results);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Creacion del excel
$x=0;

foreach($results as $result){

	$datos = array(
		'order_id'   => $result[0],
		'date_added' => $result[1],
		'firstname'  => $result[2],
		'rut'     	 => $result[3],
		'address'    => $result[4],
		'city'       => $result[5],
		'city_name'  => $result[6],
		'payment' 	 => $result[7],
		'comment'	 => $result[8]
	);
	
	$results2 = getOrderProcesadas($datos['order_id']);
	
	if(count($results2) != 0){
		foreach ($results2 as $ordens){
			$ordenes[] = array(
				'order_product_id' => $ordens[0],
				'order_id'		   => $ordens[1],
				'product_id'	   => $ordens[2],
				'product_name'	   => $ordens[3],
				'product_model'	   => $ordens[4],
				'cantidad'		   => $ordens[5],
				'precio'		   => $ordens[6],
				'total'			   => $ordens[7],
				'tax'			   => $ordens[8],
				'reward'		   => $ordens[9],
				'piso'			   => $ordens[10],
				'descripcion'	   => $ordens[11],
				'obs'			   => $ordens[12],
				'saldo'			   => $ordens[13]
			);
		}
	}

	$objPHPExcel->createSheet();
	$objPHPExcel->setActiveSheetIndex($x);

	$objPHPExcel->getActiveSheet()->setTitle($datos['order_id']);

	$objPHPExcel->getActiveSheet()->setTitle($datos['order_id']);

		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Fecha : ');
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Cliente : ');
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C2')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('C3', 'R.U.T. : ');
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C3')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('C4', 'Dirección : ');
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C4')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('C5', 'Ciudad');
		$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('C5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C5')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('C6', 'Condiciones : ');
		$objPHPExcel->getActiveSheet()->getStyle('C6')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C6')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('C6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C6')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('C7', 'Remisión : ');
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C7')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C7')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('C8', 'Comentario : ');
		$objPHPExcel->getActiveSheet()->getStyle('C8')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('C8')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C8')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C8')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C8')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Cantidad');
		$objPHPExcel->getActiveSheet()->getStyle('A10')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('A10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('A10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('A10')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('A10')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('B10', 'Código');
		$objPHPExcel->getActiveSheet()->getStyle('B10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('B10')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('B10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('B10')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('B10')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('C10', 'Piso');
		$objPHPExcel->getActiveSheet()->getStyle('C10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('C10')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('C10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C10')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C10')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('D10', 'Nombre Producto');
		$objPHPExcel->getActiveSheet()->getStyle('D10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('D10')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('D10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('D10')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('C12')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));
		
		$objPHPExcel->getActiveSheet()->setCellValue('E10', 'Descripción');
		$objPHPExcel->getActiveSheet()->getStyle('E10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('E10')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('E10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('E10')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('E10')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('F10', 'Precio ($)');
		$objPHPExcel->getActiveSheet()->getStyle('F10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('F10')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('F10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('F10')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('F10')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('G10', 'Total ($)');
		$objPHPExcel->getActiveSheet()->getStyle('G10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('G10')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('G10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('G10')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('G10')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('H10', 'Saldo');
		$objPHPExcel->getActiveSheet()->getStyle('H10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('H10')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('H10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('H10')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('H10')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

		$objPHPExcel->getActiveSheet()->setCellValue('I10', 'Obs');
		$objPHPExcel->getActiveSheet()->getStyle('I10')->getFont()->setSize(12);
		$objPHPExcel->getActiveSheet()->getStyle('I10')->getFont()->setBold(TRUE);
		$objPHPExcel->getActiveSheet()->getStyle('I10')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('I10')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('I10')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		//$objPHPExcel->getActiveSheet()->getStyle('I10')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));


			$objPHPExcel->getActiveSheet()->setCellValue('D1', $datos['date_added']);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(FALSE);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			//$objPHPExcel->getActiveSheet()->getStyle('D1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

			$objPHPExcel->getActiveSheet()->setCellValue('D2', utf8_encode($datos['firstname']));
			$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(FALSE);
			$objPHPExcel->getActiveSheet()->getStyle('D2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			//$objPHPExcel->getActiveSheet()->getStyle('D2')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

			$objPHPExcel->getActiveSheet()->setCellValue('D3', $datos['rut']);
			$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(FALSE);
			$objPHPExcel->getActiveSheet()->getStyle('D3')->getNumberFormat()->setFormatCode('#"."###"."###-#');
			$objPHPExcel->getActiveSheet()->getStyle('D3')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			//$objPHPExcel->getActiveSheet()->getStyle('D3')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

			$objPHPExcel->getActiveSheet()->setCellValue('D4', utf8_encode($datos['address']));
			$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(FALSE);
			$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D4')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			//$objPHPExcel->getActiveSheet()->getStyle('D4')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

			$objPHPExcel->getActiveSheet()->setCellValue('D5', utf8_encode($datos['city']));
			$objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('D5')->getFont()->setBold(FALSE);
			$objPHPExcel->getActiveSheet()->getStyle('D5')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D5')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D5')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			//$objPHPExcel->getActiveSheet()->getStyle('D5')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

			$objPHPExcel->getActiveSheet()->setCellValue('D6', utf8_encode($datos['payment']));
			$objPHPExcel->getActiveSheet()->getStyle('D6')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->getFont()->setBold(FALSE);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			//$objPHPExcel->getActiveSheet()->getStyle('D6')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

			$objPHPExcel->getActiveSheet()->setCellValue('D7');
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setBold(FALSE);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D7')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			//$objPHPExcel->getActiveSheet()->getStyle('D7')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

			$objPHPExcel->getActiveSheet()->setCellValue('D8', utf8_encode($datos['comment']));
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setBold(FALSE);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getFont()->setSize(12);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyle('D8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			//$objPHPExcel->getActiveSheet()->getStyle('D8')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'EEECE1')));

			$i = 11;
		//var_dump($ordenes);	
		if(count($ordenes) !=0){
			foreach($ordenes as $orden){
					$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $orden['cantidad']);
					$objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFont()->setBold(FALSE);
					$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFont()->setSize(8);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $orden['product_id']);
					$objPHPExcel->getActiveSheet()->getStyle('B' . $i)->getFont()->setBold(FALSE);
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setSize(8);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $orden['piso']);
					$objPHPExcel->getActiveSheet()->getStyle('C' . $i)->getFont()->setBold(FALSE);
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setSize(8);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, utf8_encode($orden['product_name']));
					$objPHPExcel->getActiveSheet()->getStyle('D' . $i)->getFont()->setBold(TRUE);
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setSize(8);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					
					$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, utf8_encode($orden['product_model']));
					$objPHPExcel->getActiveSheet()->getStyle('E' . $i)->getFont()->setBold(FALSE);
					$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getFont()->setSize(8);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					//$objPHPExcel->getActiveSheet()->getStyle('E'.$i)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'D6EDF2')));


					$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $orden['precio']);
					$objPHPExcel->getActiveSheet()->getStyle('F' . $i)->getFont()->setBold(FALSE);
					$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getFont()->setSize(8);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('$ #,##0');
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('F'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $orden['total']);
					$objPHPExcel->getActiveSheet()->getStyle('G' . $i)->getFont()->setBold(FALSE);
					$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getFont()->setSize(8);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('$ #,##0');
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('G'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $orden['saldo']);
					$objPHPExcel->getActiveSheet()->getStyle('H' . $i)->getFont()->setBold(FALSE);
					$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getFont()->setSize(8);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('H'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$objPHPExcel->getActiveSheet()->setCellValue('I' . $i, $orden['obs']);
					$objPHPExcel->getActiveSheet()->getStyle('I' . $i)->getFont()->setBold(FALSE);
					$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);
					$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFont()->setSize(8);
					$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
					//$objPHPExcel->getActiveSheet()->getStyle('I'.$i)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => 'D6EDF2')));

					$objPHPExcel->getActiveSheet()->getStyle('J'.$i)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

					$i++;
			}
			unset($ordenes);  
		}

		$objPHPExcel->getActiveSheet()->getStyle('A'.($i-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('B'.($i-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('C'.($i-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('D'.($i-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('E'.($i-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('F'.($i-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('G'.($i-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('H'.($i-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('I'.($i-1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		
		$sum = '=SUM(G11:G'.($i-1).')';
		$objPHPExcel->getActiveSheet()->setCellValue('G'.($i+1), $sum);
		//$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $sum);
		$objPHPExcel->getActiveSheet()->getStyle('G'.($i+1))->getNumberFormat()->setFormatCode('$#,##0');
		$objPHPExcel->getActiveSheet()->getStyle('G'.($i+1))->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('G'.($i+1))->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('G'.($i+1))->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		$objPHPExcel->getActiveSheet()->getStyle('G'.($i+1))->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
		
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);

		$x++;
		$objPHPExcel->getActiveSheet()->setAutoFilter('A10:I10');
}


$filename = 'Ordenes Completas.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
?>