<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Socimal" />
	<meta name="author" content="" />
	
	<title>Socima</title>
	

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.0.min.js"></script>

	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	
</head>
<body class="page-body  page-fade" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->	
	
	<div class="sidebar-menu">
		
			
		<header class="logo-env">
			
			<!-- logo -->
			<div class="logo">
				<a href="index.html">
					<img src="assets/images/logo.png" width="150" alt="" />
				</a>
			</div>
			
						<!-- logo collapse icon -->
						
			<div class="sidebar-collapse">
				<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
					<i class="entypo-menu"></i>
				</a>
			</div>
			
									
			
			<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			<div class="sidebar-mobile-menu visible-xs">
				<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
					<i class="entypo-menu"></i>
				</a>
			</div>
			
		</header>
				
		
		
				
		
				
		<ul id="main-menu" class="">
			<!-- add class "multiple-expanded" to allow multiple submenus to open -->
			<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
			<!-- Search Bar -->
			<li id="search">
				<form method="get" action="">
					<input type="text" name="q" class="search-input" placeholder="Buscar..."/>
					<button type="submit">
						<i class="entypo-search"></i>
					</button>
				</form>
			</li>
			<li>
				<a href="#">
					<i class="entypo-flow-tree"></i>
					<span>Productos</span>
				</a>
				<ul>
					<li>
						<a href="#">
							<i class="entypo-flow-line"></i>
							<span>REGALOS DECORATIVOS</span>
						</a>
						<ul>
							<li>
								<a href="#">
									<i class="entypo-flow-parallel"></i>
									<span>Casa</span>
								</a>
								<ul>
									<li>
										<a href="#">
											<i class="entypo-flow-cascade"></i>
											<span>Bambú Cuero y Madera</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="entypo-flow-cascade"></i>
											<span>Alcancías Cerámica</span>
										</a>
									</li>
                                    <li>
								<a href="#">
									<i class="entypo-flow-cascade"></i>
									<span>Aromaterapia y Difusores </span>
								</a>
							</li>
                            <li>
								<a href="#">
									<i class="entypo-flow-cascade"></i>
									<span>Artículos de Justicia </span>
								</a>
							</li>
                            <li>
								<a href="#">
									<i class="entypo-flow-cascade"></i>
									<span>Cajas Deco </span>
								</a>
							</li>
								</ul>
							</li>
						
						</ul>
					</li>
				</ul>
			</li>
		</ul>
				
	</div>
	<div class="main-content">
		
<div class="row">
	
	<!-- Profile Info and Notifications -->
	<div class="col-md-6 col-sm-8 clearfix">
		
		<ul class="user-info pull-left pull-none-xsm">
		
						<!-- Profile Info -->
			<li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->
				
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					Karima Maluk
				</a>
				
				<ul class="dropdown-menu">
					
					<!-- Reverse Caret -->
					<li class="caret"></li>
					
					<!-- Profile sub-links -->
					<li>
						<a href="extra-timeline.html">
							<i class="entypo-user"></i>
							Edit Profile
						</a>
					</li>
					
					<li>
						<a href="mailbox.html">
							<i class="entypo-mail"></i>
							Inbox
						</a>
					</li>
					
					<li>
						<a href="extra-calendar.html">
							<i class="entypo-calendar"></i>
							Calendar
						</a>
					</li>
					
					<li>
						<a href="#">
							<i class="entypo-clipboard"></i>
							Tasks
						</a>
					</li>
				</ul>
			</li>
		
		</ul>
				
		<ul class="user-info pull-left pull-right-xs pull-none-xsm">
			
			<!-- Raw Notifications -->
			<li class="notifications dropdown">
				
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="entypo-attention"></i>
					<span class="badge badge-info">3</span>
				</a>
				
				<ul class="dropdown-menu">
					<li class="top">
	<p class="small">
		<a href="#" class="pull-right">Ver Todos</a>
		Hay <strong>3</strong> productos sin stock hoy.
	</p>
</li>

<li>
	<ul class="dropdown-menu-list scroller">
		<li class="unread notification-success">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					<strong>136299 BAILARINAS MADERA</strong>
				</span>
				
				<span class="line small">
					17CM SURT. X12
				</span>
			</a>
		</li>
		
		<li class="unread notification-secondary">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					<strong>170813 PARAG.MINI FLUOR UV</strong>
				</span>
				
				<span class="line small">
					ALUM. CUBIERTA AL.PLUVIA
				</span>
			</a>
		</li>
		
		<li class="notification-primary">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					<strong>171097 PARAGUAS MADERA</strong>
				</span>
				
				<span class="line small">
					171097 AUT NARANJA
				</span>
			</a>
		</li>
		
		<li class="notification-danger">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">270273 CAJAS POLI/MONJE
				</span>
				
				<span class="line small">
