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
		}
	});
}

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