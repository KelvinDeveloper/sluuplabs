var cssOpenStart = function(){
	$('#desktop #openStart').css({
		height: $(window).height() / 2
	});
	$('body').css({
		maxWidth: $(window).width(),
		maxHeight: $(window).height()
	});
}

$(document).ready(function(){
	$('#desktop').fadeIn(200);
	setTimeout(function(){
		$('#desktop nav.top .account-user').fadeIn(300);
	}, 100);

	cssOpenStart();

	$('#desktop nav.top .account-user').click(function(e){
		e.stopPropagation();
		$(this).parent().find('ul:first').css({
			top: $(this).offset().top + ( $(this).height() / 2 ) + 20
		}).fadeToggle();
	});

	$('#desktop nav.top .account-user ul').click(function(e){
		e.stopPropagation();
	});

	$('html').click(function(){
		$('#desktop nav.top .account-user').parent().find('ul:first').fadeOut(100);
		$('#openStart').fadeOut(100);
	});
	$('#lagout').click(function(){
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
	    		$('#openStart .listModules').append('<li data-name="' + Module + '">' + Module + '</li>');
	    	});
	   	}
	});
	$('#start').click(function(e){
		e.stopPropagation();
		$('#openStart').css({
			bottom: $(this).height() * 2 + 20
		}).fadeToggle();
	});

	$(document).on('click', '.listModules li', function(e){
		e.stopPropagation();

		var Module = $(this).data('name');

		if( $('#Modules #Module' + Module ).length > 0 ){
			$('#Modules #Module' + Module ).show();
		} else {
			$('#Modules')
				.append('<div draggable="true" class="window" id="Module'  + Module + '">' +
							'<div class="header">' +
								'<i class="material-icons close">clear</i>' +
							'</div>'  +
							'<div class="content"></div>' +
						'</div>');

				 	
				 	
					    $( ".window" ).draggable({
					    containment: 'body',
						    drag: function(event) {
						        var top = $(this).position().top;
						        var left = $(this).position().left;

						        ICZoom.panImage(top, left);
						    }
					    });


			$.ajax({ 
			    type: "POST",
			    dataType: "html",
			    cache: false,
			    url: '/' + $(this).data('name'), 
			    success: function(Page){ 
			    	$('#Module' + Module ).css({
			    		width: $(window).width() / 1.2,
			    		height: $(window).height() / 1.5,
			    		marginTop: $(window).height() / 6,
			    		'border-radius': '2px',
			    		opacity: 1
			    	});

			    	setTimeout(function(){
			    		$('#Module' + Module + ' .content').html( Page );
			    		$('#Module' + Module + ' .header').fadeIn();
			    	}, 600);
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
    		marginTop: -999,
    		'border-radius': '10%',
    	}).fadeOut(400);
    	setTimeout(function(){
    		This.parents('.window').remove();
    	}, 500);
	});
});

$(window).resize(function(){
	cssOpenStart();
});