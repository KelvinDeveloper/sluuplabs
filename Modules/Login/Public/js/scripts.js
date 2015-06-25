$(document).ready(function(){
	$('.boxLogin button[type="submit"]').click(function(){
		$.ajax({ 
		    type: "POST",
		    data: { 
		    	email: $('.boxLogin input[name="email"]').val(),
		    	pass : $('.boxLogin input[name="pass"]').val()
		    },
		    dataType: "json",
		    cache: false,
		    url: '/Login/Ajax/Logar', 
		    success: function(Return){ }
		});
	});
});