<?php
$Modules = dir( ROOT . '/Modules/' );

while ( $Module = $Modules->read() ){
	if( file_exists( ROOT . '/Modules/' . $Module . '/Info.ini' ) ){
		$Info = parse_ini_file( ROOT . '/Modules/' . $Module . '/Info.ini' );
		if( $Info['ListStart'] == true ){
			$ListModules[ $Module ] = array(
				'name'	=> $Module,
				'info'	=> $Info,
				'icon'	=> ( file_exists( ROOT . '/Modules/' . $Module . '/Icon.ico' ) ? '/Modules/' . $Module . '/Icon.ico' : '/Public/img/icon/Icon.ico' )
			);
		}
	}
}

echo json_encode( $ListModules );