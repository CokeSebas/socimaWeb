<html>
<?php echo $header; ?>
<style>
#keyworddiv {
	width		:  50%;
	height		: 400px;
	font-size	: 11px;
	float		: left;
}

#productdiv {
	width		: 75%;
	height		: 400px;
	font-size	: 11px;
	float		: left;
}

</style>

<script type="text/javascript" src="view/javascript/amcharts.js"></script>
<script type="text/javascript" src="view/javascript/pie.js"></script>
<script type="text/javascript" src="view/javascript/none.js"></script>
<?php //echo json_encode($get_keyword_chart);
echo '<br>';
//echo json_encode($get_product_chart);
 ?>
<script>

var jsonKeywords = <?php echo json_encode($get_keyword_chart); ?> ;


var chart = AmCharts.makeChart("keyworddiv", {
    "type": "pie",
	"theme": "none",
	"legend": {
        "markerType": "circle",
        "position": "right",
		"marginRight": 40,		
		"autoMargins": false
    },
    "dataProvider": jsonKeywords,
    "valueField": "num_search",
    "titleField": "keyword",
	 "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
    "exportConfig": {
        "menuTop":"0px",
        "menuItems": [{
      icon: '/lib/3/images/export.png',
      format: 'png'	  
      }]  
	}
});


var jsonProducts = <?php echo json_encode($get_product_chart); ?> ;
var chart1 = AmCharts.makeChart("productdiv", {
    "type": "pie",
	"theme": "none",
	"legend": {
        "markerType": "circle",
        "position": "right",
		"marginRight": 40,		
		"autoMargins": false
    },
    "dataProvider": jsonProducts,
    "valueField": "num",
    "titleField": "product",
	 "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
    "exportConfig": {
        "menuTop":"0px",
        "menuItems": [{
      icon: '/lib/3/images/export.png',
      format: 'png'	  
      }]  
	}
});

</script>
<body>

<div>
 <p ><h1 style="display:inline;">Top Searched Keywords</h1> <a onclick="location = '<?php echo $more_k_chart; ?>';">(Full List Here)</a></p>
<table width="100%">
<tr>
<td>
<div id="keyworddiv"></div>
</td></tr>
<!-- <tr><td><a onclick="location = '<?php echo $more_k_chart; ?>';"><span><?php echo "more"; ?></span></a></td></tr>  -->

</table>


<h1 style="display:inline;" >Top Searched Products</h1>  <a onclick="location = '<?php echo $more_p_chart; ?>';">(Full List Here)</a> 
<table width="100%">
<tr>

<td>
<div id="productdiv"></div> 
</td></tr>
<!-- <tr><td><a onclick="location = '<?php echo $more_p_chart; ?>';"><span><?php echo "more"; ?></span></a></td></tr> -->

</table>
</div>

</body>
<?php //echo $footer;?>
</html>