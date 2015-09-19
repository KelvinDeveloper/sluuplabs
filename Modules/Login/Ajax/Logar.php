<?php

$Return['status'] = false;

if( empty( $_POST['email'] ) || empty( $_POST['pass'] ) ){
	$Return['message'] = _('Digite o seu email e senha');
	echo json_encode( $Return );
	exit;
}
else if( !$Function->ValidateEmail( $_POST['email'] ) ){
	$Return['message'] = _('Digite um email válido');
	echo json_encode( $Return );
	exit;	
}

$Services->Run('Login');
echo $Login->Logar( $_POST['email'], $_POST['pass'] );