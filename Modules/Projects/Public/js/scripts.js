// Load project
function LoadProject( Pjc ){
	$.ajax({ 
    	type: "POST",
    	dataType: "json",
    	cache: false,
    	data: {
    		Pjc: Pjc
    	},
    	url: '/Projects/Ajax/LoadProject', 
    	success: function(Pjc){ 
			$.ajax({ 
		    	type: "POST",
		    	dataType: "html",
		    	cache: false,
		    	data: {
		    		json: Pjc
		    	},
		    	url: '/Projects/Ajax/LoadStage',
		    	success: function(Page){
		    		$('#ModuleProjects .pContent').html( Page );
		    	}
		    });
    	}
    });
}

function LoadPage(){
	$('.stageTitle').html('<i class="material-icons fL">&#xE24D;</i> ' + $('#p-pages li.active').attr('data-title') );

	$.ajax({
		type: "POST",
		dataType: "html",
		cache: false,
		data: {
			File: $('#p-pages li.active').attr('id'),
			Pjc:  $('.pMenuRigth').data('pjc')
		},
		url: '/Projects/Ajax/LoadPage',
		success: function(HTML){
			$('#stage').html(HTML);

			setTimeout(function(){
				$('#bodyContent .item').draggable({
				    containment: '#bodyContent',
				    handle: '.item-header',

				    start: function(event, ui ){
				    	ui.helper.addClass('active');
				    },
				    stop: function(event, ui ){
				    	ui.helper.removeClass('active');

						$.ajax({
							type: "POST",
							dataType: "html",
							cache: false,
							data: {
								Page: JSON.stringify( $('#p-pages li.active').data('info') ),
								Pjc:  $('.pMenuRigth').data('pjc'),
								Item: ui.helper.attr('id'),
								Left: ui.position.left,
								Top:  ui.position.top
							},
							url: '/Projects/Ajax/SavePosition',
							success: function(HTML){

							}
						});
				    }

				});
			}, 300);
		}
	});
}

$(document).on('mouseenter', '#bodyContent .item', function(){ 
	$(this).find('.item-header').fadeIn(100);
});

$(document).on('mouseleave', '#bodyContent .item', function(){ 
	$(this).find('.item-header').fadeOut(100);
});

$(document).ready(function(){
	// Open initial
	// $(function() {
	//     $('#ModuleProjects').ruler();    
	// });


	$('.pSelInitial button').click(function(){
		$('.pInitial').load( $(this).attr('href') );
	});

	$('.pNav').click(function(){
		$('.pInitial').load( $(this).attr('href') );
	});

});