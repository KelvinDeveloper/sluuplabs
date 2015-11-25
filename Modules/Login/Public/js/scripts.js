var cssBoxLogin = function(){
	$('#boxLogin .content').width( $(document).width() / 3 ).parent().fadeIn(100);
	$('#listHistoryUsers').width( $(document).width() / 5 ).height( $(document).height() );
}

$(document).ready(function(){


	$('#boxLogin').fadeIn(200);

	$('#boxLogin button[type="submit"]').click(function(){

		$('#Logar').attr('disabled', true);

		$('.defaultLoader').show();

		$.ajax({ 
		    type: "POST",
		    data: { 
		    	email: $('#boxLogin input[name="email"]').val(),
		    	pass : $('#boxLogin input[name="pass"]').val()
		    },
		    dataType: "json",
		    cache: false,
		    url: '/Login/Ajax/Logar', 
		    success: function(Return){ 
		    	if( Return.status == false ){
		    		Alert( Return.status, '<i class="material-icons">report_problem</i> ' + Return.message );
		    		$('#Logar').attr('disabled', false);
		    	} else if( Return.status == true ){

		    		window.history.pushState( date, false, Url );

		    		$('#boxLogin .account-user').css({
		    			'background-image': 'url(\'' + Return.user.Image + '\')'
		    		});
		    		$('#boxLogin .bodyLogin').fadeOut(400);
		    		setTimeout(function(){
					  $('#boxLogin .account-user').animate({
					    marginLeft: '-' + $(document).width() / 2 + 'px'
					  }, 100);
		    		}, 400);
		    		setTimeout(function(){
						$('#boxLogin .nameUser').css({
						  top: $('.account-user').offset().top + ( $('.account-user').height() / 2 ) - 50,
						  left: $('.account-user').offset().left + $('.account-user').width() / 2
						}).text( Return.greeting + ', ' + Return.user.Nome ).fadeIn(400);
		    		}, 700);

					$.ajax({ 
					    type: "POST",
					    dataType: "html",
					    cache: false,
					    url: '/', 
					    success: function(Page){ 
					    	$('#boxLogin').fadeOut(400);
					    	setTimeout(function(){
					    		$('body').html(Page);
					    	}, 500);
					    }
					});
		    	}
		    }
		});

		$('.defaultLoader').hide();
	});

	cssBoxLogin();

	setTimeout(function(){
		if( $('#fldEmail').val() != '' ){
			$('#fldEmail').focus().val( $('#fldEmail').val() );
			$('#fldPass').focus();
		} else {
			$('#fldEmail').focus();		
		}
	}, 300);
	
	$('#boxLogin input').keyup(function(e){
		if( e.keyCode === 13 ){
			$('#boxLogin button[type="submit"]').click();
		}
	});

	$('#HistoryUsers').click(function(){
		$(this).fadeOut();
		$('#listHistoryUsers').css({
			left: 0
		});
	});
	$('ul#listHistoryUsers li').click(function(){
		if( $(this).data('email') != '' ){
			$('#fldEmail').val( $(this).data('email') ).prop('readonly', true).focus();
			$('#fldPass').focus();
		} else {
			$('#fldEmail').val( $(this).data('') ).prop('readonly', false).focus();
		}
		$('#boxLogin .account-user').css({
			'background-image': 'url(\'' + $(this).data('bg') + '\')'
		});
		$('#listHistoryUsers').css({
			left: -999
		});
		$('#HistoryUsers').fadeIn();
		var img = new Image(),
			background = $(this).data('wallpaper');

		if( background != '' && background != undefined ){
			img.src = background;
			img.onload = function() {
				$('body').css('background', "url('" + background + "')");
			}
		} else {
			$('body').css('background', "#4285f4");
		}
	});
});

$(window).resize(function(){
	cssBoxLogin();
});