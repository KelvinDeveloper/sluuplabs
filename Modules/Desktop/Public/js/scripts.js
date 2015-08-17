var cssOpenStart = function(){
	// $('body, .mainDesk, body').css({
	// 	width: $(window).width(),
	// 	height: $(window).height()
	// });

	// $('body').css({
	// 	maxWidth: $(window).width(),
	// 	maxHeight: $(window).height()
	// });
	// $('#menu-desk-bottom').width( $(window).width() );
}

function upgradeMDL() {
  componentHandler.upgradeDom();
  //componentHandler.upgradeDom();
  //componentHandler.upgradeAllRegistered();
}

function openModule( Module ){

	if( $('body #Module' + Module ).length > 0 ){
		$('body #Module' + Module ).show();
	} else {
		$('body')
			.append('<div class="window" id="Module'  + Module + '">' +
						'<div class="header">' +
							'<div class="options">' +
								'<i class="material-icons close">clear</i>' +
								'<i class="material-icons maximize">&#xE895;</i>' + 
							'</div>' +
						'</div>'  +
						'<div class="content">' +
							'<img src="' + $('.listModules [data-name="' + Module + '"]').find('img').attr('src') + '" class="iconLoader"></img> <br><br>' + 
							'<div class="moduleLoader mdl-spinner mdl-js-spinner is-active"></div>' +
						'</div>' +
					'</div>');

				setInterval("upgradeMDL();", 100);

		    	$('#Module' + Module ).css({
		    		width: $(window).width() / 1.5,
		    		height: $(window).height() / 1.5,
		    		left: '50%',
		    		marginLeft: - ( $(window).width() / 1.5 ) / 2,
		    		position: 'absolute',
		    		'border-radius': '2px',
		    	});

		    	$('#Module' + Module ).animate({
		    		top: $(window).height() / 6,
		    		opacity: 1,
		    	}, 300);

		$.ajax({ 
		    type: "POST",
		    dataType: "html",
		    cache: false,
		    url: '/' + Module, 
		    success: function(Page){ 

		    	setTimeout(function(){
		    		$('#Module' + Module + ' .content').html( Page );
		    		$('#Module' + Module + ' .header').fadeIn(100);
					setInterval("upgradeMDL();", 100);
		    	}, 600);

				$('.window:not(.maximize)').draggable({
					handle: '.header',
					containment: 'body',
					scroll: false
				});
				$('.window:not(.maximize)').resizable({
					maxHeight: 	$(window).height(),
  					maxWidth: 	$(window).width(),
  					minHeight: 	$(window).width() / 3,
  					minWidth: 	$(window).height() / 3,
				});
		   	}
		});
	}
}

$(document).ready(function(){

	$('#desktop').fadeIn(200);
	setTimeout(function(){
		$('#desktop .account-user').fadeIn(300);
	}, 100);

	cssOpenStart();

	$('#desktop .account-user').click(function(e){
		e.stopPropagation();

		$(this).toggleClass('active');
		if( $(this).hasClass('active') == true )
		{

			$('nav.top').css({
				right: 0		
			});

			$(this).css({
				right: $(window).width() / 6.3
			});

			$('#desktop .infoUser').css({
				right: 149
			});

		} else {
			$('nav.top').css({
				right: -999		
			});

			$(this).css({
				right: 160
			});

			$('#desktop .infoUser').css({
				right: 11
			});
		}

	});

	$('.mainDesk').click(function(){
		$('#desktop nav.top .account-user').parent().find('ul:first').fadeOut(100);
		$('#menu-desk-bottom').css('bottom', -999);
			
			$('.account-user, #start').removeClass('active');

			$('#openStart').css({
				left: -999		
			});

			$('nav.top').css({
				right: -999		
			});

			$('#desktop .account-user').css({
				right: 160
			});

			$('#desktop .infoUser').css({
				right: 11
			});

			$('#desktop .buscarApps #searchApps').val('');

	});

	$(document).on('click', '.listWallpapers li', function(){
		$('body').css("background", "url('" + $(this).find('img').attr('src') + "')");
		reg( 'User', 'Wallpaper', $(this).find('img').attr('src') );
	});
	
	$('#logout').click(function(){
		$('#desktop').fadeOut();
		$.ajax({ 
		    type: "POST",
		    dataType: "html",
		    cache: false,
		    url: '/Login/Ajax/Lagout', 
		    success: function(Return){ 
				$.ajax({ 
				    type: "POST",
				    dataType: "html",
				    cache: false,
				    url: '/Login', 
				    success: function(Page){ 
				    	$('body').html( Page );
				    	window.history.pushState( date, false, '/Login' );
				    }
				});
		    }
		});
	});

	$.ajax({ 
	    type: "POST",
	    dataType: "json",
	    cache: false,
	    url: '/Desktop/Ajax/ListModules', 
	    success: function(Return){ 
	    	
	    	$.each( Return, function( Module, Info ){
	    		
	    		$('#openStart .listModules').append(

	    			'<li class="mdl-cell mdl-cell--1-col" data-name="' + Module + '" title="' + Module.replace( '_', ' ' ) + '" data-quest="' + RemoveAccents( Module.toLowerCase() ) + '">' +
	    				' <img src="' + Info.icon + '"><br> ' +
	    				' <span>' + Module.replace( '_', ' ' ) + '</span>' +
	    			'</li>'
	    			);
	    	});
	   	}
	});
	$('#start').click(function(e){
		e.stopPropagation();

		$(this).toggleClass('active');
		if( $(this).hasClass('active') == true )
		{
			$('#openStart').css({
				left: 0		
			});

			$('#desktop .buscarApps input').focus();

		} else {
			$('#openStart').css({
				left: -999		
			});
		}

	});

	$(document).on('click', '.listModules li', function(e){
		e.stopPropagation();

		$('#openStart').css({
			left: -999		
		});

		openModule( $(this).data('name') );
	});

	$(document).on('click', 'body .window .header i.close', function(){

		var This = $(this);

		This.parents('.window').find('.header, .content').hide();

    	This.parents('.window').animate({
    		top: 0,
    		opacity: 0,
    	}, 300);

    	setTimeout(function(){
    		This.parents('.window').remove();
    	}, 500);
	});

	function Maximize( This ){

		if( This.hasClass('active') ){
	    	This.parents('.window').css({
	    		width: $(window).width() / 1.2,
	    		height: $(window).height() / 1.5,
	    		top: $(window).height() / 6
	    	});
		} else {

	    	This.parents('.window').css({
	    		width: '98%',
	    		height: $(window).height(),
	    		top: 0,
	    		left: 0,

	    	});
		}

		This.toggleClass('active');
		This.parents('.window').toggleClass('maximize');
	}

	$(document).on('click', 'body .window .header i.maximize', function(){
		Maximize( $(this) );
	});

	$(document).on('dblclick', 'body .window .header', function(){
		Maximize( $(this).find('i.maximize') );
	});

	$('.menuRigthClick li').click(function(){
		$(this).parents('.menuRigthClick').fadeOut(100);
	});

});

$(window).resize(function(){
	cssOpenStart();
});

/* rClick */
$(document).ready(function(){

	$('.mainDesk').rClick({
		op:{
			close: 		false,
			minimize: 	false,
			maximize: 	false,
		}
	});
	
});