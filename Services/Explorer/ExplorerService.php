<?php

class Explorer{
	
	function Start( $Array ){

		global $Url;


		$LUrl = '';
		$Return = array();
		$ReturnFolder = array();

		foreach ( $Url as $k => $v ){
			if( $k > 1 && !empty( $v ) ){
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
					( empty( $_GET['type'] ) || ( $Type == 'FOLDER' || strstr( $_GET['type'], $Type ) == true ) ) 
				){

					if( $Type == 'FOLDER' ){
						$ReturnFolder[ $Name ] = array(
							'Name'		=> $Name,
							'Type'		=> $Type,
							'Location'	=> $FileLocation . $Name
						);
					} else {
						$Return[ $Name ] = array(
							'Name'		=> $Name,
							'Type'		=> $Type,
							'Location'	=> $FileLocation . $Name
						);
					}
				}
			}
		}

		$Return = array_merge( $ReturnFolder, $Return );

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

	function Icon( $File ){

		$Link = explode( 'sluup', $File );

		switch ( $this->Type( $File ) ) {
			case 'IMAGE':
				return '<div class="eIcon" style="background-image:url({Location});"></div>';
				break;

			case 'FOLDER':
				return '<i class="material-icons">&#xE2C7;</i>';
				break;

			default:
				return '<i class="material-icons">&#xE63B;</i>';
				break;
		}
	}


}

$Explorer = new Explorer;