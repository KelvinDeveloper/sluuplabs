<?php

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $_POST['Pjc'] . '/';

$Page  = json_decode( $_POST['Page'] );

$Array['Type']   = 'VIDEO';
$Array['Value']  = $_POST['Value'];
$Array['Width']  = '';
$Array['Height'] = '';
$Array['Left']   = '';
$Array['Top']   = '';

$Dir = scandir( $Location . 'Itens/' . $Page->{'Url'} );

if( $Function->GenerateIni( $Location . 'Itens/' . str_replace( '/', '', $Page->{'Url'} ) . '/' . ( count( $Dir ) - 1 ) . '.pjc', $Array ) ){
	$Array['Status'] = true;
} else {
	$Array['Status'] = false;
}

echo json_encode( $Array );