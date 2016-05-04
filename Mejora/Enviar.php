<?php
include'AttachMailer.php';
$Correo = $_GET["Correo"];
$Titulo = $_GET["Titulo"];
$Mensaje =$_GET["Mensaje"] ;
$Nombre = $_GET["Nombre"];



	 $mailer = new AttachMailer("sistema@socimagestion.com", "$Correo", "$Titulo", $Mensaje."\r\n El correo se ha generado el  : ".date("d-m-Y").";");
      $mailer->attachFile("http://socimagestion.com/Mejora/tcpdf/examples/$Nombre");     
     
   echo  $mailer->send() ? "<script> window.close() </script> ": "Problema al enviar";

?>