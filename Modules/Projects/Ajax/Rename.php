<?php

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $_POST['pjc'] . '/Pages/';

$Old = explode( '_', $_POST['page'] );
$Old = $Old[1];

$Dir   = scandir( $Location );
$Quant = count( $Dir ) - 1;

$pUrl = $Function->RemoveAccents( $_POST['title'] );
$pUrl = str_replace( array( '.', ' ', '_' ), '-', $pUrl );

$filename = $pUrl;
$AllPages = '';

$Dir = dir( $Location );
while ( $This = $Dir->read() ){
	$nThis = explode( '_', $This );
	$AllPages[] = $nThis[1];
	$Consult[ $nThis[1] ] = $This;
}

$Return['Status'] = true;
$New = '';

if( !in_array( $filename . '.pjc', $AllPages ) ){
	
	$Open = parse_ini_file( $Location . $_POST['page'] );

	if( !$Open ){
		$Return['Status'] = false;
		$Return['Message'] = 'Erro ao abrir arquivo';
	}

	$pUrl = $Function->RemoveAccents( $_POST['title'] );
	$pUrl = str_replace( array( '.', ' ', '_' ), '-', $pUrl );

	$nName = $Quant . '_' . $pUrl . '.pjc';

	foreach ( $Open as $k => $v ){

		if( $k == 'Title' ){
			$New[ $k ] =  $_POST['title'];
		}
		else if( $k == 'Url' ){
			$New[ $k ] = $pUrl;
		} 
		else if( $k == 'File' ){
			$New[ $k ] = $nName;
		} else {
			$New[ $k ] = $v;
		}

	}

	rename( str_replace( '/Pages/', '/', $Location ) . 'Itens/' . $Open['Url'] , str_replace( '/Pages/', '/', $Location ) . 'Itens/' . $pUrl );

	if( !unlink( $Location . $_POST['page'] ) ){
		$Return['Status'] = false;
		$Return['Message'] = 'Erro ao deletar arquivo antigo';
	}

	if( !$Function->GenerateIni( $Location . $nName, $New ) ){
		$Return['Status'] = false;
		$Return['Message'] = 'Erro ao gerar arquivo';
	}

	foreach( $New as $key => $value ){
		$Return[ $key ] = $value;
	}

} 

else if( $filename . '.pjc' == $Old ){

	$Open = parse_ini_file( $Location . $_POST['page'] );

	$Return['Status'] = true;
	$pUrl = $Consult[ $filename . '.pjc' ];

	foreach( $Open as $key => $value ){
		$Return[ $key ] = $value;
	}

} else {

	$Return['Status'] = false;
	$Return['Message'] = 'Já existe uma página com este título';

}

echo json_encode( $Return );