<?php
if( $_REQUEST ){
	if( $_REQUEST['Module'] == 'User' ){

		$New = '';

		$Open = parse_ini_file( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/reg.ini', true );
		foreach ( $Open as $Module => $Data ){

$New .= '[Desktop]
';

			foreach ( $Data as $k => $v ){
				if( $k == $_POST['Key'] ){
$New .= $k . '=' . $_POST['Value'] . '
';
				} else {
$New .= $k . '=' . $v . '
';
				}
			}

			unlink( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/reg.ini' );
			$Init = fopen( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/reg.ini', 'a+' );
			$Edit = fwrite( $Init, $New );
			fclose( $Init );
			chmod( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/reg.ini', 0777 );
		}
	}
}