PINTADOS/ 7,5CM  X12
				</span>
			</a>
		</li>
		
		<li class="notification-info">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					270319 ANGEL POLI BLANCO
				</span>
				
				<span class="line small">
					CON LED SURT
				</span>
			</a>
		</li>
		
		<li class="notification-warning">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					270825 PERCHA JAULA/AVE
				</span>
				
				<span class="line small">
					1 GANCHO 12X26CM
				</span>
			</a>
		</li>
	</ul>
</li>

<li class="external">
	<a href="#">Ver todos los productos agotados</a>
</li>				</ul>
				
			</li>
			
			<!-- Message Notifications -->
			<li class="notifications dropdown">
				
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="entypo-logout"></i>
					<span class="badge badge-secondary">2</span>
				</a>
				
				<ul class="dropdown-menu">
					<li>
	<ul class="dropdown-menu-list scroller">
		<li class="active">
			<a href="#">
				
				<span class="line">
					<strong>Falabella</strong>
					- 25/06/2014
				</span>
				
				<span class="line desc small">
					Pedido 985
				</span>
			</a>
		</li>
		
		<li class="active">
			<a href="#">
				
				<span class="line">
					<strong>Ripley</strong>
					- 25/06/2014
				</span>
				
				<span class="line desc small">
					Pedido 5233 
				</span>
			</a>
		</li>
		
		<li>
			<a href="#">
				
				<span class="line">
					Falabella
					- 25/06/2014
				</span>
				
				<span class="line desc small">
					Pedido 9653
				</span>
			</a>
		</li>
		
		<li>
			<a href="#">
				
				<span class="line">
					Juanita Perez
					- 25/06/2014
				</span>
				
				<span class="line desc small">
					Pedido 8653
				</span>
			</a>
		</li>
	</ul>
</li>

<li class="external">
	<a href="#">Ver todos los despachos</a>
</li>				</ul>
				
			</li>
			
			<!-- Task Notifications -->
			<li class="notifications dropdown">
				
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
					<i class="entypo-list"></i>
					<span class="badge badge-warning">3</span>
				</a>
				
				<ul class="dropdown-menu">
					<li class="top">
	<p>Hay 3 Productos nuevos</p>
</li>

<li>
	<ul class="dropdown-menu-list scroller">
		<li class="unread notification-success">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					<strong>136299 BAILARINAS MADERA</strong>
				</span>
				
				<span class="line small">
					17CM SURT. X12
				</span>
			</a>
		</li>
		
		<li class="unread notification-secondary">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					<strong>170813 PARAG.MINI FLUOR UV</strong>
				</span>
				
				<span class="line small">
					ALUM. CUBIERTA AL.PLUVIA
				</span>
			</a>
		</li>
		
		<li class="notification-primary">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					<strong>171097 PARAGUAS MADERA</strong>
				</span>
				
				<span class="line small">
					171097 AUT NARANJA
				</span>
			</a>
		</li>
		
		<li class="notification-danger">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">270273 CAJAS POLI/MONJE
				</span>
				
				<span class="line small">
PINTADOS/ 7,5CM  X12
				</span>
			</a>
		</li>
		
		<li class="notification-info">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					270319 ANGEL POLI BLANCO
				</span>
				
				<span class="line small">
					CON LED SURT
				</span>
			</a>
		</li>
		
		<li class="notification-warning">
			<a href="#">
				<i class="entypo-cancel-circled pull-right"></i>
				
				<span class="line">
					270825 PERCHA JAULA/AVE
				</span>
				
				<span class="line small">
					1 GANCHO 12X26CM
				</span>
			</a>
		</li>
	</ul>
</li>

<li class="external">
	<a href="#">Ver los últimos productos nuevos</a>
