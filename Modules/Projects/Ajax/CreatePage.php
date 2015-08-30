<?php

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/';

$pUrl = $Function->RemoveAccents( $_POST['Page'] );
$pUrl = str_replace( array( '.', ' ', '_' ), '-', $pUrl );

$Dir   = scandir( $Location . $_POST['Pjc'] . '/Pages/' );
$Quant = count( $Dir ) - 1;

$Page['Title'] 	= $_POST['Page'];
$Page['Url']	= '/' . $pUrl;
$Page['File']	= $Quant . '_' . $pUrl . '.pjc';

if( $Function->GenerateIni( $Location . $_POST['Pjc'] . '/Pages/'. $Quant . '_' . $pUrl . '.pjc', $Page ) ){
	$Page['Status'] = true;
} else {
	$Page['Status'] = false;
}

echo json_encode( $Page );