<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Enviar producto por Correo</title>
<link REL="SHORTCUT ICON" HREF="themes/images/icon.ico">	
<style type="text/css">@import url("themes/softed/style.css");</style>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototype.js"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script src="include/js/general.js" type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="include/js/es_mx.lang.js?"></script>
<script type="text/javascript" src="include/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="modules/Products/multifile.js"></script>
</head>
<body marginheight="0" marginwidth="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">

<form name="EditView" method="POST" ENCTYPE="multipart/form-data" action="index.php" onSubmit="if(email_validate(this.form,'')) { VtigerJS_DialogBox.block();} else { return false; }">

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
	
	
	</td>
</tr>
																	   <tr>
	<td class="mailSubHeader" align="right"><font color="red">*</font><b>A: </b></td>
	<td class="cellText" style="padding: 5px;">
 		<input name="parent_id" id="parent_id" type="hidden" value="166@80|">
		<input type="hidden" name="saved_toid" value="<?php echo $_GET['user'] . '<' . $_GET['email'] . '>,' ; ?>">
		<input id="parent_name" name="parent_name" readonly class="txtBox" type="text" value="<?php echo $_GET['user'] . '<' . $_GET['email'] . '>,' ; ?>" style="width: 550px;">&nbsp;
	</td>
   </tr>
	<tr>
	   
   	<td class="mailSubHeader" style="padding: 5px;" align="right">Cc: </td>
	<td class="cellText" style="padding: 5px;">
		<input name="ccmail" id ="cc_name" class="txtBox" type="text" value="" style="width:550px">&nbsp;
	</td>
   	</tr>
      
   	<tr>
	<td class="mailSubHeader" style="padding: 5px;" align="right">Cco: </td>
	<td class="cellText" style="padding: 5px;">
		<input name="bccmail" id="bcc_name" class="txtBox" type="text" value="" style="width:60%">&nbsp;
	</td>
   	</tr>
   												   <tr>
	<td class="mailSubHeader" style="padding: 5px;" align="right" nowrap><font color="red">*</font>Asunto  :</td>
                        <td class="cellText" style="padding: 5px;"><input type="text" class="txtBox" name="subject" value="Producto Socima" id="subject" style="width:60%"></td>
           </tr>
			
   <tr>
	<td class="mailSubHeader" style="padding: 5px;" align="right" nowrap>Adjunto  :</td>
	<td class="cellText" style="padding: 5px;">
		<!--<input name="filename"  type="file" class="small txtBox" value="" size="78"/>-->
		<input name="del_file_list" type="hidden" value="">
					<div id="files_list" style="border: 1px solid grey; width: 500px; padding: 5px; background: rgb(255, 255, 255) none repeat scroll 0%; -moz-background-clip: initial; -moz-background-origin: initial; -moz-background-inline-policy: initial; font-size: x-small">Máximo 6 archivos
						<input id="my_file_element" type="file" name="filename" tabindex="7" onchange="validateFilename(this)" >
						<input type="hidden" name="filename_hidden" value="" />
                        <span id="limitmsg" style= "color:red; display:'';">Tamaño máximo de archivo aceptado es 3MB</span>
                	</div>
					<script>
						var multi_selector = new MultiSelector( document.getElementById( 'files_list' ), 6 );
						multi_selector.count = 0
						multi_selector.addElement( document.getElementById( 'my_file_element' ) );
					</script>		
	</td>
   </tr>
   <tr>
	<td colspan="3" class="mailSubHeader" style="padding: 5px;" align="center">
		<input title="Guardar [Alt+S]" accessKey="S" class="crmbutton small save" onclick="return email_validate(this.form,'save');" type="button" name="button" value="  Guardar " >&nbsp;
		<input name="Enviar" value=" Enviar " class="crmbutton small save" type="button" onclick="return email_validate(this.form,'send');">&nbsp;
		<input name="Cancelar [Alt+X]" accessKey="X" value=" Cancelar " class="crmbutton small cancel" type="button" onClick="window.close()">
	</td>
    </tr>
	<tr>
		<td colspan="3" align="center" valign="top" height="320">
			<textarea style="display: none;" class="detailedViewTextBox" id="description" name="description" cols="90" rows="16">En el siguiente link podrá visualizar el documento: <?php print( '<a href="' . $_GET['nombre'] . '">'. $_GET['nombre'] . '</a>' ); ?></textarea>
		</td>
   </tr>
</tbody>
</table>
</form>
</body>
<script>

var cc_err_msg = 'Cuenta de correo cc incorrecta';
var no_rcpts_err_msg = 'No se ha especificado destinatario';
var bcc_err_msg = 'Cuenta de correo bcc incorrecta';
var conf_mail_srvr_err_msg = 'Configura el servidor de correo saliente en Herramientas --> Servidor de Correo';

