$(document).ready(function(){
	$('#boxLogin button[type="submit"]').click(function(){
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

	$('#boxLogin .lateral').css({
		height: $(document).height(),
		width : $(document).width() / 3
	});

	$('#boxLogin .content').css({
		top : $(document).height() / 10,
		left: $(document).width() / 2.5
	});

	$( window ).resize(function() {
		$('#boxLogin .lateral').css({
			height: $(document).height(),
			width : $(document).width() / 3
		});
	});
});