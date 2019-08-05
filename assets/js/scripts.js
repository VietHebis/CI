$(document).ready(function(){
	var nav=$(".navbar navbar-default");
	var banner=$(".header").has('img');
	var pos=nav.position();
	$(window).scroll(function(){
		var windowpos=$(window).scrollTop();
		if(windowpos>=banner.outerHeight()){
			alert();return false;
			nav.addClass('fixed');
		}else{
			nav.removeClass('fixed');
		}
		});
	
});