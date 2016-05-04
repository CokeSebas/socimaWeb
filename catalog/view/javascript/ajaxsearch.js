var wait; 
$(document).ready(function() {
 	 
	$("input[name='search']").after('<div id="smartsearchdiv" style="background:white;width:290px;position:absolute;"></div>').blur(function() {
		clearTimeout(wait);
		wait = setTimeout(hideSmartSearch, 200);
	}).keydown(function(e) {
		if ($("input[name='search']").length && e.which == 38) {
			e.preventDefault();
			return false;
		}
	}).keyup(function(e) {
		if (!$("input[name='search']").val()) {
			$('#smartsearchdiv').css('display', 'none');
		}
		
		var searchValue = $("input[name='search']").val() ;
var queryLen = searchValue.length;

	//	set options
		//if ($('#searchin').val().replace(/^\s+|\s+$/g, '') && (e.which == 8 || (47 < e.which && e.which < 112) || e.which > 185)) {
		 if (searchValue.replace(/^\s+|\s+$/g, '') && (e.which == 8 || (47 < e.which && e.which < 112) || e.which > 185)) {
		    if(queryLen >0){
			showSmartSearch();
			} else{
			hideSmartSearch();
			
			}
			
			
		}
		if ($('#smartsearchdiv li').length && (e.which == 38 || e.which == 40)) {
		}
	}).blur(function(){
	});
});
  
function showSmartSearch() {

$.ajax( { 
url: 'index.php?route=product/ajaxsearch&search=' + $("input[name='search']").val(),
type: 'GET',


success: function(data) {
$('#smartsearchdiv').css('display', 'block'); 

//newData = data.getElementById('ajaxdiv').innerHTML;
var html = '';
 $('#smartsearchdiv').html(data) ;
}
} 
); 
}

  
function hideSmartSearch() {

$('#smartsearchdiv').css('display', 'none'); 
} 



