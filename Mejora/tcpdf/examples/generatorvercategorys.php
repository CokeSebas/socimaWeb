<?php	
$id = $_GET['id'];
	$tipo = $_GET['tipo'];	

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

function get_datos($id){
	//$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
	$link = conectar_mysql();

	$vSql = "SELECT OCD.category_id, OCD.name, OPTC.product_id, OPTC.category_id, OPD.name, ROUND(OP.price), OP.image, OPD.meta_description
			 FROM oc_category_description OCD, oc_product_to_category OPTC, oc_product_description OPD, oc_product OP
			 WHERE OCD.category_id =" .  $id . " and OPTC.category_id = " . $id . " and OPD.product_id = OPTC.product_id and OPTC.product_id = OP.product_id AND OP.quantity != 0";
			 
	/*$vSql = "SELECT OCD.category_id, OCD.name, OPTC.product_id, OPTC.category_id, OPD.name, ROUND(OP.price), OP.image
			 FROM oc_category_description OCD, oc_product_to_category OPTC, oc_product_description OPD, oc_product OP
			 WHERE OCD.category_id =" .  $id . " and OPTC.category_id = " . $id . " and OPD.product_id = OPTC.product_id and OPTC.product_id = OP.product_id";*/

	if($result = mysqli_query($link, $vSql)){
		while($rows = mysqli_fetch_row($result)){
			$row[] = $rows;
		}
	}
	return $row;
}
$datos = get_datos($id);

//$categoria = htmlentities($datos[0][1]);

function reemplazaMe($text) { 
	utf8_encode($text); 
	$codigo= array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&uuml;","&ntilde;"); 
	$cambiar = array("á","é","í","ó","ú","ü","ñ"); 
	$text = str_replace($codigo, $cambiar, $text); 
	$text= strtolower($text); 
	//$text = ereg_replace("[^A-Za-z0-9-]", "", $text); 
	return $text; 
} 



function stripAccents($string){
	return utf8_encode(strtr($string,utf8_decode('àáâãäçèéêëìíîïóòôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝ'),'aaaaaceeeeiiiiooooouuuuyyAAAAACEEEEIIIIOOOOOUUUUY'));
}
//var_dump($datos[0][1]);

//$categoria = strtoupper(stripAccents($datos[0][1]));
$categoria = utf8_encode($datos[0][1]);
//var_dump($categoria);

