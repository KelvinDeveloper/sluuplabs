var Year = $('.calendar-header input').val();

function Clear(){
	var Element = $('table.calendar');

	Element.find('td').attr('href', '');
	Element.find('td').attr('data-reference', '');
	Element.find('td').attr('data-value', '');
	Element.find('td span.day').html('');
}

function Change( Date, Option ){
	
	$('td.now').removeClass('now');
	Clear();

	$.ajax({
		type: 'POST',
		dataType: 'json',
		url: '/Calendario/Ajax/LoadCalendar/' + ( Date == undefined ? '' : Date ),
		data: {
			Option: ( Option != undefined ? Option : '' ),
		},
		success: function( json ){

			var Element = '';

			switch( Option ){

				case 'Previous':
					$.each(json.Days, function( k, v ) {

						Element = $('table.calendar tr[data-week="0"] td[data-day-week="' + v.DayWeek + '"]');
						
						if( v.Week == 4 && Element.find('span.day').html() == '' ){

							Element.attr('href', '/CreateCalendar?date=' + json.Year + '-' + json.Month + '-' + k);
							Element.attr('data-reference', json.Year + '-' + json.Month );
							Element.attr('data-value', json.Year + '-' + json.Month + '-' + k);
							Element.find('span.day').html( k );
							Element.addClass('opacity');
						}
					});
					break;

				case 'Last':
					$.each(json.Days, function( k, v ) {

						Element = $('table.calendar tr[data-week="5"] td[data-day-week="' + v.DayWeek + '"]');
						
						if( v.Week == 0 && Element.find('span.day').html() == '' ){

							Element.attr('href', '/CreateCalendar?date=' + json.Year + '-' + json.Month + '-' + k);
							Element.attr('data-reference', json.Year + '-' + json.Month );
							Element.attr('data-value', json.Year + '-' + json.Month + '-' + k);
							Element.find('span.day').html( k );
							Element.addClass('opacity');
						}
					});
					break;

				default:

					$.each(json.Days, function( k, v ) {

						Element = $('table.calendar tr[data-week="' + v.Week + '"] td[data-day-week="' + v.DayWeek + '"]');
						Element.attr('data-reference', json.Year + '-' + json.Month );
						Element.attr('href', '/CreateCalendar?date=' + json.Year + '-' + json.Month + '-' + k);
						Element.attr('data-value', json.Year + '-' + json.Month + '-' + k);
						Element.find('span.day').html( k );
						setTimeout(function(){
							$('[href="/CreateCalendar?date=' + CalendarDateNow + '"]').addClass('now');
						}, 100);
					});

					break;
			}
		}
	});

	if( Option == undefined ){
		Change( Date, 'Previous' );
		Change( Date, 'Last' );
		LoadValues();
	}
}

function LoadValues(){

	var First = $('table.calendar td.opacity:first').attr('data-reference'),
		Last  =	$('table.calendar td.opacity:last').attr('data-reference'),
		Now   = $('table.calendar td:not(.opacity):first').attr('data-reference');

	$.ajax({
		type: 'POST',
		dataType: 'json',
		data: {
			First: First,
			Last:  Last,
			Now:   Now
		},
		url: '/Calendario/Ajax/LoadCalendarValues',
		success: function(json){

			$.each(json, function( k, v ) {
				$('td[data-value="' + k + '"] span.events').html( '<span>' + v + '</span> Eventos').show();
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

$('i.calendarLast').click(function(){
	var DateFormat = $('table.calendar td.opacity:first').attr('data-reference'),
		Date = DateFormat.split('-');
		console.log( '.calendar-header select option[value="' + Date[1] + '"]' );
	$('.calendar-header select option[value="' + Date[1] + '"]').prop('selected', true);
	$('.calendar-header input').val( Date[0] );
	Year = Date[0];
	Change( DateFormat );
});

$('i.calendarPrevious').click(function(){
	var DateFormat = $('table.calendar td.opacity:last').attr('data-reference'),
		Date = DateFormat.split('-');
		console.log( '.calendar-header select option[value="' + Date[1] + '"]' );
	$('.calendar-header select option[value="' + Date[1] + '"]').prop('selected', true);
	$('.calendar-header input').val( Date[0] );
	Year = Date[0];
	Change( DateFormat );
});

$(document).ready(function(){
	Change();
});