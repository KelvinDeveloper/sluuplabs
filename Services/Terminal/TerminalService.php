<?php

class Terminal{

	function Init(){
		global $PDO, $Database, $Conf, $Function;

		$_POST['action'] = str_replace( '/: ', '', $_POST['action'] );
		if( $_POST['action'] == 'ls' ){
			echo $this->ListFolders();
		}
	}

	function ListFolders(){
		global $PDO, $Database, $Conf, $Function, $Url;

		$Return = 'teste';
		
		$Modules = dir( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] );

while ( $Module = $Modules->read() ){
if( $Module != '.' && $Module != '..' ){
$Return .= $Module . '
';
}
}

		return $Return;
	}

}

$Terminal = new Terminal;