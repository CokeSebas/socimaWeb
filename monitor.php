<html> 
<head> 

<meta name="Author-Personal" content="Sintetix, e-mail:cs@sintetix.com"> 

<title></title> 

<script language="JavaScript"> 
<!-- 
var paginas = new Array; 

paginas[0]="http://socimagestion.com/index.php?route=product/product&product_id=10980";
paginas[1]="http://socimagestion.com/index.php?route=product/product&product_id=276490";

var tam = paginas.length; 

function cambio(i) 
{ 
var page = 0; 
page = i; 
if (page < tam){ 
window.parent.centro.location=paginas[page]; 
} 
else{ 
page = 0; 
window.parent.centro.location=paginas[page]; 
} 
page++; 
//	 alert(page); 
// 100 es el tiempo en milisegundos ke tarda en cambiar la pagina 
setTimeout("cambio("+page+")",1000); 

} 
//--> 

</script> 

</head> 
<body onLoad="cambio(0);"> 

</body> 
</html>