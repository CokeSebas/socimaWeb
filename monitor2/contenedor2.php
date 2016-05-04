<?php
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
	
function get_datos(){
	//$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
	$link = conectar_mysql();
	$vSql = "SELECT product_id FROM oc_product";
	if($result = mysqli_query($link, $vSql)){
		while($rows = mysqli_fetch_row($result)){
			$row[] = $rows;
		}
	}
	return $row;
}
$datos = get_datos();
/*foreach($datos as $dato){
	//var_Dump('http://socimagestion.com/index.php?route=product/product&product_id='.$dato[0]);
}*/
for($x=0;$x<count($datos);$x++){
	echo('paginas['.$x.']="http://socimagestion.com/index.php?route=product/product&product_id='.$datos[$x][0].'";' . '<br>');
}
?>
<html> 
<head> 

<meta name="Author-Personal" content="Sintetix, e-mail:cs@sintetix.com"> 

<title></title> 

<script language="JavaScript"> 
<!-- 
var paginas = new Array; 

/*paginas[0]="http://socimagestion.com/index.php?route=product/product&product_id=10980";
paginas[1]="http://socimagestion.com/index.php?route=product/product&product_id=276490";
paginas[2]="http://socimagestion.com/index.php?route=product/product&product_id=80715";*/
var tam = paginas.length; 
var coun = '<?php count($datos); ?>';
alert(coun);
/*function cambio(i) 
{ 
var page = 0; 
page = i; 
if (page < tam){ //alert(paginas[page]);
window.parent.centro.location=paginas[page]; 
} 
else{ 
page = 0; //alert(paginas[page]);
window.parent.centro.location=paginas[page]; 
} 
page++; 
//	 alert(page); 
// 100 es el tiempo en milisegundos ke tarda en cambiar la pagina 
setTimeout("cambio("+page+")",1000); 

} */
//--> 

</script> 

</head> 
<body onLoad="cambio(0);"> 

</body> 
</html>