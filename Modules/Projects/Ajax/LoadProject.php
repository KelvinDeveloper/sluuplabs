<?php

$File  = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $_REQUEST['Pjc'] . '/';
$Pages = dir( $File . 'Pages' );

$aPages = '';

while ( $Page = $Pages->read() ){
	if( $Page != '..' && $Page != '.' ){
		$aPages[ $Page ] = parse_ini_file( $File . 'Pages/' . $Page );
	}
}

$Return['Config'] 	= parse_ini_file( $File . 'Config.pjc' );
$Return['Pages']	= $aPages;

echo json_encode( $Return );