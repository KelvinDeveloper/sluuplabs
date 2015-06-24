<?php
header('Access-Control-Allow-Origin: *');
ob_start();
session_start();
include 'Services.php';
include 'ServicesRun.class.php';
$Services = new Services();
/* Arquivo de Idioma */
$Services->Run('Lang');
include 'Language.php';
include 'System/Config.php';
include 'Functions.class.php';
$Function = new RunFunction();
$Date  = new DateTime( 'now', new DateTimeZone( $Conf['Date']['TimeZone'] ) );
date_default_timezone_set( $Conf['Date']['TimeZone'] );
/* Inicia a conexão com banco de dados */
$Services->Run('Connection');
include ROOT . '/Application/ModulesRun.class.php';
/* Inicia a classe de modulos */
$Modules = new Modules();
/* Redireciona para outro módulo */
if( $Url[1] == 'Cron' ){ // Arquivos de Cron
	include ROOT . '/Application/System/Cron/' . str_replace( '.cron', '.php', $Url[2] );
}
else if( $Url[1] == 'Websocket' && $Url[2] == 'Run' ){ // Inicia conexão com websocket
	include ROOT . '/Application/Websocket.php';
}
// else if( $Client->Type == 2 && ( !in_array( $thisModule['Name'], $ClientModules ) || ( empty( $thisModule['Name'] ) || empty( $Url[1] ) ) ) ){ /* Carrega página (Caso for Website) */
// 	$Services->Run('Pages');
// 	$Pages->View();
// } else { /* Carrega o modulo de acordo com a URL (Caso for Sistema) */
// 	$Modules->Run( ( empty( $Url[1] ) ? $Conf['Router']['Initial'] : $Url[1] ) );
// }
ob_end_flush();