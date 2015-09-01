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
		
		$Grids = dir ( $Config['Location'] . 'Grids/' . $Config['Page'] );
		$Content = '';

		while ( $Grid = $Grids->read() ){
			if( $Grid != '..' && $Grid != '.' ){
				
				$This = parse_ini_file( $Config['Location'] . 'Grids/' . $Config['Page'] . '/' . $Grid );
				
				$Content .= '<div class="grid grid-' . $This['Layout'] . '" id="grid-' . str_replace( '.pjc', '', $Grid ) . '">';

				switch ( $This['Layout'] ){
					case '1':
						
						break;
					
					case '2':
						// 50%50
						$Content .= '<div>';

						$Content .= '</div>';

						$Content .= '<div>';

						$Content .= '</div>';

						break;
				}

				$Content .= '</div>';
			}
		}

		return $Content;
	}

	function LoadFooter( $Pjc ){


	}

}

$Projects = new Projects;