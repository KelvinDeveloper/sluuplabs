<?php

class Terminal{

	function Init(){
		global $PDO, $Database, $Conf, $Function;

		$_POST['action'] = explode( ': ', $_POST['action'] );

		if( $_POST['action'][1] == 'ls' ){
			echo json_encode( $this->ListFolders() );
		}
		else if( strstr( $_POST['action'][1], 'cd ' ) ){
			echo json_encode( $this->navFolders() );
		}
		else if( strstr( $_POST['action'][1], 'mkdir ' ) ){
			echo json_encode( $this->Mkdir() );
		}
		else if( strstr( $_POST['action'][1], 'chmod ' ) ){
			echo json_encode( $this->Chmod() );
		}
		else if( strstr( $_POST['action'][1], 'rm ' ) ){
			echo json_encode( $this->Rm() );
		}
	}

	function getRoot(){
		return ROOT . '/Application/Users/' . $_SESSION['user']['id_user'];
	}

	function ListFolders(){
		global $PDO, $Database, $Conf, $Function, $Url;
		
		$Modules = dir( $this->getRoot() . $_POST['action'][0] );
		$R['Message'] = '';

		while ( $Module = $Modules->read() ){
		
			$isDir = false;

			if( $Module != '.' && $Module != '..' ){

				$isDir = is_dir( $this->getRoot() . $_POST['action'][0] . '/' . $Module );

				$R['Message'] .= ( $isDir ? '<span style="color: rgba(25, 118, 210, 1)">' : false ) . $Module . ( $isDir ? '</span>' : false ) . '
';
			}
		}

		$R['Location'] = $_POST['action'][0] . ': ';

		return $R;
	}

	function Mkdir(){
		global $PDO, $Database, $Conf, $Function, $Url;

		$Folder = ( substr( $_POST['action'][1], 0, -1 ) == '/' ? $_POST['action'][1] : '/' . $_POST['action'][1] );
		$Folder = str_replace( 'mkdir ', '', $Folder );

		chmod($this->getRoot(), 0777 );
		chmod($this->getRoot() . $_POST['action'][0], 0777 );

		mkdir( $this->getRoot() . $_POST['action'][0] . $Folder . '/' );
		
		$R['Location'] = $_POST['action'][0] . ': ';
		$R['Message']  = false;
		return $R;
	}

	function Chmod(){
		global $PDO, $Database, $Conf, $Function, $Url;

		$Ac = ( substr( $_POST['action'][1], 0, -1 ) == '/' ? $_POST['action'][1] : '/' . $_POST['action'][1] );
		$Ac = str_replace( 'chmod ', '', $Ac );
		$Ac = explode( ' ', $Ac );
		$L = false;
		$File = '';

		foreach ( $Ac as $Name ){
			if( $L == true ){
				$File .= $Name . ' ';
			}
			if( !empty( $Name ) ){
				$L = true;
			}
		}
		$File = substr( $File, 0, -1 );
		$P = str_replace( '/', '', $Ac[0] );

		if( file_exists( $this->getRoot() . $_POST['action'][0] . '/' . $File ) ){

			switch ( $P ) {
				case '777': // Ler/Gravar
					$A = chmod( $this->getRoot() . $_POST['action'][0] . '/' . $File, 0777 );	
					break;

				case '444': // Ler
					$A = chmod( $this->getRoot() . $_POST['action'][0] . '/' . $File, 0444 );	
					break;

				case '222': // Gravar
					$A = chmod( $this->getRoot() . $_POST['action'][0] . '/' . $File, 0444 );	
					break;

				case '644': // Apenas proprietario gravar
					$A = chmod( $this->getRoot() . $_POST['action'][0] . '/' . $File, 0444 );	
					break;

				default:
					$A = false;
					break;
			}

			if( $A ){
				$R['Location'] = $_POST['action'][0] . ': ';
				$R['Message']  = false;
			} else {
				$R['Location'] = $_POST['action'][0] . ': ';
				$R['Message']  = 'Error syntax, ex: chmod 777 [name_folder]';
			}

		} else {
			$R['Location'] = $_POST['action'][0] . ': ';
			$R['Message']  = 'chmod: não é possível acessar “' . $File . '”: Arquivo ou diretório não encontrado';
		}

		return $R;
	}

	function Rm(){

		$File = ( substr( $_POST['action'][1], 0, -1 ) == '/' ? $_POST['action'][1] : '/' . $_POST['action'][1] );
		$File = $this->getRoot() . $_POST['action'][0] . str_replace( 'rm ', '', $File );
		$Continue = true;

		if( file_exists( $File ) ){

			if( is_dir( $File ) ){

				$Folder = dir( $File );

				while ( $This = $Folder->read() ) {
					if( $This != '.' && $This != '..' ){
						$Continue = false;
					}
				}

				if( !$Continue ){

					$R['Location'] = $_POST['action'][0] . ': ';
					$R['Message']  = _('Para deletar a pasta deve estar vazia.');

					return $R;
				}

				if( rmdir( $File ) ){
					$R['Location'] = $_POST['action'][0] . ': ';
					$R['Message']  = false;
				} else {
					$R['Location'] = $_POST['action'][0] . ': ';
					$R['Message']  = _('Erro ao deletar arquivo/pasta');
				}

			} else {

				if( unlink( $File ) ){
					$R['Location'] = $_POST['action'][0] . ': ';
					$R['Message']  = false;
				} else {
					$R['Location'] = $_POST['action'][0] . ': ';
					$R['Message']  = _('Erro ao deletar arquivo/pasta');
				}

			}

		} else {
			$R['Location'] = $_POST['action'][0] . ': ';
			$R['Message']  = _('Arquivo/pasta não encontrado');
		}

		return $R;


	}

	function navFolders(){
		global $PDO, $Database, $Conf, $Function, $Url;

		$Location = explode( ' ', $_POST['action'][1] );
		$Location = ( $Location[1] == '/' ? '/' : ( substr( $_POST['action'], 0, 1 ) == '/' ? '/' . $Location[1] : $_POST['action'][0] . '/' . $Location[1] ) );
		$Location = str_replace( '//', '', $Location );
		$Location = ( substr( $Location, 0, 1 ) == '/' ? '' : '/' ) . $Location;

		if( file_exists( $this->getRoot() . $Location ) ){
			$R['Location'] = $Location . ': ';
			$R['Message']  = false;
		} else {
			$R['Location'] = $_POST['action'][0] . ': ';
			$R['Message']  = false;
		}

		return $R;
	}

}

$Terminal = new Terminal;