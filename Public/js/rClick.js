(function($){

	var Menu = {

		copy: {
			icon: '<i class="material-icons">&#xE14D;</i>',
			text: 'Copiar',
			exec: function(){
				alert('debug');
			}
		},

		paste: {
			icon: '<i class="material-icons">&#xE14F;</i>',
			text: 'Colar',
			exec: function(){
				alert('debug');
			}
		},

		close: {
			icon: '<i class="material-icons">&#xE14C;</i>',
			text: 'Fechar',
			exec: function(){
				alert('debug');
			}
		},

		maximize: {
			icon: '<i class="material-icons">&#xE5D0;</i>',
			text: 'Maximizar',
			exec: function(){
				alert('debug');
			}
		},

		minimize: {
			icon: '<i class="material-icons">&#xE5CF;</i>',
			text: 'Minimizar',
			exec: function(){
				alert('debug');
			}
		},

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
		},


		properties: {
			icon: '<i class="material-icons">&#xE5D4;</i>',
			text: 'Propriedades',
			exec: function(){
				alert('debug');
			}
		}
	}

	var Methods = {

		init: function( Element, Settings ){

			$(document).on('mousedown', Element, function(event){

				if( event.button == 2 ){

					$('#rClickMenu li').hide();

					$.each( Settings.op, function( k, v ){
						if( v !== false ){
							$('#rClickMenu #opMenu-' + k).show();
						}
					});

					var x = event.pageX,
						y = event.pageY;

					$('ul#rClickMenu').fadeIn(100).css({
						top:  y,
						left:  x
					});

				} else {

					$('#rClickMenu').fadeOut(100);
				}
			});

			this.construct();
		},

		construct: function(){

			if( $('#rClickMenu').length < 1 ){

				var HTML = '<ul class="menu" id="rClickMenu">';

				$.each( Menu, function( k, v ){
					HTML += '<li id="opMenu-' + k + '">' + v.icon + ' ' + v.text + '</li>';
				});

				HTML += '</ul>';

				$('body').append( HTML );
			}
		}
	}
 
	$.fn.rClick = function( Values ){

	    var Settings = $.extend(true, {

	    	op: {
	    		copy			: true,
	    		paste			: true,
	    		properties		: true,
	    		close			: true,
	    		minimize		: true,
	    		maximize		: true,
	    		delete			: true,
	    		wallpaper		: true,
	    		new: {
	    			folder: true,
	    			file: 	true
	    		}
	    	}

	    }, Values);

	    Methods.init( this, Settings );

	    $('#rClickMenu li').click(function(){
	    	var Action = $(this).attr('id').replace('opMenu-', '');
	    	eval('Menu.' + Action + '.exec()');
	    });

	    this.on("contextmenu",function(){
	       return false;
	    }); 

	    $('#rClickMenu').on("contextmenu",function(){
	       return false;
	    }); 

	};

})(jQuery);