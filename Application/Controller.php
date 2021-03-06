<?php
header('Access-Control-Allow-Origin: *');
define( 'ROOT', $_SERVER["DOCUMENT_ROOT"] );
ob_start();
session_start();
include 'Functions.class.php';
$Function = new RunFunction();
include 'Services.php';
include 'ServicesRun.class.php';
$Services = new Services();
/* Arquivo de Idioma */
$Services->Run('Lang');
include 'Language.php';
include 'System/Config.php';
$Date  = new DateTime( 'now', new DateTimeZone( $Conf['Date']['TimeZone'] ) );
date_default_timezone_set( $Conf['Date']['TimeZone'] );
/* Inicia a conexão com banco de dados */
$Services->Run('Connection');
include ROOT . '/Application/ModulesRun.class.php';
/* Inicia a classe de modulos */
$Modules = new Modules();
/* Redireciona para outro módulo */
/* Altera grupo de trabalho */
if( $Url[1] === 'AlterGroup' ){
	if( $Database->Search( 'work_groups', false, " ( id_work_group = '" . $Url[2] . "' || ide_work_group = '" . $Url[2] . "' ) && ( user_create = " . $_SESSION['user']['id_user'] . " OR user = " . $_SESSION['user']['id_user'] . ' ) ', 'user_create DESC', false, 1 ) ){
		$_SESSION['user']['Path'] = $Url[2];
	}
	unset( $Url );
}
if( $Url[1] == 'Cron' ){ // Arquivos de Cron
	include ROOT . '/Application/System/Cron/' . str_replace( '.cron', '.php', $Url[2] );
}
else if( $Url[1] == 'Websocket' && $Url[2] == 'Run' ){ // Inicia conexão com websocket
	include ROOT . '/Application/Websocket.php';
} 
else if( $Url[1] === 'Action' && $Function->isAjax() ){
	include ROOT . '/Application/Action/' . $Url[2] . '.php';
}
else if( $Url[1] === 'SendTerminal' && $Function->isAjax() ){
	$Services->Run('Terminal');
	$Terminal->Init();
}
else if( $Url[2] === 'Ajax' && ( $Function->isAjax() || getenv("PARAM1") == 'DEV' ) ){
	include ROOT . '/Modules/' . $Url[1] . '/Ajax/' . $Url[3] . '.php';
} 
else if( $Url[1] === 'app' ){ 
	include ROOT . '/app/' . $Url[2] . '/' . $Url[3] . '/View.phtml';
}
else if( $Url[1] === 'Upload' && !empty( $_POST ) ){
	
	$Services->Run('Explorer');
	$Services->Run('Upload');
}
else if( $Conf['Type'] == 2 ){
	// Website
	include ROOT . '/Websites/' . $Domain[0] . '/Urls.php';
	$File = ROOT . '/Websites/' . $Domain[0] . '/' . $Router[ ( empty( $Url[1] ) ?  $Conf['InitUrl'] : $Url[1] ) ];
	$Path = '/Websites/' . $Domain[0] . '/HTML/';

	if( file_exists( $File ) ){
		include $File;
	} else {
		echo 'Url inixistente';
	}
} else {

	// Verifica se usuario está logado para ler os registros
	$Services->Run('Login');
	if( $Login->Verific() ){
		if( file_exists( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/reg.ini' ) ){
			$reg = parse_ini_file( ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/reg.ini' );
		}
	}
	// Verifica o arquivo Urls (Responsável pelo roteamento do link)
	include ROOT . '/Application/System/Urls.php';
	$ThisRouter = ( isset( $Router[ $Domain[0] ][ $Url[1] ] ) ? $Router[ $Domain[0] ][ $Url[1] ] : false );
	if( !empty( $ThisRouter ) ){
		$ThisRouter = explode( '/', $ThisRouter );
		if( $ThisRouter[0] == 'Modules' ){
			$Conf['ModelInfo'] = parse_ini_file( ROOT . '/Modules/' . $ThisRouter[1] . '/Info.ini' );
			if( ( isset( $DesktopLoad ) || $ThisRouter[1] == 'Desktop' ) || $Function->isAjax() ){
				$Modules->Run( $ThisRouter[1], $ThisRouter[2] );
			} else {
				$_SESSION['OpenModule'] = $ThisRouter;
				if( $Login->Verific() ){
					$Modules->Run( 'Desktop', 'View' );
				} else {
					$Modules->Run( 'Login', 'View' );
				}
			}
		}
	}
}
ob_end_flush();