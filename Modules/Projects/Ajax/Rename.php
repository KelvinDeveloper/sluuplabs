<?php

$pUrl = $Function->RemoveAccents( $_POST['title'] );
$pUrl = str_replace( array( '.', ' ', '_' ), '-', $pUrl );

$Return['Status'] = true;
$New = '';

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $_POST['pjc'] . '/Pages/';

if( !file_exists( $Location . $pUrl . '.pjc' ) ){

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

	// var_dump( unlink( $Location . $_POST['page'] ) );
	if( !unlink( $Location . $_POST['page'] ) ){
		$Return['Status'] = false;
		$Return['Message'] = 'Erro ao deletar arquivo antigo';
	}

	if( !$Function->GenerateIni( $Location . $pUrl . '.pjc', $New ) ){
		$Return['Status'] = false;
		$Return['Message'] = 'Erro ao gerar arquivo';
	}

} else {

	$Return['Status'] = false;
	$Return['Message'] = 'Já existe uma página com este título';

}

echo json_encode( $Return );