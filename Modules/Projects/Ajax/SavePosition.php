<?php

if( !$_POST ){ exit; }
$New = '';
$Page = json_decode( $_POST['Page'] );

$Open = parse_ini_file( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $_POST['Pjc'] . '/Itens/' . str_replace( '/', '', $Page->{'Url'} ) . '/' . str_replace( 'item-', '', $_POST['Item'] ) );

foreach ( $Open as $key => $value){
	$Array[ $key ] = "'" . $value . "'";
}

$Array['Left'] = $_POST['Left'];
$Array['Top']  = $_POST['Top'];

unlink( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $_POST['Pjc'] . '/Itens/' . str_replace( '/', '', $Page->{'Url'} ) . '/' . str_replace( 'item-', '', $_POST['Item'] ) );
$Function->GenerateIni( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $_POST['Pjc'] . '/Itens/' . str_replace( '/', '', $Page->{'Url'} ) . '/' . str_replace( 'item-', '', $_POST['Item'] ), $Array );