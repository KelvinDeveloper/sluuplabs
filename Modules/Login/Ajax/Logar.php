<?php

$Return['status'] = false;

if( empty( $_POST['email'] ) || empty( $_POST['pass'] ) ){
	$Return['message'] = 'EMPTY';
	echo json_encode( $Return );
	exit;
}
else if( !$Function->ValidateEmail( $_POST['email'] ) ){
	$Return['message'] = 'NOT_VALID_EMAIL';
	echo json_encode( $Return );
	exit;	
}

$Services->Run('Login');
echo $Login->Logar( $_POST['email'], $_POST['pass'] );