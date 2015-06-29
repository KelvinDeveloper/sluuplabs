<?php
$Modules = dir( ROOT . '/Modules/' );

while ( $Module = $Modules->read() ){
	if( file_exists( ROOT . '/Modules/' . $Module . '/Info.ini' ) ){
		$Info = parse_ini_file( ROOT . '/Modules/' . $Module . '/Info.ini' );
		if( $Info['ListStart'] == true ){
			$ListModules[ $Module ] = $Info;
		}
	}
}

echo json_encode( $ListModules );