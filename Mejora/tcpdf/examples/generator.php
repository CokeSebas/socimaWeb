<?php
	$id = $_GET['id'];
	include('basededatos.php');
		include'AttachMailer.php';
	$vConex =  mysqli_connect($vServer,$vUser,$vPassword,$vBd);
	$url = "http://socimagestion.com/Mejora/tcpdf/examples/";
	$nombre= "$id".'.pdf';
	$Producto;
	$Atributos;
	$Imagenes;
	function Producto($id)
	{		
	       $vSql = " select  PR.model, PRD.description, PR.image, PR.price from oc_product PR, oc_product_description PRD where PR.product_id = $id and PRD.product_id = $id ";
	       
	        $Resultado =  mysqli_query($GLOBALS[vConex],$vSql);
	        while($vArreglo = mysqli_fetch_row($Resultado))
	      	   {
	              $Producto[] =  $vArreglo;
	           
	           }
	           return $Producto;
	}
	
	
	function Atributos($id)
	{	
	 	$vSql = "SELECT ATRD.name, PRAT.text FROM oc_product_attribute PRAT, oc_attribute_description ATRD WHERE PRAT.product_id = $id and ATRD.attribute_id = PRAT.attribute_id";
	       
	        $Resultado =  mysqli_query($GLOBALS[vConex],$vSql);
	        while($vArreglo = mysqli_fetch_row($Resultado))
	      	   {
	              $Atributos[] =  $vArreglo;
	           
	           }
	           return $Atributos;
	}
	
	
	function Imagenes($id)
	{		
		 $vSql = "SELECT image
		 FROM oc_product_image
		 WHERE product_id =".$id;
	       
	        $Resultado =  mysqli_query($GLOBALS[vConex],$vSql);
	        while($vArreglo = mysqli_fetch_row($Resultado))
	      	   {
	              $Imagenes[] =  $vArreglo;
	           
	           }
	           return $Imagenes;
	}

$Pro = Producto($id);
$ImaEx = $Pro[0][2];
$Nombre = utf8_encode($Pro[0][0]);
$Precio = round($Pro[0][3]);
$Atr = Atributos($id);

$ima = Imagenes($id);

$html = "";





