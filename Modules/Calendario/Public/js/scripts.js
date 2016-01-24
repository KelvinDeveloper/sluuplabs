var Year = $('.calendar-header input').val();

function Clear(){
	var Element = $('table.calendar');

	Element.find('td').attr('href', '');
	Element.find('td span.day').html('');
}

function Change( Date ){
	
	$('td.now').removeClass('now');
	Clear();

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: '/Calendario/Ajax/LoadCalendar/' + ( Date == undefined ? '' : Date ),
		success: function( json ){

			var Element = '';

			$.each(json.Days, function( k, v ) {

				Element = $('table.calendar tr[data-week="' + v.Week + '"] td[data-day-week="' + v.DayWeek + '"]');
				Element.attr('href', '/CreateCalendar?date=' + json.Year + '-' + json.Month + '-' + k);
				Element.find('span.day').html( k );
				setTimeout(function(){
					$('[href="/CreateCalendar?date=' + CalendarDateNow + '"]').addClass('now');
				}, 100);
			});
		}
	});
}

$('.calendar-header input').keyup(function(){
	if( $(this).val() != Year && $(this).val().length == 4 ){
		Change( $(this).val() + '-' + $('.calendar-header select').val() );
		Year = $(this).val();
	}
});

$('.calendar-header select').change(function(){
	Change( $('.calendar-header input').val() + '-' + $(this).val() );
});

$(document).ready(function(){
	Change();
});