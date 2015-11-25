<?php
function __( $Value ){
	global $Client, $Conf, $Domain, $Translator, $Services, $Translate;

	// if( $Client->Type == '2' ){
	// 	if( !empty( $Url[1] ) ){

		// } else {
			// $File = pathinfo( $Conf['Pages'][ $Conf['Router']['Initial'] ]['File'] );
			// if( file_exists( ROOT . '/Public/Pages/' . $Domain[0] . '/' . $File['filename'] . '_' . Language . '.ini' ) ){
				// $Language = parse_ini_file( ROOT . '/Public/Pages/' . $Domain[0] . '/' . $File['filename'] . '_' . Language . '.ini' );
				
				$Language = parse_ini_file( ROOT . '/Application/Lang/' . Language . '.ini' );
				if( !empty( $Language[ $Value ] ) ){
					$Value = ( !empty( $Language[ $Value ] ) ? $Language[ $Value ] : $Value );
				}
				// else if( Language != $Conf['Global']['Language'] ){

				// 	$Services->Run('Translate');
				// 	$Result = $Translate->Translate( $Value, $Conf['Global']['Language'], Language );
				// 	$Value  = ( !empty( $Result ) ? $Result : $Value );
				// }

			// }
		// }
	// }

	return $Value;
}