require_once('tcpdf_include.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf-> setFooterData(array(0,64,0), array(0,64,128));
$pdf-> setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf-> setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


$pdf->AddPage();

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
<br>
<br>


<table border="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;" width="114%" >
	<tbody>
		<tr>
			<td width="90%" height ="80" style="background-image:url('http://socimagestion.com/Mejora/tcpdf/examples/images/productovalor.png');" align="center">
							

				<table  border="0" style="font-family:Verdana, Geneva, sans-serif; font-size:18px; background-color: #699419;">
					<tbody>
						<tr>
							<td>Nombre del producto</td>
							<td>Precio</td>
						</tr>
					</tbody>
				</table>
				<table align="center" cellpadding="10" border="0" style="font-family:Verdana, Geneva, sans-serif; font-size:16px;background-color:#f0f5e8;">
					<tbody>
						<tr>
							<td><font size="10", color="#767071"> $Nombre </font></td>
							<td><font size="10", color="#767071"><b> $$Precio </b></font></td>

						</tr>
					</tbody>
				</table>
			</td>
		</tr>

	</tbody>
</table>
<br>
<br>
<table align="center">
<tr >
<!--<td  width="150" height="90" border="0" ><img alt="" src="http://socimagestion.com/image/$ImaEx" /></td>-->

EOT;
for($im=0; $im < count($ima);$im++)
{

$Imagen = $ima[$im][0];
$Imagen2 = $ima[$im+1][0];
if ($im>=0){
		$im+=1;
	}
/*$html.=<<<EOT
<td  width="150" height="90" border="0" ><img alt="" src="http://socimagestion.com/image/$Imagen" /></td>
EOT;*/

$html.= <<<EOT
<table border="0" align="left" cellpadding="10" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;" width="500px">
	<tbody>
		<tr valign="middle">
			<td width="670" height ="80" style="background-color: #FFF;" align="center">											
				<table align="left" cellpadding="1" border="0" style="font-family:Verdana, Geneva, sans-serif; font-size:16px;background-color:#f0f5e8;">
					<tbody>
						<tr>
EOT;
						$image = explode(".", $Imagen);
			//var_Dump($image);
			$urlI1 = $image[0].'-400x400.'.$image[1];
			//var_dump('http://socimagestion.com/image/cache/'.$urlI1);
					if(substr($Imagen, -6) != "_1.jpg"){
						if(@getimagesize('http://socimagestion.com/image/cache/'.$urlI1)){
						//if(file_exists('http://socimagestion.com/image/'.$Imagen)){
							$html .= <<<EOT
							<td width="325" align="center"><img alt="" src="http://socimagestion.com/image/cache/$urlI1"  width="175" height="175"  /></td>
EOT;
						}else{
							$html .= <<<EOT
							<td width="325" align="center"><img alt="" src="http://socimagestion.com/image/noimage.jpg"  width="175" height="175"  /></td>
EOT;
						}
					}
			$image2 = explode(".", $Imagen2);
			//var_Dump($image);
			$urlI2 = $image2[0].'-400x400.'.$image2[1];
			//var_dump('http://socimagestion.com/image/cache/'.$urlI1);
					if(substr($Imagen2, -6) != "_1.jpg"){
						if(@getimagesize('http://socimagestion.com/image/cache/'.$urlI2)){
						//if(file_exists('http://socimagestion.com/image/'.$Imagen2)){
							$html .= <<<EOT
							<td width="10" bgcolor="white"></td>						
							<td width="325" align="center"><img alt="" src="http://socimagestion.com/image/cache/$urlI2"  width="175" height="175"  /></td>
EOT;
						}else{
							$html .= <<<EOT
							<td width="10" bgcolor="white"></td>						
							<td width="325" align="center"><img alt="" src="http://socimagestion.com/image/noimage.jpg"  width="175" height="175"  /></td>
EOT;
						}
					}	
					$html .= <<<EOT
						</tr>
					</tbody>
				</table>

			</td>
		</tr>
	</tbody>
</table>
<br>	
EOT;

}
$html.=<<<EOT
</tr>
</table> 
<br>

<br>
<br>



<table border="0"   style="font-family:Verdana, Geneva, sans-serif" width="182%">
	<tbody>
	<tr>
	<td width="67%" style align="center" >
	<table align="left" border="0" cellpadding="0" cellspacing="6" style="font-family:Verdana, Geneva, sans-serif; font-size:18px; background-color:#f0f5e8; width:150%;">
	<tbody>
	
EOT;
for($At=0; $At<count($Atr);$At++)
{
$No = htmlentities($Atr[$At][0]);
$No2 = htmlentities($Atr[$At][1]);
$html.=<<<EOT
<tr>
<td width="50" height="50" colspan="4"><ul style="color:green"><li></li></ul></td>
<td height="50"colspan="4"><font size="10", color="#767071">$No : <b> $No2 </b></font></td>
</tr>

EOT;
}
$html.=<<<EOT

</tbody>
		</table>
			</td>		
		
		</tr>
	</tbody>
</table>



EOT;



$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$_SESSION['NombreArchivo'] = $nombre;
$pdf->Output($nombre, 'F');
 
	echo "<SCRIPT>window.location='javascript:abrir('http://socimagestion.com/Mejora/CorreoCategoria.php?categoria='<?php $id ?>)';</SCRIPT>"; 

?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Enviar categoría por correo</title>
<link REL="SHORTCUT ICON" HREF="themes/images/icon.ico">	
<style type="text/css">@import url("themes/softed/style.css");</style>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototype.js"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script src="include/js/general.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="include/js/es_mx.lang.js?"></script>
<script type="text/javascript" src="include/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="modules/Products/multifile.js"></script>
<style>
body {
background-image:url(/catalog/view/theme/default/image/background_new.png);
}
</style>
</head>
<body marginheight="0" marginwidth="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">

<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php" >

<input type="hidden" name="send_mail" >
<input type="hidden" name="contact_id" value="">
<input type="hidden" name="user_id" value="">
<input type="hidden" name="filename" value="">
<input type="hidden" name="old_id" value="">
<input type="hidden" name="module" value="Emails">
<input type="hidden" name="record" value="">
<input type="hidden" name="mode" value="">
<input type="hidden" name="action">
<input type="hidden" name="popupaction" value="create">
<input type="hidden" name="hidden_toid" id="hidden_toid">

<br>
<table class="small mailClient" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
   
   <tr>
	<td colspan=3 >
	<!-- Email Header -->
	<table border=0 cellspacing=0 cellpadding=0 width=100% class="mailClientWriteEmailHeader">
	<tr>
		<td >Redactar Correo</td>
	</tr>
	</table>
	<br>
	<br>
	
	</td>
</tr>
   <tr>
	<td class="mailSubHeader" align="right"><font color="red">*</font><b>A: </b></td>
	<td class="cellText" style="padding: 5px;">
 		<input name="parent_id" id="parent_id" type="hidden" value="166@80|">
		<input type="hidden" name="saved_toid" value="">
		<input id="parent_name" name="parent_name"  class="txtBox" type="text" value="" style="width: 300px;">&nbsp;
	</td>
   </tr>

   	<tr>
	<td class="mailSubHeader" style="padding: 5px;" align="right" nowrap><font color="red">*</font>Asunto  :</td>
                        <td class="cellText" style="padding: 5px;"><input type="text" class="txtBox" name="subject" value="PDF de Producto" id="subject" style="width:59%">
       </td>
       <tr>
	<td class="mailSubHeader" style="padding: 5px;" align="right" nowrap><font color="red">*</font>Adjunto  :</td>
                        <td class="cellText" style="padding: 5px;"><input type="text" class="txtBox" name="subject" value="Se adjuntar, arhivo pdf con el nombre de <?php echo  $nombre; ?>." id="comentario" style="width:95%; height: 80px;">
       </td>
        </tr>
        </tr>
      <tr>
	<td colspan="3" class="mailSubHeader" style="padding: 5px;" align="center">		 

		<input style="background-color: #2d9821; color: #FFFFFF;"  name="Enviar" id="EnviarBtn" value="Enviar " class="button" type="button" onclick="EnviarC()">
		<script type="text/javascript">
		 function EnviarC()
		 {
	                 var Correo  =  document.getElementById("parent_name").value;
	                 var Titulo  =  document.getElementById("subject").value;
	                 var Mensaje  =  document.getElementById("comentario").value;
	                 var Nombre  = "<?php echo $nombre; ?>";
	                 var Link1 =  "http://socimagestion.com/Mejora/Enviar.php?";
	                 var Links = Link1+"Correo="+Correo+"&Titulo="+Titulo+"&Mensaje="+Mensaje+"&Nombre="+Nombre;
	                 window.open(Links,"_self");
          
	         }
		</script>
		<input style="background-color: #2d9821; color: #FFFFFF;"  name="Cancelar [Alt+X]" accessKey="X" value=" Cancelar " class="crmbutton small cancel" type="button" onClick="window.close()">
	</td>
    </tr>
</tbody>
</table>
</form>
</body>
</html>