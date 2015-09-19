<?php

// ini_set('display_errors',1);
// ini_set('display_startup_erros',1);
// error_reporting(E_ALL);

set_time_limit(0);
$Location = explode( '/', ROOT );

if( getenv("PARAM1") == 'DEV' ){
	$IPServer = $_SERVER["SERVER_ADDR"];
} else {
	$IPServer = '93.188.164.247';
}

require ROOT . '/Application/Class/class.PHPWebSocket.php';

// when a client sends data to the server
function wsOnMessage($clientID, $message, $messageLength, $binary) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	// check if message length is 0
	if ($messageLength == 0) {
		$Server->wsClose($clientID);
		return;
	}

	//The speaker is the only person in the room. Don't let them feel lonely.
	if ( sizeof($Server->wsClients) == 1 )
		$Server->wsSend($clientID, "");
	else
		//Send the message to everyone but the person who said it
		foreach ( $Server->wsClients as $id => $client )
			if ( $id != $clientID )
				$Server->wsSend($id, $message);
}

// when a client connects
function wsOnOpen($clientID)
{
	global $Server, $Database, $PDO, $Function;

	$User = $Function->WebsocketUser( $clientID );

	$ip = long2ip( $Server->wsClients[$clientID][6] );

	//Send a join notice to everyone but the person who joined
	foreach ( $Server->wsClients as $id => $client )
		if ( $id != $clientID )
			
			$Server->wsSend($id, "{{USER_CONNECT}}=>" . $User);
}

// when a client closes or lost connection
function wsOnClose($clientID) 
{
	global $Server, $Database;
	$ip = long2ip( $Server->wsClients[$clientID][6] );
	
	$Socket = $Database->Search('user_status', false, "ide_websocket='" . $clientID . "'" );
	//Send a user left notice to everyone in the room
	foreach ( $Server->wsClients as $id => $client )
		$Server->wsSend($id, "{{USER_DISCONNECT}}=>" . $Socket->ide_user);
		$Database->Delete('user_status', "ide_websocket='" . $clientID . "'");
}

// start the server
$Server = new PHPWebSocket();

$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');
// for other computers to connect, you will probably need to change this to your LAN IP or external IP,
// alternatively use: gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME']))
$Server->wsStartServer( $IPServer, 9301);