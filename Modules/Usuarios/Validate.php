<?php

function onStart( $Array, $new ){
	global $Url;
}

function onEnd( $Array, $new, $id ){
	global $PDO, $Url, $Database;

	$Database->Insert('work_groups', 'name,user_create', "'Grupo Padrão', '" . $id . "'" );

	if( $new ){
		$wg = $PDO->lastInsertId();
		$Database->Update('users', "wg='" . $wg . "'", "id_user='" . $id . "'");
		mkdir( ROOT . '/Application/Groups/' . $wg . '/', 0777 );
		chmod( ROOT . '/Application/Groups/' . $wg . '/', 0777 );
	}
}