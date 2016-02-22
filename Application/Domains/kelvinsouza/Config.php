<?php

if( getenv("PARAM1") == 'DEV' ){
	$Conf['Database'] = array(
		'Server' 	=> 'localhost',
		'Global' 	=> 'labs',
		'User'   	=> 'root',
		'Password' 	=> '',
		'Type' 		=> 'MySQL',
		'Decode'    => 'utf8'
	);
} else if( getenv("PARAM1") == 'PROD' ){
	$Conf['Database'] = array(
		'Server' 	=> '127.0.0.1',
		'Global' 	=> 'labs',
		'User'   	=> 'root',
		'Password' 	=> 'Q4w3e2r1',
		'Type' 		=> 'MySQL',
		'Decode'    => 'utf8'
	);
}

define( 'BD', 'labs' );
define( 'Title', 'Kelvin Souza' );

$Conf['Login']['Table'] = 'users';
$Conf['InitUrl'] = 'home';
$Conf['Type'] = 2; // 2 = Site