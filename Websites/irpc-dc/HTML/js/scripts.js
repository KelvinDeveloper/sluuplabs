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
	
	$('.slide').css({
		height: $(window).height() / 1.3
	});

	$('.slide li.slide-1').css({
		width: $(window).width() / 2.5
	});

	$('.slide li.slide-2').css({
		width: $(window).width() / 3.5
	});

	$('.slide li.slide-3, .slide li.slide-4').css({
		width: $(window).width() / 3.2
	});

	$('.postImage').css({
		height: $(window).height() / 2
	});

	$('.postContent').css({
		minHeight: $(window).height() / 1.05,
		marginTop: ( $(window).height() / 2 ) + 100
	});

	$('.content').css({
		minHeight: $(window).height() - ( 144 + $('.mdl-mini-footer').height() )
	});
}


function Alert( thisClass, dataContent, thisWidth ){
    clearTimeout( setTimeStatus );
    $('#infoStatus').stop().remove();
    $('body').prepend('<div id="infoStatus" class="' + ( thisClass != undefined ? thisClass : false ) + '" style="' + ( thisWidth != undefined ? 'width:' + thisWidth + '; left: 50%; margin-left: -' + thisWidth / 2 : false ) + '">' + dataContent + '</div>');
    $('#infoStatus').fadeIn( 100 );
    $('#infoStatus').css('top', '80px');

    var setTimeStatus 
        setTimeout(function(){
            $('#infoStatus').fadeOut( 100 );
            $('#infoStatus').css('top', '-70px');
            setTimeout(function() { 
                $('#infoStatus').delay(300).remove(); 
            }, 1000 );
        }, 3000);
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

$(window).resize(function(){
	js();
});

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.4&appId=832889430108937";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

function navAjax( Href, Title, History ){

    $( Load ).load( Href, function(){
    	js();
    	FB.XFBML.parse();
    });
    if( History == true && Href != Url ){
        window.history.pushState( date, false, Href ); // Grava no Historico do navegador
        Url = Href;
    }

    if( Title ){
        document.title = Title;
    }

    // ga('send', 'pageview', Href); /* Google Analitycs */
    $('body,html').animate({ scrollTop:0 },600 );
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

$(document).on('click', 'form[target="exec"] button[type="submit"]', function(){

		$('.mdl-button').prop('disabled', true);
		$('.mdl-spinner').show();

		var Valid = true
			Form = $(this).parents('form');

		Form.find('input, select, textarea').prop('readonly', true).each(function(){
			if( $(this).val() == '' ){
				$(this).css({
					'border-left': 'solid 1px #c0392b'
				}).focus();
				Valid = false;
			} else {
				$(this).css({
					'border-left': 'solid 1px #ccc'
				});
			}
		});

		if( Valid ){
		    $.ajax({ 
		        type: Form.attr('method'),
		        dataType: "json",
		        cache: false,
		        data: Form.serialize(),
		        url: Form.attr('action'),
		        success: function(json){
		        	if( json.status == true ){
		        		Alert( true, 'Olá ' + $('[name="nome"]').val() + ', recebemos o seu email! Em breve entraremos em contato' );
		        		$('input, textarea').val('');
		        		$('select option[value=""]').prop('selected', true);
		        	} else {
		        		Alert( false, json.message );
		        	}

		        	$('.mdl-button').prop('disabled', false);
		        	$('.mdl-spinner').hide();
		        }
		    });
		} else {
			Alert( false, 'Por favor, preencha os campos destacados em vermelho.' );
		}

		$('input, select, textarea').prop('readonly', false);
		$('.mdl-button').prop('disabled', true);

		return false;
	});