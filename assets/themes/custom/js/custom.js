$(document).ready(function(){ 
	$(window).scroll(function(){ 
		if ($(this).scrollTop() > 100) { 
			$('#scroll').fadeIn(); 
		} else { 
			$('#scroll').fadeOut(); 
		} 
	}); 
	$('#scroll').click(function(){ 
		$("html, body").animate({ scrollTop: 0 }, 600); 
		return false; 
	}); 

	$("html").niceScroll({
		cursoropacitymin:1,
		cursorcolor:"#000000",
		cursorborder:"1px solid #FFFFFF",
		background:"#ddd"
	});
});