<?php

class Explorer{
	
	function Start( $Array ){

		global $Url;


		$LUrl = '';
		$Return = '';

		foreach ( $Url as $k => $v ){
			if( $k > 1 ){
				$LUrl .= $v . '/';
			}
		}

		$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/' . $LUrl;
		$FileLocation = '/Application/Users/' . $_SESSION['user']['id_user'] . '/' . $LUrl;

		$Dir = scandir( $Location );

		if( $Dir == true ){
			foreach ( $Dir as $Name ){

				$Type = $this->Type( $Location . $Name );

				if( 

					( $Name != '.' && $Name != '..' ) &&
					( !isset( $_GET['type'] ) || ( $Type == 'FOLDER' || strstr( $_GET['type'], $Type ) == true ) ) 
				){
					$Return[ $Name ] = array(
						'Name'		=> $Name,
						'Type'		=> $Type,
						'Location'	=> $FileLocation . $Name
					);
				}
			}
		}
		return $Return;
	}

	function Type( $File ){

		global $Function;

		if( $Function->is_image( $File ) ){
			return 'IMAGE';
		}

		else if( is_dir( $File ) ){
			return 'FOLDER';
		} else {

			return 'FILE';
		}

	}


}

$Explorer = new Explorer;