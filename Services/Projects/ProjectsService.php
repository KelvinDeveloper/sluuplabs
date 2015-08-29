<?php
class Projects{

	function ReaderMenu( $Pjc ){
		$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $Pjc . '/';
		$Config   = parse_ini_file( $Location . 'Config.pjc' );
		$Config['Location'] = $Location;
		$Config['PATH']     = ROOT . '/Modules/Projects/';

		return $Config;
	}

	function LoadHeader( $Pjc, $Page ){

		return $this->LoadMenu( $Pjc, $Page );
	}

	function LoadMenu( $Pjc, $Page ){

		global $PATH;

		$Config   = $this->ReaderMenu( $Pjc );

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

	function LoadBlocks( $Pjc ){


	}

	function LoadFooter( $Pjc ){


	}

}

$Projects = new Projects;