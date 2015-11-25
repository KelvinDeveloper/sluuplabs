<?php

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $_POST['Pjc'] . '/';
$Page = explode( '_', $_POST['Page'] );
$Page = str_replace( '.pjc', '', $Page[1] );

if( !file_exists( $Location . 'Grids' ) ){
	mkdir( $Location . 'Grids' );
	chmod( $Location . 'Grids', 0777 );
}

if( !file_exists( $Location . 'Grids/' . $Page ) ){
	mkdir( $Location . 'Grids/' . $Page );
	chmod( $Location . 'Grids/' . $Page, 0777 );
}

$Dir   = scandir( $Location . '/Grids/' . $Page );
$Quant = count( $Dir ) - 1;

mkdir( $Location . '/Grids/' . $Page . '/' . $Quant );

$Grid['Layout'] 	= $_POST['Layout'];

if( $Function->GenerateIni( $Location . '/Grids/' . $Page . '/' . $Quant . '/Config.pjc', $Grid ) ){
	$Grid['Status'] = true;
} else {
	$Grid['Status'] = false;
}

echo json_encode( $Grid );