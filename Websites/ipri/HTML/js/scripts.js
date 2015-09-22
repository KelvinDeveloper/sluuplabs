var Url,
	date    = new Date(),
	Load 	= '.content';

$(document).scroll(function(){

	if( $(document).scrollTop() > 300 ){
		$('.android-header').css('box-shadow', '0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12)');
	} else {
		$('.android-header').css('box-shadow', '');
	}
});

function js(){
	$('.slide, .postImage').css({
		height: $(window).height() / 1.05
	});

	$('.postContent').css({
		minHeight: $(window).height() / 1.05
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

	$('.android-navigation-container a').click(function(){
		$('.android-navigation-container a.active').removeClass('active');
		$(this).addClass('active');
	});
});

$(document).resize(function(){
	js();
});

function navAjax( Href, Title, History ){

    $( Load ).load( Href, function(){
    	js();
    });
    if( History == true && Href != Url ){
        window.history.pushState( date, false, Href ); // Grava no Historico do navegador
        Url = Href;
    }

    if( Title ){
        document.title = Title;
    }

    // ga('send', 'pageview', Href); /* Google Analitycs */
}

window.onpopstate = function(event) {

    var Url   = window.location.pathname,
        Title = $('[href="' + Url + '"]').attr('title');
    navAjax( Url, Title, false );
};

$(document).on('click', '.openFunction', function(e){
	e.stopPropagation();
	navAjax( $(this).attr('href'), ( $(this).attr('title') != undefined ? $(this).attr('title') : false ), true );
	return false;
});