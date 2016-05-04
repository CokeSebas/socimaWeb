<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 24/09/14
 * Time: 9:55
 */

echo  "<center> <IMG SRC=\"http://socimagestion.com/catalog/view/theme/default/image/logosocima.png\" > </center><br/> - Cargar solo valores, evitar excel con Formulas.<br/>- Evitar cargar archivos sobre 1000 lineas, recomendamos cargar por parte.";






?>

<html>

<link href="jquery.si.css" rel="stylesheet" type="text/css" />
<script src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" type="text/javascript"></script>
<script src="jquery.si.js" type="text/javascript"></script>

<head>

</head>
<body style="font-family:Georgia, 'Times New Roman', Times, serif">
<?php


//if(isset($_SESSION['Clave']))
if(isset($_SESSION['token']))
{
   
?>
<div class="box1">
<div class="Div1">
	Despachos<br>
    <IMG SRC="http://socimagestion.com/Mejora/PHPExcel/despacho.png" WIDTH=100 HEIGHT=100>
    <form action="http://socimagestion.com/Mejora/PHPExcel/Despacho/subir.php" method="post" enctype="multipart/form-data">
    <br>
    <input name="archivo"  class="button2" type="file" size="35" />
    <input name="enviar" class="button" type="submit" value="Subir" />
    <input name="action" type="hidden" value="upload" />
	</form>

 <br>
 </div  >
 <div class="Div1">
		<p>Carga Productos Masivo<br>
        <IMG SRC="http://socimagestion.com/Mejora/PHPExcel/producto.png" WIDTH=100 HEIGHT=100></p>
		<form action="http://socimagestion.com/Mejora/PHPExcel/Productos/subir.php" method="post" enctype="multipart/form-data">
        <br>
        <input name="archivo"  class="button2" type="file" size="35" />
        <input name="enviar" class="button" type="submit" value="Subir" />
        <input name="action" type="hidden" value="upload" />
		</form>
<p><a href="https://docs.google.com/spreadsheets/d/1RFTcsQFxxYpCVofrtCuTTqzmVybdh4EyRpQwgLoLpVk/edit?usp=sharing" target="new">Archivo de ejemplo </a></p>
		<p>Recordar: <br>
		  Crear un copia del archivo	o descargar para editar.<br>
		  Las imagenes deben ser cargadas por FTP.
		</p>
</div>
</div>
<div class="box1">
  <div class="Div1">
		 Carga Credito Cliente<br>
        <IMG SRC="http://socimagestion.com/Mejora/PHPExcel/credito.png" WIDTH=100 HEIGHT=100>
	<!--<form action="http://socimagestion.com/Mejora/PHPExcel/Clientes/subir.php" method="post" enctype="multipart/form-data">-->
	<form action="http://socimagestion.com/Mejora/PHPExcel/Clientes/subirC.php" method="post" enctype="multipart/form-data">
    <br>
	<input name="archivo"  class="button2" type="file" size="35" />
        <input name="enviar" class="button" type="submit" value="Subir" />
        <input name="action" type="hidden" value="upload" />
</form>
		<p>Recordar: <br>
		  Se debe cargar un archivo CSV para el credito de los clientes.<br>
		</p>
</div>
<br>
<div class="Div1">
		Inventario<br>
        <IMG SRC="http://socimagestion.com/Mejora/PHPExcel/inventario.png" WIDTH=100 HEIGHT=100>
	<form action="http://socimagestion.com/Mejora/PHPExcel/invVend/subir.php" method="post" enctype="multipart/form-data">
    <br>
	<input name="archivo"  class="button2" type="file" size="35" />
        <input name="enviar" class="button" type="submit" value="Subir" />
        <input name="action" type="hidden" value="upload" />
</form>
</div>
</div>


<style>
.button{text-decoration:none; text-align:center; 
 padding:11px 32px; 
 border:solid 1px #004F72; 
 -webkit-border-radius:4px;
 -moz-border-radius:4px; 
 border-radius: 4px; 
 font:10px Arial, Helvetica, sans-serif; 
 font-weight:bold; 
 color:#E5FFFF; 
 background-color:#3BA4C7; 
 background-image: -moz-linear-gradient(top, #3BA4C7 0%, #1982a5 100%); 
 background-image: -webkit-linear-gradient(top, #3BA4C7 0%, #1982a5 100%); 
 background-image: -o-linear-gradient(top, #3BA4C7 0%, #1982a5 100%); 
 background-image: -ms-linear-gradient(top, #3BA4C7 0% ,#1982a5 100%); 
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1982a5', endColorstr='#1982a5',GradientType=0 ); 
 background-image: linear-gradient(top, #3BA4C7 0% ,#1982a5 100%);   
 -webkit-box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff; 
 -moz-box-shadow: 0px 0px 2px #bababa,  inset 0px 0px 1px #ffffff;  
 box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff;  
  
  }.button:hover{
 padding:11px 32px; 
 border:solid 1px #004F72; 
 -webkit-border-radius:4px;
 -moz-border-radius:4px; 
 border-radius: 4px; 
 font:10px Arial, Helvetica, sans-serif; 
 font-weight:bold; 
 color:#E5FFFF; 
 background-color:#3BA4C7; 
 background-image: -moz-linear-gradient(top, #3BA4C7 0%, #23647a 100%); 
 background-image: -webkit-linear-gradient(top, #3BA4C7 0%, #23647a 100%); 
 background-image: -o-linear-gradient(top, #3BA4C7 0%, #23647a 100%); 
 background-image: -ms-linear-gradient(top, #3BA4C7 0% ,#23647a 100%); 
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#23647a', endColorstr='#23647a',GradientType=0 ); 
 background-image: linear-gradient(top, #3BA4C7 0% ,#23647a 100%);   
 -webkit-box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff; 
 -moz-box-shadow: 0px 0px 2px #bababa,  inset 0px 0px 1px #ffffff;  
 box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff;  
  
 }.button:active{
 padding:11px 32px; 
 border:solid 1px #004F72; 
 -webkit-border-radius:4px;
 -moz-border-radius:4px; 
 border-radius: 4px; 
 font:10px Arial, Helvetica, sans-serif; 
 font-weight:bold; 
 color:#E5FFFF; 
 background-color:#3BA4C7; 
 background-image: -moz-linear-gradient(top, #3BA4C7 0%, #1982a5 100%); 
 background-image: -webkit-linear-gradient(top, #3BA4C7 0%, #1982a5 100%); 
 background-image: -o-linear-gradient(top, #3BA4C7 0%, #1982a5 100%); 
 background-image: -ms-linear-gradient(top, #3BA4C7 0% ,#1982a5 100%); 
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1982a5', endColorstr='#1982a5',GradientType=0 ); 
 background-image: linear-gradient(top, #3BA4C7 0% ,#1982a5 100%);   
 -webkit-box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff; 
 -moz-box-shadow: 0px 0px 2px #bababa,  inset 0px 0px 1px #ffffff;  
 box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff;  
  
 } .button2{text-decoration:none; text-align:center; 
 padding:11px 32px; 
 border:solid 1px #004F72; 
 -webkit-border-radius:4px;
 -moz-border-radius:4px; 
 border-radius: 4px; 
 font:8px Arial, Helvetica, sans-serif; 
 font-weight:bold; 
 color:#E5FFFF; 
 background-color:#3BA4C7; 
 background-image: -moz-linear-gradient(top, #3BA4C7 0%, #1982A5 100%); 
 background-image: -webkit-linear-gradient(top, #3BA4C7 0%, #1982A5 100%); 
 background-image: -o-linear-gradient(top, #3BA4C7 0%, #1982A5 100%); 
 background-image: -ms-linear-gradient(top, #3BA4C7 0% ,#1982A5 100%); 
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1982A5', endColorstr='#1982A5',GradientType=0 ); 
 background-image: linear-gradient(top, #3BA4C7 0% ,#1982A5 100%);   
 -webkit-box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff; 
 -moz-box-shadow: 0px 0px 2px #bababa,  inset 0px 0px 1px #ffffff;  
 box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff;  
  
  }.button2:hover{
 padding:11px 32px; 
 border:solid 1px #004F72; 
 -webkit-border-radius:4px;
 -moz-border-radius:4px; 
 border-radius: 4px; 
 font:8px Arial, Helvetica, sans-serif; 
 font-weight:bold; 
 color:#E5FFFF; 
 background-color:#3BA4C7; 
 background-image: -moz-linear-gradient(top, #3BA4C7 0%, #1982A5 100%); 
 background-image: -webkit-linear-gradient(top, #3BA4C7 0%, #1982A5 100%); 
 background-image: -o-linear-gradient(top, #3BA4C7 0%, #1982A5 100%); 
 background-image: -ms-linear-gradient(top, #3BA4C7 0% ,#1982A5 100%); 
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1982A5', endColorstr='#1982A5',GradientType=0 ); 
 background-image: linear-gradient(top, #3BA4C7 0% ,#1982A5 100%);   
 -webkit-box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff; 
 -moz-box-shadow: 0px 0px 2px #bababa,  inset 0px 0px 1px #ffffff;  
 box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff;  
  
 }.button2:active{
 padding:11px 32px; 
 border:solid 1px #004F72; 
 -webkit-border-radius:4px;
 -moz-border-radius:4px; 
 border-radius: 4px; 
 font:8px Arial, Helvetica, sans-serif; 
 font-weight:bold; 
 color:#E5FFFF; 
 background-color:#3BA4C7; 
 background-image: -moz-linear-gradient(top, #3BA4C7 0%, #1982A5 100%); 
 background-image: -webkit-linear-gradient(top, #3BA4C7 0%, #1982A5 100%); 
 background-image: -o-linear-gradient(top, #3BA4C7 0%, #1982A5 100%); 
 background-image: -ms-linear-gradient(top, #3BA4C7 0% ,#1982A5 100%); 
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1982A5', endColorstr='#1982A5',GradientType=0 ); 
 background-image: linear-gradient(top, #3BA4C7 0% ,#1982A5 100%);   
 -webkit-box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff; 
 -moz-box-shadow: 0px 0px 2px #bababa,  inset 0px 0px 1px #ffffff;  
 box-shadow:0px 0px 2px #bababa, inset 0px 0px 1px #ffffff;  
 

 }
 .Div1{
 #  background-color:#3BA4C7; 
  
}
 .box1{
 float:left; 
 padding-top: 50px;
    padding-right: 100px;
    padding-bottom: 100px;
    padding-left: 100px;
  
}
</style>

<?php
   
}
else{ echo "<center> <h2> Error </h2> <br>Ud no tiene permiso para acceder al sistema </center>";}
?>


<center> <a href="http://socimagestion.com/Mejora/PHPExcel/logout.php">Salir</a> </center>
</body>
</html>