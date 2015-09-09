<?php
if( strpos( $_SERVER['HTTP_HOST'], '.dev' ) == false ){
	// Esconde erros quando aplicação for execultada em prod
	ini_set('display_errors', 0 );
	error_reporting(0);
}

$PrefixLang = array( 'ab','aa','af','ay','ak','sq','de','am','ar','an','hy','as','av','ae','az','bm','ba','bn','bh','be','my','bi','bs','br','bg','ks','km','kn','ca','ch','ce','cs','ny','zh','za','cv','si','ko','kw','co','cr','hr','da','dz','cu','sk','sl','es','eo','et','ee','fo','fj','fi','fr','fy','ff','gd','cy','gl','ka','el','kl','gn','gu','ht','ha','he','hz','hi','ho','hu','io','ig','id','en','ia','iu','ik','ga','is','it','ja','jv','kr','kk','ki','ky','rn','kv','kg','kj','ku','lo','la','lv','li','ln','lt','lu','lg','lb','mk','ml','ms','dv','mg','mt','gv','mi','mr','mh','mo','mn','na','nv','nd','nr','ng','nl','ne','no','nb','nn','ie','oc','oj','or','om','os','pi','pa','ps','fa','pl','pt','qu','rm','rw','ro','ru','se','sm','sg','sa','sc','sr','st','tn','sn','sd','so','sw','ss','sv','su','tl','ty','th','ta','tt','tg','te','bo','ti','to','ts','tr','tk','tw','uk','ug','ur','uz','wa','eu','ve','vi','vo','wo','xh','ii','yi','yo','zu', 'us', 'pt-br', );

if( strstr( $_SERVER['REQUEST_URI'], '?' ) ){

	$Url = explode( '?', $_SERVER ['REQUEST_URI'] );
	$ArrayGET = explode( '&', $Url[1] );

	foreach ( $ArrayGET as $Value ){
		$This = explode( '=', $Value );
		$_GET[ $This[0] ] = $This[1];
	}

	$Url = $Url[0];
} else {
	$Url = $_SERVER['REQUEST_URI'];
}

$Url = explode( '/', str_replace( 'www.', '',  $Url ) );

if( in_array( $Url[1], $PrefixLang ) ){
	
	$NewUrl = explode( '/', str_replace( 'www.', '',  str_replace( $Url[1] . '/', '', str_replace( $Url[1], '', $_SERVER ['REQUEST_URI'] ) ) ) );

	if( $Url[1] == 'br' ){
		$Url[1] = 'pt-BR';
	}

	setcookie( 'Language', $Url[1], $Conf['Cookie']['Expire'], "/");
	$_COOKIE['Language'] = $Url[1];

	$Url2[] = '';

	foreach ( $NewUrl as $k ){
		if( !empty( $k ) )
		$Url2[] = $k;
	}

	$Url = $Url2;
}

$Domain = explode( '.', str_replace( 'www.', '', $_SERVER['SERVER_NAME'] ) );

$Conf['Queue']	= array(
	'Process'	=> 10,
	'Try'		=> 3,
);

$Conf['Cookie']['Expire'] = time()+60*60*24*30;
$Conf["Date"] = array(
	'TimeZone' => 'America/Sao_Paulo'
);

/* Include Domain Config */
require ROOT . '/Application/Domains/' . $Domain[0] . '/Config.php';