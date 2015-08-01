(function($){

	var Methods = {

		init: function( Element, Settings ){

			$(document).on('mousedown', Element, function(e){

				if( e.button == 2 ){

					$('#desktop .menuRigthClick li').hide();

					Settings.Options.each(function(){
						$('#desktop .menuRigthClick li.' + $(this) ).show();
					});

					var x = e.pageX,
						y = e.pageY;

					$('#desktop .menuRigthClick').fadeIn(100).css({
						top:  y,
						left:  x
					});

				} else {

					$('#desktop .menuRigthClick').fadeOut(100);
				}
			});
		}
	}
 
	$.fn.rClick = function( Values, Methods ){

	    var Settings = $.extend({

	    }, Values);

	    Methods.init( Settings );
	};

})(jQuery);