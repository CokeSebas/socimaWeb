<?php 

	function conectar_mysql(){
		$db_hostname = 'localhost';
		$db_user = "socimage_tienda3";
		$db_pass = ".10CORzHl2^%";
		$db_name = "socimage_tienda3";

		$link = new mysqli($db_hostname, $db_user, $db_pass, $db_name);

		if(!$link){
			printf('no se conecto, error: %s\n', mysqli_connect_error());
			exit();
		}
		return $link;
	}
	
	
	function actualizarOrden($status_id, $order_id){
		$link = conectar_mysql();
		
		$sql = "UPDATE oc_order SET order_status_id = '" . $status_id . "' WHERE order_id = '" . $order_id . "'";
	
		mysqli_query($link, $sql);
		
		if(mysqli_affected_rows($link) != 0){
			mysqli_close($link);
			return TRUE;
		}else{
			mysqli_close($link);
			return FALSE;
		}
	}



?>