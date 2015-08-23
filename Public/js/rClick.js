(function($){

	var Methods = {

		init: function( Element, Settings, nMenu ){
			
			$(document).on('mousedown', Element.selector, function(event){

				event.stopPropagation();

				if( event.button == 2 ){

					var x = event.pageX,
						y = event.pageY;
						console.log( $('ul#rClickMenu-' + Settings.id) );
					$('ul#rClickMenu-' + Settings.id).fadeIn(100).css({
						top:  y,
						left:  x
					});

				} else {

					$('#rClickMenu-' + Settings.id).fadeOut(100);
				}
			});

			this.construct( nMenu, Settings.id );
		},

		construct: function( nMenu, id ){

			if( $('#rClickMenu-' + id ).length < 1 ){

				var HTML = '<ul class="rClickMenu" id="rClickMenu-' + id + '">';

				$.each( nMenu, function( k, v ){
					HTML += '<li id="opMenu-' + k + '">' + v.icon + ' ' + v.text + '</li>';
				});

				HTML += '</ul>';

				$('body').append( HTML );
			}
		}
	}
 
	$.fn.rClick = function( Values ){

	    var Settings 	= Values,
	    	nMenu 		= Values.Menu;

	    Methods.init( this, Settings, nMenu );

	    $('#rClickMenu-' + Settings.id + ' li').click(function(){
	    	var Action = $(this).attr('id').replace('opMenu-', '');
	    	eval('nMenu.' + Action + '.exec()');
	    });

	    this.on("contextmenu",function(){
	       return false;
	    }); 

	    $('#rClickMenu-' + Settings.id).on("contextmenu",function(){
	       return false;
	    });

	    $('body').mousedown(function(){
	    	$('#rClickMenu-' + Settings.id).fadeOut(100);
	    });

	};

})(jQuery);


// 	nMenu = $.extend( true, {

// 			Menu: {

// 	copy: {
// 		icon: '<i class="material-icons">&#xE14D;</i>',
// 		text: 'Copiar',
// 		exec: function(){
// 			alert('debug');
// 		}
// 	},

// 	paste: {
// 		icon: '<i class="material-icons">&#xE14F;</i>',
// 		text: 'Colar',
// 		exec: function(){
// 			alert('debug');
// 		}
// 	},

// 	close: {
// 		icon: '<i class="material-icons">&#xE14C;</i>',
// 		text: 'Fechar',
// 		exec: function(){
// 			alert('debug');
// 		}
// 	},

// 	maximize: {
// 		icon: '<i class="material-icons">&#xE5D0;</i>',
// 		text: 'Maximizar',
// 		exec: function(){
// 			alert('debug');
// 		}
// 	},

// 	minimize: {
// 		icon: '<i class="material-icons">&#xE5CF;</i>',
// 		text: 'Minimizar',
// 		exec: function(){
// 			alert('debug');
// 		}
// 	},

// 	delete: {
// 		icon: '<i class="material-icons">&#xE872;</i>',
// 		text: 'Deletar',
// 		exec: function(){
// 			alert('debug');
// 		}
// 	},

// 	,

// 	properties: {
// 		icon: '<i class="material-icons">&#xE5D4;</i>',
// 		text: 'Propriedades',
// 		exec: function(){
// 			alert('debug');
// 		}
// 	}
// }

// 	}, Values );