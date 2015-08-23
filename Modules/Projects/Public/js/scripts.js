// Load project
function LoadProject( Pjc ){
	$.ajax({ 
    	type: "POST",
    	dataType: "json",
    	cache: false,
    	data: {
    		Pjc: Pjc
    	},
    	url: '/Projects/Ajax/loadProject', 
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


$(document).ready(function(){
	// Open initial
	// $(function() {
	//     $('#ModuleProjects').ruler();    
	// });


	$('.pSelInitial button').click(function(){
		$('.pInitial').load( $(this).attr('href') );
	});



});