</li>				</ul>
				
			</li>
		
		</ul>
	
	</div>
	
	
	<!-- Raw Links -->
	<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		
			
			<ul class="list-inline links-list pull-right">
			
			<!-- Language Selector -->			<li class="dropdown language-selector">
				
				Configuración: &nbsp;
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
					<img src="assets/images/flag-uk.png" />
				</a>
				
				<ul class="dropdown-menu pull-right">
					<li>
						<a href="#">
							<span>Editar Mi Perfil</span>
						</a>
					</li>
					<li class="active">
						<a href="#">
							<span>Sincronizar</span>
						</a>
					</li>
				</ul>
				
			</li>
			
			<li class="sep"></li>
			
						
			<li>
				<a href="#" data-toggle="chat" data-animate="1" data-collapse-sidebar="1">
					<i class="entypo-chat"></i>
					Vista vendedor
				</a>
			</li>
			
			<li class="sep"></li>
			
			<li>
				<a href="extra-login.html">
					Salir <i class="entypo-logout right"></i>
				</a>
			</li>
		</ul>
		
	</div>
	
</div>

<hr />

<script type="text/javascript">
jQuery(document).ready(function($) 
{
	// Sample Toastr Notification
	setTimeout(function()
	{			
		var opts = {
			"closeButton": true,
			"debug": false,
			"positionClass": rtl() || public_vars.$pageContainer.hasClass('right-sidebar') ? "toast-top-left" : "toast-top-right",
			"toastClass": "black",
			"onclick": null,
			"showDuration": "300",
			"hideDuration": "1000",
			"timeOut": "5000",
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};

		
	}, 3000);
	
	
	// Sparkline Charts
	$('.inlinebar').sparkline('html', {type: 'bar', barColor: '#ff6264'} );
	$('.inlinebar-2').sparkline('html', {type: 'bar', barColor: '#445982'} );
	$('.inlinebar-3').sparkline('html', {type: 'bar', barColor: '#00b19d'} );
	$('.bar').sparkline([ [1,4], [2, 3], [3, 2], [4, 1] ], { type: 'bar' });
	$('.pie').sparkline('html', {type: 'pie',borderWidth: 0, sliceColors: ['#3d4554', '#ee4749','#00b19d']});
	$('.linechart').sparkline();
	$('.pageviews').sparkline('html', {type: 'bar', height: '30px', barColor: '#ff6264'} );
	$('.uniquevisitors').sparkline('html', {type: 'bar', height: '30px', barColor: '#00b19d'} );
	
	
	$(".monthly-sales").sparkline([1,2,3,5,6,7,2,3,3,4,3,5,7,2,4,3,5,4,5,6,3,2], {
		type: 'bar',
		barColor: '#485671',
		height: '80px',
		barWidth: 10,
		barSpacing: 2
	});	
	
	
	// JVector Maps
	var map = $("#map");
	
	map.vectorMap({
		map: 'europe_merc_en',
		zoomMin: '3',
		backgroundColor: '#383f47',
		focusOn: { x: 0.5, y: 0.8, scale: 3 }
	});		
	
			
	
	// Line Charts
	var line_chart_demo = $("#line-chart-demo");
	
	var line_chart = Morris.Line({
		element: 'line-chart-demo',
		data: [
			{ y: '2006', a: 100, b: 90 },
			{ y: '2007', a: 75,  b: 65 },
			{ y: '2008', a: 50,  b: 90 },
			{ y: '2009', a: 85,  b: 65 },
			{ y: '2010', a: 50,  b: 40 },
			{ y: '2011', a: 75,  b: 65 },
			{ y: '2012', a: 100, b: 90 }
		],
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Octubre 2013', 'Noviembre 2013'],
		redraw: true
	});
	
	line_chart_demo.parent().attr('style', '');
	
	
	// Donut Chart
	var donut_chart_demo = $("#donut-chart-demo");
	
	donut_chart_demo.parent().show();
	
	var donut_chart = Morris.Donut({
		element: 'donut-chart-demo',
		data: [
			{label: "Falabella", value: getRandomInt(10,50)},
			{label: "Ripley", value: getRandomInt(10,50)},
			{label: "Paris", value: getRandomInt(10,50)}
		],
		colors: ['#707f9b', '#455064', '#242d3c']
	});
	
	donut_chart_demo.parent().attr('style', '');
	
	
	// Area Chart
	var area_chart_demo = $("#area-chart-demo");
	
	area_chart_demo.parent().show();
	
	var area_chart = Morris.Area({
		element: 'area-chart-demo',
		data: [
			{ y: '2006', a: 100, b: 90 },
			{ y: '2007', a: 75,  b: 65 },
			{ y: '2008', a: 50,  b: 40 },
			{ y: '2009', a: 90,  b: 85 },
			{ y: '2010', a: 50,  b: 40 },
			{ y: '2011', a: 75,  b: 65 },
			{ y: '2012', a: 100, b: 90 }
		],
		xkey: 'y',
		ykeys: ['a', 'b'],
		labels: ['Meta', 'Venta'],
		lineColors: ['#303641', '#576277']
	});
	
	area_chart_demo.parent().attr('style', '');
	
	
	
	
	// Rickshaw
	var seriesData = [ [], [] ];
	
	var random = new Rickshaw.Fixtures.RandomData(50);
	
	for (var i = 0; i < 50; i++) 
	{
		random.addData(seriesData);
	}
	
	var graph = new Rickshaw.Graph( {
		element: document.getElementById("rickshaw-chart-demo"),
		height: 193,
		renderer: 'area',
		stroke: false,
		preserve: true,
		series: [{
				color: '#73c8ff',
				data: seriesData[0],
				name: 'Upload'
			}, {
				color: '#e0f2ff',
				data: seriesData[1],
				name: 'Download'
			}
		]
	} );
	
	graph.render();
	
	var hoverDetail = new Rickshaw.Graph.HoverDetail( {
		graph: graph,
		xFormatter: function(x) {
			return new Date(x * 1000).toString();
		}
	} );
	
	var legend = new Rickshaw.Graph.Legend( {
		graph: graph,
		element: document.getElementById('rickshaw-legend')
	} );
	
	var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight( {
		graph: graph,
		legend: legend
	} );
	
	setInterval( function() {
		random.removeData(seriesData);
		random.addData(seriesData);
		graph.update();
	
	}, 500 );
});


