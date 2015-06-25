<?php
class Lang{

	function Lang(){
		global $PDO, $Database, $Conf, $Function;
		
		if( isset( $_COOKIE['Language'] ) ){
			define( 'Language', $_COOKIE['Language'] );
		} else if( $Function->IPAdress() ){
			define( 'Language', $Function->IPAdress() );
		} else {
			define( 'Language', $Conf['Global']['Language'] );
		}

		setcookie( 'Language', Language, $Conf['Cookie']['Expire'], "/");
	}

	function ListLangs(){
		global $PDO, $Database, $Conf, $Function, $Url;

		$Link = '';
		foreach ( $Url as $k ) {
			if( !empty( $k ) )
			$Link .= '/' . $k;
		}

		if( is_array( $Conf['Global']['Languages'] ) ){
			$HTML = '<ul class="listLang">';
			foreach ( $Conf['Global']['Languages'] as $Lang ) {
				$HTML .= '<li><a href="/' . $Lang . $Link . '"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" class="flag flag-' . $Lang . '" /></a></li>';
			}
			$HTML .= '</ul>';
		}

		return $HTML;
	}

}

$Lang = new Lang;