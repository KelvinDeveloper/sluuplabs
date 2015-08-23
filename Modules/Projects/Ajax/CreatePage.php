<?php

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/';

$pUrl = $Function->RemoveAccents( $_POST['Page'] );
$pUrl = str_replace( array( '.', ' ', '_' ), '-', $pUrl );

$Page['Title'] 	= $_POST['Page'];
$Page['Url']	= '/' . $pUrl;

if( $Function->GenerateIni( $Location . $_POST['Pjc'] . '/Pages/' . $pUrl . '.pjc', $Page ) ){
	$Page['Status'] = true;
} else {
	$Page['Status'] = false;
}

echo json_encode( $Page );