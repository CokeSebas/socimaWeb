function menuNav(options){
	// Add "parent" class to appropriate dropdown
	$(options.container).find("li li > a").siblings("ul").prev().addClass("parent");

	if(options){
		if(!options.container){
			options.container = ".mainnav";
		}
		if(!options.eventtype){
			options.eventtype = "click";
		}
		if(!options.menuposition){
			options.menuposition = "left";
		}
		if(!options.slideout){
			options.slideout = "down";
		}
	}else{
		options = {container: ".mainnav", eventtype: "click", menuposition: "left", slideout: "down"};
	}

	// Add Dropdown arrow to parents of dropdowns
	$("<i class='icon icon-arrow-down-bold-round icon-size-small'></i>").appendTo($(options.container).find("li li > a").siblings("ul").prev());

	if(options.menuposition == "top"){
		$(options.container).find("span.main-menu-icon").each(function(){
			$(this).parent().siblings("ul").siblings("a").children("span.main-menu-icon").after("<i class='icon icon-arrow-down-bold-round icon-size-small'></i>");
		});
	}

	// Set style for menu
	$(options.container).css("position","relative");
	$(options.container).children("li").children("ul").css("position","absolute");

	if(options.eventtype == "click"){
		menuNavClick(options.container, options.menuposition);
	}else if(options.eventtype == "hover"){
		menuNavHover(options.container, options.menuposition);
	}

	$(options.container).find("a.top, a.parent").click(function(e){
		if($(this).siblings("ul").length){
			e.preventDefault();
		}
	});

	// Close Open Menus If User CLicks Outside the Menu (Works on both Left and Secondary Menus)
	$(document).on('click', function(event) {
		if (!$(event.target).closest(options.container).length){
			// Hide the menus if visible
			$(options.container).children("li").children("ul").animate({"top": "50px", "opacity":"hide"},200, "linear",function(){
				$(options.container).find("li ul").removeAttr("style").removeClass("sub-menu-open");
				$(options.container).children("li").removeAttr("style").removeClass("menu-open");
			});
		}
	});
}

function menuNavClick(menuBlock, menuposition){
	// Display Top Menu
	$(menuBlock).children("li").children("a").on("click", function(){
		if($(this).parent().hasClass("menu-open")){
			menuNavClickClose($(this), menuposition);
		}else{
			menuNavClickOpen($(this), menuposition);
		}
	});

	// Display Submenus
	$(menuBlock).children("li").children("ul").find("li a").on("click", function(){
		if($(this).next("ul").hasClass("sub-menu-open")){
			menuNavSubClickClose($(this), menuposition);
		}else{
			menuNavSubClickOpen($(this), menuposition);
		}
	});
}

function menuNavClickOpen(thisObj, menuposition){
	if(menuposition == "left"){
		thisObj.parent().parent().find("li.menu-open > ul").animate({"top": "50px", "opacity":"hide"},200, "linear",function(){
			$(this).removeAttr("style");
			$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
			$(this).parent().removeClass("menu-open");
		});
		thisObj.next("ul").animate({"top": "0", "opacity":"show"},200, "linear",function(){
			thisObj.parent().addClass("menu-open");
		});
	}else if(menuposition == "top"){
		thisObj.parent().parent().find("li.menu-open > ul").animate({"top": "62px", "opacity":"hide"},200, "linear",function(){
			$(this).removeAttr("style");
			$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
			$(this).parent().removeClass("menu-open");
		});
		thisObj.next("ul").animate({"top": "42px", "opacity":"show"},200, "linear",function(){
			thisObj.parent().addClass("menu-open");
		});
	}else if(menuposition == "right"){

	}
}

function menuNavClickClose(thisObj, menuposition){
	if(menuposition == "left"){
		thisObj.next("ul").animate({"top": "50px", "opacity":"hide"},200, "linear",function(){
			$(this).removeAttr("style");
			$(this).parent().removeClass("menu-open");
			$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
		});
	}else if(menuposition == "top"){
		thisObj.next("ul").animate({"top": "62px", "opacity":"hide"},200, "linear",function(){
			$(this).removeAttr("style");
			$(this).parent().removeClass("menu-open");
			$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
		});
	}else if(menuposition == "right"){

	}
}

