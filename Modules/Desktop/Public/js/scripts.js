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

		var Info = $('.listModules [data-name="' + Module + '"]').data('info');
		$('body')
			.append('<div class="window" id="Module'  + Module + '" target="' + Module + '">' +
						'<div class="header">' +
							'<div class="drag">' + Module + '</div>' +
							'<div class="options">' +
								'<i class="material-icons close">clear</i>' +
								'<i class="material-icons maximize">&#xE895;</i>' + 
								'<i class="material-icons minimize">&#xE15B;</i>' + 
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
					if( Info.info.Maximized == true ){
						$('#Module' + Module).find('i.maximize').click();
					}
		    	}, 600);

				$('.window').draggable({
					handle: '.drag',
					containment: 'body',
					scroll: false
				});
				$('.window:not(.maximize)').resizable({
					maxHeight: 	$(window).height(),
  					maxWidth: 	$(window).width(),
  					minHeight: 	300,
  					minWidth: 	300,
				});
		   	}
		});
	}
}

$(document).ready(function(){

	$('.work.tab li').mousedown(function(){
		$(this).addClass('rCliked');
	});

	$('.work.tab li').mouseup(function(){
		$(this).removeClass('rCliked');
	});

	$('#desktop').fadeIn(200);
	setTimeout(function(){
		$('#desktop .account-user').fadeIn(300);
	}, 100);

	cssOpenStart();

	$('#desktop .account-user').click(function(e){
		e.stopPropagation();

		//$(this).toggleClass('active');

	});

	$('.mainDesk').click(function(){
		$('#desktop nav.top').parent().find('ul:first').fadeOut(100);
		$('#menu-desk-bottom').css('bottom', -999);
			
			$('#start').removeClass('active');

			$('#openStart').css({
				left: -999		
			});

			$('nav.top').css({
				right: -999		
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
	
	$(document).on('click', '.window', function(){
		$('.mainDesk').click();
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
	    	
	    	var JSONString;

	    	$.each( Return, function( Module, Info ){
				
				JSONString = JSON.stringify( Info );	    		

	    		$('#openStart .listModules').append(

	    			'<li class="mdl-cell mdl-cell--1-col" data-name="' + Module + '" title="' + Module.replace( '_', ' ' ) + '" data-quest="' + RemoveAccents( Module.toLowerCase() ) + '" data-info=\'' + JSONString + '\'">' +
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
	    		top: $(window).height() / 6,
	    		left: '50%',
	    		marginLeft: - ( $(window).width() / 1.2 )  / 2 
	    	});
	    	$('.window').draggable("enable");
		} else {

	    	This.parents('.window').css({
	    		width: '98%',
	    		height: $(window).height(),
	    		top: 0,
	    		left: 0,
	    		marginLeft: 0

	    	});
	    	$('.window').draggable("disable");
		}

		This.toggleClass('active');
		This.parents('.window').toggleClass('maximize');
	}

	function Minimize( This ){

		var Info = $('.listModules [title="' + This.parents('.window').attr('target').replace('_', ' ') + '"]').data('info');

		This.parents('.window').hide();

		$('.lancador ul').append(
			'<li title="' + Info.name + '" class="iconBar">' +
			'<img src="' + Info.icon + '">' +
			'</li>'
		);
	}

	$(document).on('click', 'body .window .header i.maximize', function(){
		Maximize( $(this) );
	});

	$(document).on('click', 'body .lancador .iconBar', function(){
		$('#Module' + $(this).attr('title') ).show();
		$(this).remove();
	});

	$(document).on('click', 'body .window .header i.minimize', function(){
		Minimize( $(this) );
	});

	$(document).on('dblclick', 'body .window .header .drag', function(){
		Maximize( $(this).parent('.header').find('i.maximize') );
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

		id: 'desktop',

		Menu: {
			wallpaper: {
				icon: '<i class="material-icons">&#xE3F4;</i>',
				text: 'Papel de Parede',
				exec: function(){
					if( $('.listWallpapers li').length > 0 ){
						$('#menu-desk-bottom').css( 'bottom', 75 );
					} else {
						$.ajax({ 
						    type: "POST",
						    dataType: "json",
						    cache: false,
						    url: '/Desktop/Ajax/Wallpapers', 
						    success: function(Return){ 
						    	$('#menu-desk-bottom').html('<ul class="listWallpapers"></ul>');
						    	$.each( Return, function( id, BG ){
						    		$('#menu-desk-bottom ul').append('<li data-image="' + BG + '"><img src="/Application/System/Backgrounds/' + BG + '"></li>');
						    	});

						    	$('#menu-desk-bottom').css( 'bottom', 75 );
						   	}
						});
					}
				}
			}
		}
	});
	
});

$('.eIcons li:not(#navPrev, #uploadifive)').rClick({

	id: 'eIcons',

	Menu: {

		download: {
			icon: '<i class="material-icons">&#xE2C0;</i>',
			text: 'Baixar',
			exec: function(This){
			}
		},

		copy: {
			icon: '<i class="material-icons">&#xE14D;</i>',
			text: 'Copiar',
			exec: function(This){
			}
		},

		cut: {
			icon: '<i class="material-icons">&#xE14E;</i>',
			text: 'Recortar',
			exec: function(This){
			}
		},

		rename: {
			icon: '<i class="material-icons">&#xE254;</i>',
			text: 'Renomear...',
			exec: function(This){

			}
		},

		delete: {
			icon: '<i class="material-icons">&#xE872;</i>',
			text: 'Excluir',
			exec: function(This){
				var Confirm = confirm('Tem certeza que deseja excluir este item permanentemente?');

				if( Confirm == true ){
					This.parent('li').remove();
				}
			}
		},

		properties: {
			icon: '<i class="material-icons">&#xE88F;</i>',
			text: 'Propriedades',
			exec: function(This){
				$.ajax({ 
				    type: "POST",
				    dataType: "json",
				    cache: false,
				    data: {
				    	File: JSON.stringify( This.data('info') )
				    },
				    url: '/Explorer/Ajax/Properties', 
				    success: function(Return){ 
				    	
				   	}
				});
			}
		}
	}
});

$('#explorerContent').rClick({

	id: 'ModuleExplorer',
	Menu: {

		paste: {
			icon: '<i class="material-icons">&#xE14F;</i>',
			text: 'Colar',
			exec: function(This){

			}
		},

		newFolder: {
			icon: '<i class="material-icons">&#xE2C7;</i>',
			text: 'Criar pasta',
			exec: function(This){

			}
		}
	}

});

$('.listUsersSaved li').rClick({
	id: 'listUsersSavedrClick',
	Menu: {

		delete: {
			icon: '<i class="material-icons">&#xE872;</i>',
			text: 'Deletar',
			exec: function(This){
				var Confirm = confirm('Tem certeza que deseja deletar esse usuário do Grupo de Trabalho?');
				if( Confirm ){

					var id_wg   = This.parents('.listUsersSaved').data('id'),
						id_user = This.data('id');

					$.ajax({
						type: 'POST',
						dataType: 'json',
						url: '/Desktop/Ajax/DeleteUser',
						data: {
							id:   id_wg,
							user: id_user
						},
						success: function(json){

							if( json.Status === true ){

							}
						}
					});
					This.remove();
				}
			}
		}
	}
});
/* Ends rClick */
/* Workgroup */
$(document).on('click', '.listSUsers li', function(e){

	e.stopPropagation();
	
	var id_wg     = $(this).parents('.listSUsers').data('id'),
		id_user   = $(this).data('id'),
		nome_user = $(this).text(),
		styles    = $(this).find('.img').attr('style');

	$(this).parents('.listSUsers').html('').hide();
	$('#sUser').val('');

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: '/Desktop/Ajax/SaveUser',
		data: {
			id:   id_wg,
			user: id_user
		},
		success: function(json){

			if( json.Status === true ){

				$('.listUsersSaved').append('<li data-id="' + id_user + '">' +
                    '<span class="img" style="' + styles + '"></span>' +
                    '<span class="name">' + nome_user + '</span>' +
                  '</li>');

			}
		}
	});
});
/* ends Workgroup */