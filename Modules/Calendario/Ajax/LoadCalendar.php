<?php

if( empty( $Url[4] ) ){
	$Url[4] = date('Y-m');
}

if( $_POST['Option'] == 'Previous' ){
	// 2016-01
	$Date = explode( '-', $Url[4] );

	if( $Date[1] == '01' ){

		$Url[4] = ( $Date[0] - 1 ) . '-12';
	} else {

		$Url[4] = $Date[0] . '-' . ( $Date[1] - 1 );
	}
}

else if ( $_POST['Option'] == 'Last' ){

	$Date = explode( '-', $Url[4] );

	if( $Date[1] == '12' ){

		$Url[4] = ( $Date[0] + 1 ) . '-1';
	} else {

		$Url[4] = $Date[0] . '-' . ( $Date[1] + 1 );
	}
}

/* Quantidade de dias do mês */
$Date = explode( '-', $Url[4] );
$Days = cal_days_in_month(CAL_GREGORIAN, $Date[1], $Date[0]);
$Week = 0;

$Return['Year'] =  $Date[0];
$Return['Month'] = str_pad( $Date[1], 2, 0, STR_PAD_LEFT );

for ($i = 1; $i <= $Days; $i++) { 

	$DayWeek = date("w", mktime(0, 0, 0, $Date[1], $i, $Date[0]) );
	$Return['Days'][ str_pad( $i, 2, 0, STR_PAD_LEFT ) ] = array(
		'DayWeek'	=>	$DayWeek,
		'Week'		=>	$Week
	);

	if( $DayWeek == 6 ){
		$Week++;
	}
}

echo json_encode( $Return );