function menuNavSubClickOpen(thisObj, menuposition){
	if(menuposition == "left"){
		thisObj.parent().siblings("li").find("ul").slideUp(function(){
			$(this).removeAttr("style").removeClass("sub-menu-open");
		});
		thisObj.next("ul").slideDown().addClass("sub-menu-open");
	}else if(menuposition == "top"){
		thisObj.parent().siblings().removeAttr("style");
		thisObj.parent().siblings().find("ul").removeAttr("style").removeClass("sub-menu-open");
		thisObj.parent().siblings().find("a.parent ~ ul.sub-menu-open").animate({"top": "39px", "opacity":"hide"},200, "linear");
		if(thisObj.siblings("ul").size() > 0){
			thisObj.parent().css("position","relative");
			thisObj.next("ul").animate({"top": "29px", "left": "158px", "opacity":"show"},200, "linear",function(){
				$(this).addClass("sub-menu-open");
			});
		}
	}
}

function menuNavSubClickClose(thisObj, menuposition){
	if(menuposition == "left"){
		thisObj.next("ul").slideUp().removeClass("sub-menu-open");
		thisObj.next("ul").find("ul").slideUp(function(){
			$(this).removeAttr("style").removeClass("sub-menu-open");
		});
	}else if(menuposition == "top"){
		thisObj.next("ul").animate({"top": "39px", "opacity":"hide"},200, "linear",function(){
			$(this).removeAttr("style").removeClass("sub-menu-open");
			$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
		});
	}
}

/* Hover Functions */
function menuNavHover(menuBlock, menuposition){
	// Display Top Menu
	$(menuBlock).children("li").mouseenter(function(){
		menuNavMouseEnter($(this), menuposition);
	}).mouseleave(function(){
		menuNavMouseLeave($(this), menuposition);
	});

	// Display Submenus
	$(menuBlock).children("li").children("ul").find("li a").on("click", function(){
		if($(this).next("ul").hasClass("sub-menu-open")){
			menuNavSubClickClose($(this), menuposition);
		}else{
			menuNavSubClickOpen($(this), menuposition);
		}
	});
}

function  menuNavMouseEnter(thisObj, menuposition){
	if(menuposition == "left"){
		thisObj.children("ul").animate({"top": "0", "opacity":"show"},200, "linear",function(){
			thisObj.parent("li").addClass("menu-open");
		});
	}else if(menuposition == "top"){
		thisObj.children("ul").animate({"top": "42px", "opacity":"show"},200, "linear",function(){
			thisObj.parent("li").addClass("menu-open");
		});
	}
}

function  menuNavMouseLeave(thisObj, menuposition){
	if(menuposition == "left"){
		thisObj.children("ul").animate({"top": "50px", "opacity":"hide"},200, "linear",function(){
			$(this).removeClass("menu-open");
			$(this).removeAttr("style");
			$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
		});
	}else if(menuposition == "top"){
		thisObj.children("ul").animate({"top": "62px", "opacity":"hide"},200, "linear",function(){
			$(this).removeClass("menu-open");
			$(this).removeAttr("style");
			$(this).find("ul").removeAttr("style").removeClass("sub-menu-open");
		});
	}
}

// function menuSubMouseEnter(thisObj, menuposition){
// 	if(menuposition == "left"){
// 		thisObj.children("ul").slideDown().addClass("sub-menu-open");
// 	}else if(menuposition == "top"){
// 		if(thisObj.children("ul").size() > 0){
// 			thisObj.css("position", "relative");
// 			thisObj.children("ul").addClass("sub-menu-open").css("position", "absolute").animate({"top": "29px", "left": "158px", "opacity":"show"},200, "linear",function(){
// 				$(this).addClass("sub-menu-open");
// 			});
// 		}
// 	}
// }

// function menuSubMouseLeave(thisObj, menuposition){
// 	if(menuposition == "left"){
// 		thisObj.children("ul").slideUp(function(){
// 			$(this).removeAttr("style").removeClass("sub-menu-open");
// 		});
// 	}else if(menuposition == "top"){
// 		thisObj.children("ul").animate({"top": "50px", "opacity":"hide"},200, "linear",function(){
// 			$(this).removeClass("menu-open");
// 			$(this).removeAttr("style");
// 			$(this).parent().removeAttr("style");
// 		});
// 	}
// }
