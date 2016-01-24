<?php

$CalendarValues = '';

$Result = $Database->Fetch( 'calendar_' . $_SESSION['user']['Path'], 'date', " date LIKE '" . $_POST['First'] . "%' OR date LIKE '" . $_POST['Last'] . "%' OR date LIKE '" . $_POST['Now'] . "%'" );

while( $Value = $Result->fetch(PDO::FETCH_OBJ) ){

	$CalendarValues[ $Value->date ][] = '';
}

foreach ($CalendarValues as $k => $v) {
	$CalendarCounts[ $k ] = count( $v );
}

echo json_encode( $CalendarCounts );