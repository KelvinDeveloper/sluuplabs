<?php

$Conf['Database'] = array(
	'Server' 	=> 'localhost',
	'Global' 	=> 'labs',
	'User'   	=> 'root',
	'Password' 	=> '',
	'Type' 		=> 'MySQL',
	'Decode'    => 'utf8'
);

define( 'BD', 'labs' );
define( 'Title', 'Sluup Labs' );

$Conf['Login']['Table'] = 'users';
$Conf['InitUrl'] = '/Desktop';