$(document).scroll(function(){

	if( $(document).scrollTop() > 300 ){
		$('.android-header').css('box-shadow', '0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12)');
	} else {
		$('.android-header').css('box-shadow', '');
	}
});

function js(){
	$('.slide').css({
		height: $(window).height() / 1.05
	});
}

$(document).ready(function(){
	js();

	$(document).on('mouseenter', '.slide li', function(){ 
		$(this).addClass('hover');
	});

	$(document).on('mouseleave', '.slide li', function(){ 
		$(this).removeClass('hover');
	});
});

$(document).resize(function(){
	js()
});