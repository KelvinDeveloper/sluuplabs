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

	foreach ( $Open as $k => $v ){

		if( $k == 'Title' ){
			$New[ $k ] =  $_POST['title'];
		}
		else if( $k == 'Url' ){

			$pUrl = $Function->RemoveAccents( $_POST['title'] );
			$pUrl = str_replace( array( '.', ' ', '_' ), '-', $pUrl );

			$New[ $k ] = $pUrl;

		} else {
			$New[ $k ] = $v;
		}

	}

	$pUrl = $Quant . '_' . $pUrl . '.pjc';

	if( !unlink( $Location . $_POST['page'] ) ){
		$Return['Status'] = false;
		$Return['Message'] = 'Erro ao deletar arquivo antigo';
	}

	if( !$Function->GenerateIni( $Location . $pUrl, $New ) ){
		$Return['Status'] = false;
		$Return['Message'] = 'Erro ao gerar arquivo';
	}

} 

else if( $filename . '.pjc' == $Old ){
	$Return['Status'] = true;
	$pUrl = $Consult[ $filename . '.pjc' ];

} else {

	$Return['Status'] = false;
	$Return['Message'] = 'Já existe uma página com este título';

}

if( $Return['Status'] == true ){
	$Return['File']  = $pUrl;
	$Return['Title'] = $_POST['title'];
}

echo json_encode( $Return );