function email_validate(oform,mode)
{
	if(trim(mode) == '')
	{
		return false;
	}
	if(oform.parent_name.value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0)
	{
		//alert('No recipients were specified');
		alert(no_rcpts_err_msg);
		return false;
	}
	//Changes made to fix tickets #4633, # 5111 to accomodate all possible email formats
	var email_regex = /^[a-zA-Z0-9]+([\_\-\.]*[a-zA-Z0-9]+[\_\-]?)*@[a-zA-Z0-9]+([\_\-]?[a-zA-Z0-9]+)*\.+([\_\-]?[a-zA-Z0-9])+(\.?[a-zA-Z0-9]+)*$/;
	
	if(document.EditView.ccmail != null){
		if(document.EditView.ccmail.value.length >= 1){
			var str = document.EditView.ccmail.value;
            arr = new Array();
            arr = str.split(",");
            var tmp;
	    	for(var i=0; i<=arr.length-1; i++){
	            tmp = arr[i];
	            if(tmp.match('<') && tmp.match('>')) {
                    if(!findAngleBracket(arr[i])) {
                        alert(cc_err_msg+": "+arr[i]);
                        return false;
                    }
            	}
				else if(trim(arr[i]) != "" && !(email_regex.test(trim(arr[i]))))
	            {
	                    alert(cc_err_msg+": "+arr[i]);
	                    return false;
	            }
			}
		}
	}	
	if(document.EditView.bccmail != null){
		if(document.EditView.bccmail.value.length >= 1){
			var str = document.EditView.bccmail.value;
			arr = new Array();
			arr = str.split(",");
			var tmp;
			for(var i=0; i<=arr.length-1; i++){
				tmp = arr[i];
				if(tmp.match('<') && tmp.match('>')) {
                    if(!findAngleBracket(arr[i])) {
                        alert(bcc_err_msg+": "+arr[i]);
                        return false;
                    }
            	} 
            	else if(trim(arr[i]) != "" && !(email_regex.test(trim(arr[i])))){
					alert(bcc_err_msg+": "+arr[i]);
					return false;	
				}
			}	
		}
	}
	if(oform.subject.value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0)
	{
		if(email_sub = prompt('You did not specify a subject from this email. If you would like to provide one, please type it now','(no-Subject)'))
		{
			oform.subject.value = email_sub;
		}else
		{
			return false;
		}
	}
	if(mode == 'send')
	{
		server_check()	
	}else if(mode == 'save')
	{
		oform.action.value='Save';
		oform.submit();
	}else
	{
		return false;
	}
}
//function to extract the mailaddress inside < > symbols.......for the bug fix #3752
function findAngleBracket(mailadd)
{
        var strlen = mailadd.length;
        var success = 0;
        var gt = 0;
        var lt = 0;
        var ret = '';
        for(i=0;i<strlen;i++){
                if(mailadd.charAt(i) == '<' && gt == 0){
                        lt = 1;
                }
                if(mailadd.charAt(i) == '>' && lt == 1){
                        gt = 1;
                }
                if(mailadd.charAt(i) != '<' && lt == 1 && gt == 0)
                        ret = ret + mailadd.charAt(i);

        }
        if(/^[a-z0-9]([a-z0-9_\-\.]*)@([a-z0-9_\-\.]*)(\.[a-z]{2,3}(\.[a-z]{2}){0,2})$/.test(ret)){
                return true;
        }
        else
                return false;

}
function server_check()
{
	var oform = window.document.EditView;
        new Ajax.Request(
        	'index.php',
                {queue: {position: 'end', scope: 'command'},
                	method: 'post',
                        postBody:"module=Emails&action=EmailsAjax&file=Save&ajax=true&server_check=true",
			onComplete: function(response) {
			if(response.responseText.indexOf('SUCCESS') > -1)
			{
				oform.send_mail.value='true';
				oform.action.value='Save';
				oform.submit();
			}else
			{
				//alert('Please Configure Your Mail Server');
				alert(conf_mail_srvr_err_msg);
				return false;
			}
               	    }
                }
        );
}
/*$('attach_cont').innerHTML = $('attach_temp_cont').innerHTML;
function delAttachments(id)
{
    new Ajax.Request(
        'index.php',
        {queue: {position: 'end', scope: 'command'},
            method: 'post',
            postBody: 'module=Contacts&action=ContactsAjax&file=DelImage&attachmodule=Emails&recordid='+id,
            onComplete: function(response)
            {
		Effect.Fade('row_'+id);	                
            }
        }
    );

}*/

</script>
<script type="text/javascript" defer="1">
	var textAreaName = 'description';
	CKEDITOR.replace( textAreaName,	{
		extraPlugins : 'uicolor',
		uiColor: '#dfdff1'
	} ) ;
	var oCKeditor = CKEDITOR.instances[textAreaName];
</script>
</html>