function getRandomInt(min, max) 
{
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
</script>

<button type="button" class="btn btn-default btn-icon icon-left">
						Panel de control de vendedor
						<i class="entypo-user-add"></i>
					</button><br/>
                    <br/>
                    <br/>
<div class="row">
	

	<div class="col-sm-3">
	
		<div class="tile-stats tile-green">
			<div class="icon"><i class="entypo-chart-bar"></i></div>
			<div class="num" data-start="0" data-end="10" data-postfix="" data-duration="1500" data-delay="600">0</div>
			
			<h3>Clientes activos</h3>
			<p>al día de hoy</p>
		</div>
		
	</div>


	<div class="col-sm-3">
	
		<div class="tile-stats tile-blue">
			<div class="icon"><i class="entypo-bag"></i></div>
			<div class="num" data-start="0" data-end="50" data-postfix="" data-duration="1500" data-delay="0">0</div>
			
			<h3>Pedidos</h3>
			<p>esté mes</p>
		</div>
		
	</div>
    
    <div class="col-sm-3">
	
		<div class="tile-stats tile-primary">
			<div class="icon"><i class="entypo-basket"></i></div>
			<div class="num" data-start="0" data-end="600" data-postfix="" data-duration="1500" data-delay="0">0</div>
			
			<h3>Productos</h3>
			<p>vendidos esté mes</p>
		</div>
		
	</div>
    
</div>

<br />

<div class="row">
	<div class="col-sm-8">
	
		<div class="panel panel-primary" id="charts_env">
		
			<div class="panel-heading">
				<div class="panel-title">Reportes</div>
				
				<div class="panel-options">
					<ul class="nav nav-tabs">
						<li class=""><a href="#area-chart" data-toggle="tab">Ventas Mensuales v/s año anterior</a></li>
						<li class="active"><a href="#line-chart" data-toggle="tab">Ventas Mensuales v/s Meta</a></li>
						<li class=""><a href="#pie-chart" data-toggle="tab">Participación Clientes</a></li>
					</ul>
				</div>
			</div>
	
			<div class="panel-body">
			
				<div class="tab-content">
				
					<div class="tab-pane" id="area-chart">							
						<div id="area-chart-demo" class="morrischart" style="height: 300px"></div>
					</div>
					
					<div class="tab-pane active" id="line-chart">
						<div id="line-chart-demo" class="morrischart" style="height: 300px"></div>
					</div>
					
					<div class="tab-pane" id="pie-chart">
						<div id="donut-chart-demo" class="morrischart" style="height: 300px;"></div>
					</div>
					
				</div>
				
			</div>

			
		</div>	

	</div>

</div>


<p><a href="index.php">Inicio</a></p>
<p>Vista Productos <br>
</p>
<p><a href="vendedor.php">Mi panel de control</a><br>
  <a href="editar-perfil.php">Editar Mi Perfil</a><br>
  Mis Metas<br>
  Top Clientes<br>
  <br>
  Lista de pedidos<br>
  Lista de clientes<br>
  Agregar cliente<br>
  Mapa clientes
  <br />
  
  
  <br />
  
  
  <script type="text/javascript">
	// Code used to add Todo Tasks
	jQuery(document).ready(function($)
	{
		var $todo_tasks = $("#todo_tasks");
		
		$todo_tasks.find('input[type="text"]').on('keydown', function(ev)
		{
			if(ev.keyCode == 13)
			{
				ev.preventDefault();
				
				if($.trim($(this).val()).length)
				{
					var $todo_entry = $('<li><div class="checkbox checkbox-replace color-white"><input type="checkbox" /><label>'+$(this).val()+'</label></div></li>');
					$(this).val('');
					
					$todo_entry.appendTo($todo_tasks.find('.todo-list'));
					$todo_entry.hide().slideDown('fast');
					replaceCheckboxes();
				}
			}
		});
	});
  </script>
</p>

<!-- Footer -->
<footer class="main">
	
		
	&copy; 2014 Desarrollado por <a href="http://odril.com" target="_blank">Odril</a></a>
	
</footer>	</div>
	
	
<div id="chat" class="fixed">
	
	<div class="chat-inner">
	
		
		<h2 class="chat-header">
			<a href="#" class="chat-close" data-animate="1"><i class="entypo-cancel"></i></a>
			
			<i class="entypo-users"></i>
			Vista Vendedor
		</h2>
		
        <div class="chat-group">
			<strong>Mis accesos</strong>
			
			<a href="vendedor.php"><span class="user-status is-offline"></span> <em>Mi panel de control</em></a>
            <a href="#"><span class="user-status is-offline"></span> <em>Editar Mi perfil</em></a>
			<a href="#"><span class="user-status is-offline"></span> <em>Mis Metas</em></a>
			<a href="#"><span class="user-status is-offline"></span> <em>Top Clientes</em></a>
		</div>
		
		<div class="chat-group">
			<strong>Clientes</strong>
			<a href="#"><span class="user-status is-online"></span> <em>Lista de pedidos</em></a>
			<a href="#"><span class="user-status is-online"></span> <em>Lista de clientes</em></a>
			<a href="#"><span class="user-status is-online"></span> <em>Agregar cliente</em></a>
            <a href="#"><span class="user-status is-online"></span> <em>Mapa clientes</em></a>
		</div>
	
	</div>
	
</div>
	</div>

<!-- Sample Modal (Default skin) -->
<div class="modal fade" id="sample-modal-dialog-1">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Widget Options - Default Modal</h4>
			</div>
			
			<div class="modal-body">
				<p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

<!-- Sample Modal (Skin inverted) -->
<div class="modal invert fade" id="sample-modal-dialog-2">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Widget Options - Inverted Skin Modal</h4>
			</div>
			
			<div class="modal-body">
				<p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
            <div class="col-sm-4">

		<div class="panel panel-primary">
			
		
			<div class="panel-body no-padding">
				<div id="rickshaw-chart-demo">
					<div id="rickshaw-legend"></div>
				</div>
			</div>
		</div>

	</div>
		</div>
	</div>
</div>


<!-- Sample Modal (Skin gray) -->
<div class="modal gray fade" id="sample-modal-dialog-3">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Widget Options - Gray Skin Modal</h4>
			</div>
			
			<div class="modal-body">
				<p>Now residence dashwoods she excellent you. Shade being under his bed her. Much read on as draw. Blessing for ignorant exercise any yourself unpacked. Pleasant horrible but confined day end marriage. Eagerness furniture set preserved far recommend. Did even but nor are most gave hope. Secure active living depend son repair day ladies now.</p>
			</div>
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>

	<link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">

	<!-- Bottom Scripts -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
	<script src="assets/js/jquery.sparkline.min.js"></script>
	<script src="assets/js/rickshaw/vendor/d3.v3.js"></script>
	<script src="assets/js/rickshaw/rickshaw.min.js"></script>
	<script src="assets/js/raphael-min.js"></script>
	<script src="assets/js/morris.min.js"></script>
	<script src="assets/js/toastr.js"></script>
	<script src="assets/js/neon-chat.js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>

</body>
</html>