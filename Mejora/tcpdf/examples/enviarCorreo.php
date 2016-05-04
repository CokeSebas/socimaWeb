<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Enviar categor¨ªa por correo</title>
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
                        <td class="cellText" style="padding: 5px;"><input type="text" class="txtBox" name="subject" value="PDF de categoria" id="subject" style="width:59%">
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