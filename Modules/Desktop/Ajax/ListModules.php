<?php
$Modules = dir( ROOT . '/Modules/' );
$Create = $Database->Search('work_groups', 'user_create', "id_work_group = " . $_SESSION['user']['Path']);

while ( $Module = $Modules->read() ){
	if( file_exists( ROOT . '/Modules/' . $Module . '/Info.ini' ) ){
		$Info = parse_ini_file( ROOT . '/Modules/' . $Module . '/Info.ini' );
		if( $Info['ListStart'] == true ){

			if( ( $Module != 'Usuarios' || $Create->user_create === $_SESSION['user']['id_user'] ) &&
				( $Module != 'Terminal' || $Module == 'Terminal' && $_SESSION['user']['id_user'] == '1' ) ){

				$ListModules[ $Module ] = array(
					'name'	=> $Module,
					'info'	=> $Info,
					'icon'	=> ( file_exists( ROOT . '/Modules/' . $Module . '/Icon.ico' ) ? '/Modules/' . $Module . '/Icon.ico' : '/Public/img/icon/Icon.ico' )
				);
			}
		}
	}
}

echo json_encode( $ListModules );