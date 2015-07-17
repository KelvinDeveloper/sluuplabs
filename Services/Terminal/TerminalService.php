<?php

class Terminal{

	function Init(){
		global $PDO, $Database, $Conf, $Function;

		// $_POST['action'] = str_replace( '/: ', '', $_POST['action'] );

		$_POST['action'] = explode( ': ', $_POST['action'] );

		if( $_POST['action'][1] == 'ls' ){
			echo json_encode( $this->ListFolders() );
		}
		else if( strstr( $_POST['action'][1], 'cd ' ) ){
			echo json_encode( $this->navFolders() );
		}

	}

	function ListFolders(){
		global $PDO, $Database, $Conf, $Function, $Url;
		
		$Modules = dir( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] );
		$R['Message'] = '';

		while ( $Module = $Modules->read() ){
		
			$isDir = false;

			if( $Module != '.' && $Module != '..' ){

				$isDir = is_dir( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/' . $Module );

				$R['Message'] .= ( $isDir ? '<span style="color: rgba(25, 118, 210, 1)">' : false ) . $Module . ( $isDir ? '</span>' : false ) . '
';
			}
		}

		$R['Location'] = $_POST['action'][0] . ': ';

		return $R;
	}

	function navFolders(){

		$Location = explode( ' ', $_POST['action'][1] );

		$R['Location'] = $Location[1] . ': ';
		$R['Message']  = false;

		return $R;
	}

}

$Terminal = new Terminal;