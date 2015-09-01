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

$Grid['Layout'] 	= $_POST['Layout'];
$Grid['Type']		= '';
$Grid['Content']	= '';
$Grid['UrlVideo']	= '';
$Grid['UrlImage']	= '';
$Grid['Link']		= '';
$Grid['Target']		= '';

if( $Function->GenerateIni( $Location . '/Grids/' . $Page . '/' . $Quant . '.pjc', $Grid ) ){
	$Grid['Status'] = true;
} else {
	$Grid['Status'] = false;
}

echo json_encode( $Grid );