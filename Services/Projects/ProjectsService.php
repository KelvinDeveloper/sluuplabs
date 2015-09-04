<?php
class Projects{

	function Start( $Pjc, $Page ){

		$Location 			= ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $Pjc . '/';
		
		$Page = explode( '_', $Page );
		$Page = str_replace( '.pjc', '', $Page[1] );

		$Config   			= parse_ini_file( $Location . 'Config.pjc' );
		$Config['Location'] = $Location;
		$Config['PATH']     = ROOT . '/Modules/Projects/';
		$Config['PATH2']    = '/Modules/Projects/';
		$Config['Pjc']      = $Pjc;
		$Config['Page']		= $Page;

		/* Load Header */
		$Content = $this->LoadHeader( $Config );
		$Content .= $this->LoadGrid( $Config );

		return $Content;

	}

	function LoadHeader( $Config ){

		$Content = '';
		$CSS = 'Assets/Menu/' . $Config['HeaderMenu'] . '/styles.css';
		$JS  = 'Assets/Menu/' . $Config['HeaderMenu'] . '/scripts.js';

		if( file_exists( $Config['PATH'] . $CSS ) ){
			$Content .= '<link href="' . $Config['PATH2'] . $CSS . '" rel="stylesheet">';
		}

		if( file_exists( $JS ) ){
			$Content .= '<script type="text/javascript" src="' . $Config['PATH2'] . $JS . '"></script>';
		}

		$Content .= $this->LoadMenu( $Config );

		return $Content;
	}

	function LoadMenu( $Config ){

		/* Grava páginas em string */
		$Pages = dir ( $Config['Location'] . 'Pages' );
		$ListPages = '';

		while ( $Page = $Pages->read() ){
			if( $Page != '..' && $Page != '.' ){
				
				$This = parse_ini_file( $Config['Location'] . 'Pages/' . $Page );
				$ListPages .= '<a href="/' . $This['Url'] . '"><li>' . $This['Title'] . '</li></a>';
			}
		}
		/* Ends páginas */

		$fname   = $Config['PATH'] . 'Assets/Menu/' . $Config['HeaderMenu'] . '/index.phtml';
		$fhandle = fopen( $fname, 'r' );
		$content = fread( $fhandle, filesize( $fname ) );

		$content = str_replace( '{{ListPages}}', $ListPages, $content );
		return $content;		
	}

	function LoadGrid( $Config ){
		
		if( !file_exists( $Config['Location'] . 'Grids' ) ){
			mkdir( $Config['Location'] . 'Grids' );
			chmod( $Config['Location'] . 'Grids', 0777 );
		}

		if( !file_exists( $Location . 'Grids/' . $Config['Page'] ) ){
			mkdir( $Location . 'Grids/' . $Config['Page'] );
			chmod( $Location . 'Grids/' . $Config['Page'], 0777 );
		}

		$Grids = dir ( $Config['Location'] . 'Grids/' . $Config['Page'] );
		$Content = '';
		if( $Grids ){
			while ( $Grid = $Grids->read() ){
				if( $Grid != '..' && $Grid != '.' ){
					$This = parse_ini_file( $Config['Location'] . 'Grids/' . $Config['Page'] . '/' . $Grid . '/Config.pjc' );
					
					$Content .= '<div class="grid grid-' . $This['Layout'] . '" id="grid-' . str_replace( '.pjc', '', $Grid ) . '">';

					switch ( $This['Layout'] ){
						case '1':
							$Quant = 1;
							break;
						case '5':
						case '6':
						case '2':
							$Quant = 2;
							break;
						case '3':
							$Quant = 3;
							break;
						case '4':
							$Quant = 4;
							break;
					}

					for ( $i = 1; $i <= $Quant ; $i++ ){
						$Content .= '<div>';

						$Content .= '</div>';
					}

					$Content .= '</div>';
				}
			}
		}

		return $Content;
	}

	function LoadFooter( $Pjc ){


	}

}

$Projects = new Projects;