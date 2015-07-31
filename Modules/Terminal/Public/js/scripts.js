$(document).ready(function(){

	jQuery.fn.putCursorAtEnd = function() {
	return this.each(function() {
	  $(this).focus()
	  if (this.setSelectionRange) {
	    var len = $(this).val().length * 2;
	    this.setSelectionRange(len, len);
	  
	  } else {
	    $(this).val($(this).val());
	  }
	  this.scrollTop = 999999;
	});
	};

	var root = '/: ';

	$('#ModuleTerminal input').keyup(function(e){

  		if( $(this).val() == '' || $(this).val().length < 3 ){
  			$(this).val( root ).putCursorAtEnd();
  		}

	  	if( e.keyCode == 13 && $(this).val() != '/: ' ){

	  		var action = $('#ModuleTerminal input').val();
	  		$(this).val( '/: Execultando...' );

	  		var ex = action.split(': ');

	  		if( ex[1] == 'clear' ){
	  			$('#ModuleTerminal pre').html('');
	  			$("#ModuleTerminal input").val( root );
	  			return false;
	  		}

	         $.ajax({ 
			    type: "POST",
			    dataType: "json",
	              data: { 
	              	action: action
	              },
	              cache: false,
	              url: '/SendTerminal', 
	              success: function(R) {  
	              	var scroll = document.getElementById("ModuleTerminal").scrollHeight;

	              	if( R.Location != '' ){
	              		root = R.Location;
	              	}

	              	$("#ModuleTerminal input").val( root );
	              	if( R.Message != false ){
	              		$("#ModuleTerminal pre").append( R.Message + '<br>' );
	              	}
	              	$("#ModuleTerminal").scrollTop( scroll );
	              }
	          });
	  	}
	});

  $('#ModuleTerminal').click(function(){
  	$("#ModuleTerminal input").putCursorAtEnd();
  });

  $('#ModuleTerminal input').val( root ).putCursorAtEnd();
});