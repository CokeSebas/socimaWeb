$(document).ready(function(){

	/*

	General JS

	*/

	/* Change Header Icon Based on Color Profile - Start */

	var getColorProfile = $("body").data("color-profile");
	if(getColorProfile){
		var colorProfile = getColorProfile.split("-");
		var getHeaderImage = $("h1 img").attr("src");

		if(getHeaderImage){
			var splitHeaderImage = getHeaderImage.split("/");

			if(splitHeaderImage[3] == "base5builder_circloid"){
				if(colorProfile[0] != "default"){
					$("h1 img").attr("src", splitHeaderImage[0] + "/" + splitHeaderImage[1] + "/" + splitHeaderImage[2] + "/" + splitHeaderImage[3] + "/" + "color_profiles/" + colorProfile[0] + "_" + colorProfile[1] + "/" + splitHeaderImage[4]);
				}
			}
		}
	}

	/* Change Header Icon Based on Color Profile - End */

	/* Secondary Menu - Toggle Effects - Start */

	$(".secondary-menu > ul > li#store > a").click(function(e){
		// Check if menu is open or close
		var menuOpen = $(".secondary-menu > ul ul").is(':visible');
		if(!menuOpen){
			// Open the dropdown menu and add the "menu-open" class
			$(this).parent().addClass("menu-open");
			$(this).next("ul").removeAttr("style").animate({"top": "38px", "opacity":"show"},200);
		}else{
			// Close the dropdown menu and remove the "menu-open" class
			$(this).next("ul").animate({"top": "50px", "opacity":"hide"},200);
			$(this).parent().removeClass("menu-open");
		}
		e.stopPropagation();
	});

	/* Secondary Menu - Toggle Effects - End */


	/* Stock Alert (Header) - Tooltip - Start */

	$(".stock-alert-header .stock-alert a").hover(function(e){
		// Shows the title on hover
		$(this).next("div.alert-label").removeAttr("style").animate({"bottom": "-32px", "opacity":"show"},200);
		e.stopPropagation();
	},function(e){
		// Hides the title on blur
		$(this).next("div.alert-label").animate({"bottom": "-100px", "opacity":"hide"},200);
		e.stopPropagation();
	});

	/* Stock Alert (Header) - Tooltip - End */


	/* Main Nav - Highlight Active Menu Item - Start */

	// This function is copied straight from the default OpenCart theme
	function getURLVar(urlVarName) {
		var urlHalves = String(document.location).toLowerCase().split('?');
		var urlVarValue = '';

		if (urlHalves[1]) {
			var urlVars = urlHalves[1].split('&');

			for (var i = 0; i <= (urlVars.length); i++) {
				if (urlVars[i]) {
					var urlVarPair = urlVars[i].split('=');

					if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
						urlVarValue = urlVarPair[1];
					}
				}
			}
		}
		return urlVarValue;
	} 

	route = getURLVar('route');
	
	// Get Current URL Route
	if (!route) {
		$('#dashboard').addClass('selected');
	} else {
		part = route.split('/');
		
		url = part[0];
		
		if (part[1]) {
			url += '/' + part[1];
		}
		
		$('a[href*=\'' + url + '\']').parents('li[id]').addClass('selected');

		// Add Class To Right Column Based On Active Menu
		$("#right-column").addClass(part[0]);
	}

	// Mobile Device Menu Control
	
	$("#menu-control").click(function(e){
		var leftMenuOpen = $("#left-column").is(":visible");

		if(leftMenuOpen){
			// Else, if opened, close it
			$("#left-column").animate({"left": "-110px", "opacity":"hide"},300, function(){
				$("#left-column").removeAttr("style");
				$(".menu-control-outer").removeClass("opened");
			});
		}else{
			// If menu closed, then slide open
			$("#left-column").animate({"left": "0", "opacity":"show"},300);
			$(".menu-control-outer").addClass("opened");
		}
		e.stopPropagation();
	});

	/* Main Nav - Highlight Active Menu Item - End */


	/* Main/Left Menu - Toggle Effects - Start */

	var menuEventType = $("body").data("menu-event-type");

	if((menuEventType != "hover") || (menuEventType != "click")){
		menuEventType = "click";
	}
	
	menuNav({
		container: ".mainnav",
		eventtype: menuEventType
	});

	/* Main/Left Menu - Toggle Effects - End */


	/* Close Open Secondary Menu If User CLicks Outside the Menu - Start */

	$('html').click(function() {
		// Hide the menus if visible
		$(".secondary-menu > ul ul").animate({"top": "50px", "opacity":"hide"},200, function(){
			$(this).removeAttr("style");
			$(this).parent().removeClass("menu-open");
		});
	});

	/* Close Open Secondary Menu If User CLicks Outside the Menu - End */


	/* Close Success/Warning Messages - Start */

	$(".success, .warning").live("click", function(){
		$(".success, .warning").remove();
	});

	setTimeout(function(){
		$(".success").fadeOut(300);
	}, 5500);

	setTimeout(function(){
		$(".warning").fadeOut(300);
	}, 6500);

	/* Close Success/Warning Messages - End */


	/* Horizontal Scrolling For Tables For Small Screens - Start */
	var boxWidth = $(".box").width();
	var tableListWidth = $("table.list").width();
	var formTableWidth = $("form#form").height();

	if(tableListWidth > boxWidth){
		if(formTableWidth > 0){
			$("form#form").css("overflow", "auto");
		}else{
			$("table.list").parent().css("overflow", "auto");
		}
	}else{
		if(formTableWidth > 0){
			$("form#form").css("overflow", "auto");
		}else{
			$("table.list").parent().css("overflow", "auto");
		}
	}

	// Function To Prevent Multiple Calls While Browser Is Resizing Or Orientation Is Changed (Prevents a glitching effect)

	var waitForFinalEvent = (function () {
		var timers = {};
		return function (callback, ms, uniqueId) {
			if (!uniqueId) {
				uniqueId = "Don't call this twice without a uniqueId";
			}
			if (timers[uniqueId]) {
				clearTimeout (timers[uniqueId]);
			}
			timers[uniqueId] = setTimeout(callback, ms);
		};
	})();

	function generateUniqueString(){
		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

		for( var i=0; i < 5; i++ )
			text += possible.charAt(Math.floor(Math.random() * possible.length));

		return text;
	}
	
	// Actual Window Resize Code
	var currentWindowWidth = $(window).width();

	$(window).resize(function () {
		waitForFinalEvent(function(){

			if($(this).width() != currentWindowWidth){

				currentWindowWidth = $(window).width();

				var boxWidth = $(".box").width();
				var tableListWidth = $("table.list").width();
				var formTableWidth = $("form#form").height();

				if(tableListWidth > boxWidth){
					if(formTableWidth > 0){
						$("form#form").css("overflow", "auto");
					}else{
						$("table.list").parent().css("overflow", "auto");
					}
				}else{
					if(formTableWidth > 0){
						$("form#form").css("overflow", "auto");
					}else{
						$("table.list").parent().css("overflow", "auto");
					}
				}

				// Close Menu On Mobile Device
				$("#left-column").removeAttr("style");
				$(".menu-control-outer").removeClass("opened");
			}

		}, 500, generateUniqueString());
	});
	/* Horizontal Scrolling For Tables For Small Screens - End */
	

	/* Tabs - Start */

	// If current page is Kuler or Journal1, dont use Tabs function
	var customPage = ["shoppica2","journal_banner","journal_bgslider","journal_cp","journal_filter","journal_gallery","journal_menu","journal_product_slider","journal_product_tabs","journal_rev_slider","journal_slider","kuler_accordion","kuler_advanced_html","kuler_css3_slideshow","kuler_filter","kuler_finder","kuler_layer_slider","kuler_menu","kuler_newsletter","kuler_sitetools","kuler_slides","kuler_social_icons","kuler_tabs","kulercp"];

	var customPageName = route.split("/");

	var isCustomPage = customPage.indexOf(customPageName[1]);

	if((isCustomPage == "-1") || (isCustomPage == false)){
		$('#tabs a').tabs();
	}

	/* Tabs - End */


	/* Add Class To Save/Insert/Delete... etc - Start */

	// Form Control Buttons - Remove/Add Attribute...

	// This adds "btn" class on page load
	$("form a.button").addClass("btn");

	// This re-adds "btn" class to buttons created AFTER page load
	$("form a.button").click(function(){
		$("form a.button").removeClass("btn");
		$("form a.button").addClass("btn");
	});


	// Main Control Buttons - Save/Insert/Delete...

	var buttonExists = $(".buttons .button").height();

	if(buttonExists > 0){

		function getURLVars(urlVarName, getActionURL) {
			
			if(getActionURL == undefined){
				var getActionURL = '?';
			}
			var urlHalves = getActionURL.toLowerCase().split('?');
			var urlVarValue = '';

			if (urlHalves[1]) {
				var urlVars = urlHalves[1].split('&');

				for (var i = 0; i <= (urlVars.length); i++) {
					if (urlVars[i]) {
						var urlVarPair = urlVars[i].split('=');

						if (urlVarPair[0] && urlVarPair[0] == urlVarName.toLowerCase()) {
							urlVarValue = urlVarPair[1].split("/");
						}
					}
				}
			}

			return urlVarValue;
		}

		$(".buttons .button").each(function(){

			// first get the "href", then break it up to find the "key" term, like "insert", "delete", etc

			var getHrefFull = $(this).attr("href");

			var getAttrFull = $(this).attr("onclick");

			var getCancelButton = getURLVars("route",getHrefFull);

			if(getHrefFull != undefined){

				if((getHrefFull.indexOf("/insert&") > 0) || (getHrefFull.indexOf("/clear&") > 0)){

					$(this).addClass("btn btn-primary");

				}else if(getHrefFull.indexOf("/copy&") > 0){

					$(this).addClass("btn btn-primary");

				}else if((getCancelButton[0] && !getCancelButton[2]) || (getHrefFull.indexOf("/cancel&") > 0)){

					$(this).addClass("btn btn-danger");

				}else if(getHrefFull.indexOf("/delete&") > 0){

					$(this).addClass("btn btn-danger");

				}else if(getHrefFull.indexOf("/repair&") > 0){

					$(this).addClass("btn btn-primary");

				}

			}else{

				var getFormAction = $("#form").attr("action");
				var formAction = getURLVars("route",getFormAction);

				// Strip jargon from "onclick" data
				var toRemove = "location = '";
				var cleanAttr = getAttrFull.replace(toRemove,'');

				var toRemove = "';";
				var getAttr = cleanAttr.replace(toRemove,'');

				var getCancelButton = getURLVars("route",getHrefFull);

				// check if attr contains certain keywords
				if(getAttr.indexOf("/insert&") > 0){

					$(this).addClass("btn btn-primary");

				}else if(((getAttr.indexOf("('#form').submit()") > 0) && (formAction[2] == 'delete')) || ((getAttr.indexOf("('form').submit()") > 0) && (formAction[2] == 'delete'))){

					if(getAttr.indexOf("/copy&") > 0){
						$(this).addClass("btn btn-primary");
					}else{
						$(this).addClass("btn btn-danger");
					}

				}else if(((getAttr.indexOf("('#form').submit()") > 0) && (formAction[2] == 'insert')) || ((getAttr.indexOf("('#form').submit()") > 0) && (formAction[2] == 'update')) || ((getAttr.indexOf("('#form').submit()") > 0) && (formAction[2] == 'save')) || ((getAttr.indexOf("('#form').submit()") > 0) && (!formAction[2])) || (getAttr.indexOf("/approve&") > 0) ){

					if(getAttr.indexOf("/delete&") > 0){
						$(this).addClass("btn btn-danger");
					}else if(getAttr.indexOf("/invoice&") > 0){
						$(this).addClass("btn btn-primary");
					}else{
						$(this).addClass("btn btn-success");
					}

				}else if((getCancelButton[0] && !getCancelButton[2]) || (getAttr.indexOf("/cancel&") > 0)){
					$(this).addClass("btn btn-delete");
				}else if(getAttr.indexOf("/copy&") > 0){
					$(this).removeClass("btn-danger");
					$(this).addClass("btn-primary");

				}else if(getAttr.indexOf("/delete&") > 0){
					$(this).addClass("btn btn-danger");
				}else if(getAttr.indexOf("('#restore').submit()") > 0){
					$(this).addClass("btn btn-primary");
				}else if(getAttr.indexOf("('#backup').submit()") > 0){
					$(this).addClass("btn btn-primary");
				}
			}

		});
	}

	/* Add Class To Save/Insert/Delete... etc - End */




	/* Add/Remove Custom Admin Page - Start */

	// Add Custom Admin Page
	$("#add-custom-admin-page a").click(function(e){
		route = encodeURI(getURLVar('route'));

		$.ajax({
			type: 'GET',
			url: 'index.php?route=common/admin_circloid_dashboard_editor/saveCustomAdminPage&token=' + QueryString.token + '&adminpage=' + route,
			dataType: 'json',
			beforeSend: function(){
				$(".dashboard-editor-color-profile .loading").show();
			},
			error: function(){
				var textAjaxError = $(".ajax-error").text();
				$('<div class="warning hidden">' + textAjaxError + '</div>').appendTo(".dashboard-editor-content").css("visibility", "visible").fadeIn(300);
				$(".dashboard-editor-color-profile .loading").hide();
			},
			success: function(json) {

				$('.success').remove();
				$('.warning').remove();

				$(".dashboard-editor-color-profile .loading").hide();

				if(json.saved_custom_admin_page){
					// console.log("saved");
					location.reload();
				}else{
					// console.log("not");
					location.reload();
				}
			}
		});

		e.preventDefault();
	});
	
	// Remove Custom Admin Page
	$("#remove-custom-admin-page a").click(function(e){
		route = encodeURI(getURLVar('route'));

		// console.log(route);

		$.ajax({
			type: 'GET',
			url: 'index.php?route=common/admin_circloid_dashboard_editor/removeCustomAdminPage&token=' + QueryString.token + '&adminpage=' + route,
			dataType: 'json',
			beforeSend: function(){
				$(".dashboard-editor-color-profile .loading").show();
			},
			error: function(){
				var textAjaxError = $(".ajax-error").text();
				$('<div class="warning hidden">' + textAjaxError + '</div>').appendTo(".dashboard-editor-content").css("visibility", "visible").fadeIn(300);
				$(".dashboard-editor-color-profile .loading").hide();
			},
			success: function(json) {

				$('.success').remove();
				$('.warning').remove();

				$(".dashboard-editor-color-profile .loading").hide();

				if(json.removed_custom_admin_page){
					location.reload();
				}else{
					location.reload();
				}
			}
		});

		e.preventDefault();
	});

	/* Add/Remove Custom Admin Page - End */


	/* Get URL Parameter - Start */

	var QueryString = function () {
		// This function is anonymous, is executed immediately and 
		// the return value is assigned to QueryString!
		var query_string = {};
		var query = window.location.search.substring(1);
		var vars = query.split("&");
		for (var i=0;i<vars.length;i++) {
			var pair = vars[i].split("=");
			// If first entry with this name
			if (typeof query_string[pair[0]] === "undefined") {
				query_string[pair[0]] = pair[1];
				// If second entry with this name
			} else if (typeof query_string[pair[0]] === "string") {
				var arr = [ query_string[pair[0]], pair[1] ];
				query_string[pair[0]] = arr;
				// If third or later entry with this name
			} else {
				query_string[pair[0]].push(pair[1]);
			}
		} 
		return query_string;
	} ();

	/* Get URL Parameter - End */

});