require_once('tcpdf_include.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setPrintHeader(false);
$pdf->setFooterMargin(10);
$pdf->setFooterData('');
$pdf->AddPage();
$pdf->Ln(4);

$html = <<<EOT
<br>
<br>
<table border="0" width="760" align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:14px;">
	<tbody>
		<tr valing="middle">
			<td width ="400" height="30" >
			<a href=""><img alt="" src="http://socimagestion.com/image/logo-socima.png" style="width:235; height:120" /></a>
			</td>
			<td valign="top" width="400">
				<table align="rigth" border="0" style="font-family:Verdana, Geneva, sans-serif; font-size:15px;">
					<tbody>
						<tr> 
							<td><font size="8", color="#767071">Cerro El Plomo 3319- Barrio Industrial <br> Curauma, Valparaíso</font></td>
							<td align="left" ><img alt="" src="http://socimagestion.com/Mejora/tcpdf/examples/images/ubicacion.png"/> </td>
						</tr>
						<tr> 
							<td><font size="8", color="#767071">Santo Domingo 1160 Piso 8 <br> Santiago</font></td>
							<td align="left" ><img alt="" src="http://socimagestion.com/Mejora/tcpdf/examples/images/ubicacion.png"/> </td>
						</tr>
						<tr>
							<td><font size="8", color="#767071"> (Viña) +56 (32) 2544340 <br> (STGO) +56 (2) 24818230 </font></td>
							<td align="left"><img alt="" src="http://socimagestion.com/Mejora/tcpdf/examples/images/telefono.png" /></td>
						</tr>						
						<tr>					
							<td><font size="8", color="#767071"> info@socima.cl </font></td>
							<td align="left"><img alt="" src="http://socimagestion.com/Mejora/tcpdf/examples/images/mensaje.png" /></td>
						</tr>	
						<tr>					
							<td><font size="8", color="#767071"> www.socima.cl</font></td>
							<td align="left"><img alt="" src="http://socimagestion.com/Mejora/tcpdf/examples/images/sitioweb.png" /></td>
						</tr>								
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<br>
<br>
<br>
<br>
<table border="0" align="center" cellpadding="10" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;" width="760px" >
	<tbody>
		<tr valign="middle">
			<td width="690px" height ="80" style="background-color: #FFF;" align="center">
				<table align="center" border="0" style="font-family:Verdana, Geneva, sans-serif; font-size:18px; background-color: #699419;">
					<tbody>
						<tr>
							<td><font size="13", color="#ffffff">Nombre de la categoría</font></td>
						</tr>
					</tbody>
				</table>
				<table align="center" cellpadding="10" border="0" style="font-family:Verdana, Geneva, sans-serif; font-size:16px;background-color:#f0f5e8;">
					<tbody>
						<tr>
							<td><font size="10", color="#767071">$categoria</font></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
<br>
<br>
<br>
<table border="0" align="center" cellpadding="10" style="font-family:Verdana, Geneva, sans-serif" width="185%">
	<tbody>
		<tr valign="middle">
			<td width="55%" style align="center">
EOT;

for($y=0;$y<count($datos);$y++){	
//var_dump('entra');		
   $Nombre =  utf8_encode($datos[$y][4]);
   //$Nombre =  $datos[$y][4];
   //$Nombre =  htmlentities($datos[$y][4]);
   //var_dump($Nombre);
   //var_dump($datos[$y][4]);
   $Codigo =  $datos[$y][2];
   $Precio =  $datos[$y][5];
   $Imagen =  $datos[$y][6];
   $descripcion = $datos[$y][7];
   //$Nombre2 =  htmlentities($datos[$y+1][4]);
   $Nombre2 =  utf8_encode($datos[$y+1][4]);
   //var_dump($Nombre2);
   $Codigo2 =  $datos[$y+1][2];
   $Precio2 =  $datos[$y+1][5];
   $Imagen2 =  $datos[$y+1][6];
   $descripcion2 = $datos[$y+1][7];
  	if ($y>=0){
		$y+=1;
	}
	
	
$html .= <<<EOT
<table border="0" align="left" cellpadding="10" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;" width="500px">
	<tbody>
		<tr valign="middle">
			<td width="670" height ="80" style="background-color: #FFF;" align="center">							
				<table align="left" border="0"  cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:18px; background-color: #f0f5e8;">
					<tbody>
						<tr>
							<td width="325"><font size="12", color="#767071"><b>$Nombre</b><br/><b>$descripcion</b></font></td>
							<td width="10" bgcolor="white"></td>
							<td width="325"><font size="12", color="#767071"><b>$Nombre2</b><br/><b>$descripcion2</b></font></td>
						</tr>
					</tbody>
				</table>				
				<table align="left" cellpadding="1" border="0" style="font-family:Verdana, Geneva, sans-serif; font-size:16px;background-color:#f0f5e8;">
					<tbody>
						<tr>
							<td width="100"><ul style="color:green"><li></li></ul></td>
							<td width="225"><font size="12", color="#767071">Codigo: $Codigo</font></td>
							<td width="10" bgcolor="white"></td>							
							<td width="100"><ul style="color:green"><li></li></ul></td>
							<td width="225"><font size="12", color="#767071">Codigo: $Codigo2</font></td>
						</tr>
						<tr>
							<td width="100"><ul style="color:green"><li></li></ul></td>
							<td width="225"><font size="12", color="#767071">$$Precio</font></td>
							<td width="10" bgcolor="white"></td>
							<td width="100"><ul style="color:green"><li></li></ul></td>
							<td width="225"><font size="12", color="#767071">$$Precio2</font></td>
						</tr>
EOT;

						if(@getimagesize('http://socimagestion.com/image/'.$Imagen)) {
							$xxxx = getimagesize('http://socimagestion.com/image/'.$Imagen);
							$alto = $xxxx[1];  			  //Alto
							if($alto <= 140){
								$height = $alto;
							}else{
								$height = 140;
							}							
							$html .= <<<EOT
							<tr>						
								<td width="325" align="center"><img alt="" src="http://socimagestion.com/image/$Imagen"  width="175" height="$height"  /></td>
EOT;
						}else{ 
						$html.= <<<EOT
						<tr>						
								<td width="325" align="center"><img alt="" src="http://socimagestion.com/image/noimage.jpg"  width="175" height="175"  /></td>
EOT;
						}
						if(@getimagesize('http://socimagestion.com/image/'.$Imagen2)) {
						$alto2 = $Imagen2;  			  //Alto
							if($alto <= 140){
								$height2 = $alto;
							}else{
								$height2 = 140;
							}
						$html.=<<<EOT
								<td width="10" bgcolor="white"></td>						
								<td width="325" align="center"><img alt="" src="http://socimagestion.com/image/$Imagen2"  width="175" height="$height2"  /></td>
							</tr>
EOT;
						}else{
						$html.=<<<EOT
								<td width="10" bgcolor="white"></td>						
								<td width="325" align="center"><img alt="" src="http://socimagestion.com/image/noimage.jpg"  width="175" height="175"  /></td>
							</tr>
EOT;
						}
$html .= <<<EOT
					</tbody>
<br/>
				</table>
<br/>
<br/>
<br/>
			</td>
		</tr>
	</tbody>
</table>
<br>	
EOT;
}

$html .= <<<EOT
			</td>
		</tr>
	</tbody>
</table>
EOT;

//var_dump($datos);

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$url = "http://socimagestion.com/Mejora/tcpdf/examples/";
$nombre = $id .'.pdf';
$pdf->Output($nombre, 'I');

?>