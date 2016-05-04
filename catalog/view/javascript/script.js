(function($) {
	$(document).ready(function() {
		$('#cssmenu > ul > li > a').click(function(){
			$('#cssmenu li').removeClass('active');
			$(this).closest('li').addClass('active');	
			var checkElement = $(this).next();
				if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
					$(this).closest('li').removeClass('active');
					checkElement.slideUp('normal');
					$('ul > li img').removeClass('rotator'); 
					$(this).find('img').removeClass('rotator-none'); 					
				}
				if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
					$('#cssmenu ul ul:visible').slideUp('normal');
					checkElement.slideDown('normal');
					$('ul > li img').removeClass('rotator'); 
					$(this).find('img').addClass('rotator'); 
				}
				if($(this).closest('li').find('ul').children().length == 0) {
					return true;
				} else {
					return false;	
				}		
		});
		
		$('.stepson > a').click(function(){
			$('.stepson').removeClass('active');
			$(this).closest('li').addClass('active');	
			
			var checkElement = $(this).next();
				if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
					$(this).closest('li').removeClass('active');
					checkElement.slideUp('normal');
					
				}
				if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
					$('.stepson ul ul:visible').slideUp('normal');
					checkElement.slideDown('normal');
					
				}
				if($(this).closest('li').find('ul').children().length == 0) {
					return true;
				} else {
					return false;	
				}		
			
				//$('.stepson ul').css('display','block'); 
				
		});

	});
})(jQuery);