var setTime;

function fode( l ){

	var HTML = '',
		premium = Math.floor( (Math.random() * ( l * l ) ) + 1),
		loop = 0;

	for (var i = 0; i < l; i++) {
		HTML += '<tr>';
		for (var i2 = 0; i2 < l; i2++) {
			
			loop++;

			HTML += '<td'; 
			if( loop === premium ){
				HTML += ' class="ae"';
				premium = false;
			}

			HTML += '>t</td>';
		};
		HTML += '</tr>';
	};

	return HTML;
}

	var l = 5,
	placar = 0;

	
	var tempo = new Number();
	tempo = 20;
	function startCountdown() {
		
	

		if((tempo - 1) >= 0){

			var min = parseInt(tempo/60);
			var seg = tempo%60



			if(min < 10){
				min = "0"+min;
				min = min.substr(0, 2);
			}

			if(seg <= 9){
				seg = "0"+seg;
			}

			horaImprimivel = min + ':' + seg;

			$("#sessao").html(horaImprimivel);

			setTime = setTimeout('startCountdown()', 1000);
			tempo--;

		} else {
			alert('acabou tempo.');
			l = 5;
			$('.teste').html( '<table>' +  fode( l ) + '</table>' );
			placar = 0;
			$('.placar').text(placar);
			tempo = 10;
			startCountdown();

		}

	}


//startando
$(document).ready(function(){

startCountdown();

	$('#ModuleStupid_Ball .close').click(function(){
		clearTimeout(setTime);
	});

	$('.teste').html( '<table>' +  fode( l ) + '</table>' );
	
	$(document).on('click', 'table tr td', function(){
		

		if( $(this).hasClass('ae') == true ){

			placar++;
			tempo += 3;
			

			$('.placar').text(placar);

			if( placar > parseInt( $('.record').text() ) ){
				$('.record').text(placar);	
			}

			l = l + 1;
			$('.teste').html( '<table>' +  fode( l ) + '</table>' );
		} else {
			tempo -= 1;
		}


	});
});
