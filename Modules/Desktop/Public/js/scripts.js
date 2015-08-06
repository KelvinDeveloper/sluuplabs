var cssOpenStart = function(){
	$('body, .mainDesk, #Modules').css({
		width: $(window).width(),
		height: $(window).height()
	});
	$('#desktop #openStart, #desktop nav.top').height( $(window).height() );
	$('body').css({
		maxWidth: $(window).width(),
		maxHeight: $(window).height()
	});
	$('#menu-desk-bottom').width( $(window).width() );
}

function upgradeMDL() {
  componentHandler.upgradeDom();
  //componentHandler.upgradeDom();
  //componentHandler.upgradeAllRegistered();
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
	    			'<li data-name="' + Module + '" title="' + Module.replace( '_', ' ' ) + '" data-quest="' + RemoveAccents( Module.toLowerCase() ) + '">' +
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

		var Module = $(this).data('name');

		if( $('#Modules #Module' + Module ).length > 0 ){
			$('#Modules #Module' + Module ).show();
		} else {
			$('#Modules')
				.append('<div class="window" id="Module'  + Module + '">' +
							'<div class="header">' +
								'<div class="options">' +
									'<i class="material-icons close">clear</i>' +
									'<i class="material-icons maximize">&#xE895;</i>' + 
								'</div>' +
							'</div>'  +
							'<div class="content"></div>' +
						'</div>');

			$.ajax({ 
			    type: "POST",
			    dataType: "html",
			    cache: false,
			    url: '/' + $(this).data('name'), 
			    success: function(Page){ 
			    	$('#Module' + Module ).css({
			    		width: $(window).width() / 1.2,
			    		height: $(window).height() / 1.5,
			    		top: $(window).height() / 6,
			    		'border-radius': '2px',
			    		opacity: 1
			    	});

			    	setTimeout(function(){
			    		$('#Module' + Module + ' .content').html( Page );
			    		$('#Module' + Module + ' .header').fadeIn(100);
						setInterval("upgradeMDL();", 100);
			    	}, 600);

					$('.window:not(.maximize)').draggable({
						handle: '.header',
						containment: '.mainDesk',
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
	});

	$(document).on('click', '#desktop .window .header i.close', function(){

		var This = $(this);

		This.parents('.window').find('.header, .content').hide();

    	This.parents('.window').css({
    		width: $(window).width() / 3,
    		height: $(window).height() / 3,
    		top: -999,
    		'border-radius': '10%',
    	}).fadeOut(400);
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

	$(document).on('click', '#desktop .window .header i.maximize', function(){
		Maximize( $(this) );
	});

	$(document).on('dblclick', '#desktop .window .header', function(){
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