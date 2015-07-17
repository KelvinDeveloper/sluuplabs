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

	$('#ModuleTerminal input').keyup(function(e){

  		if( $(this).val() == '' || $(this).val().length < 3 ){
  			$(this).val('/: ').putCursorAtEnd();
  		}

	  	if( e.keyCode == 13 && $(this).val() != '/: ' ){

	  		var action = $('#ModuleTerminal input').val();
	  		$(this).val( '/: Execultando...' );

	  		if( action == '/: clear' ){
	  			$('#ModuleTerminal pre').html('');
	  			$("#ModuleTerminal input").val('/: ');
	  			return false;
	  		}

	         $.ajax({ 
	              type: "POST",
	              data: { 
	              	action: action
	              },
	              dataType: "html",
	              cache: false,
	              url: '/SendTerminal', 
	              success: function(msg) {  
	              	var scroll = document.getElementById("ModuleTerminal").scrollHeight;
	              	$("#ModuleTerminal input").val('/: ');
	              	$("#ModuleTerminal pre").append( msg );
	              	$("#ModuleTerminal").scrollTop( scroll );
	              }
	          });
	  	}
	});

  $('#ModuleTerminal').click(function(){
  	$("#ModuleTerminal input").putCursorAtEnd();
  });

  $('#ModuleTerminal input').val('/: ').putCursorAtEnd();
});