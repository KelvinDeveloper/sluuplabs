<?php

$Return['Status'] = false;

if( $_POST['value'] ){

	$Users = $Database->Fetch('users', false, "( Nome like '%" . $_POST['value'] . "%' OR Sobrenome like '%" . $_POST['value'] . "%' OR Email like '%" . $_POST['value'] . "%' ) AND id_user != '" . $_SESSION['user']['id_user'] . "' ");

	if( $Users ){
		while ( $U = $Users->fetch(PDO::FETCH_OBJ) ){
			$Return['users'][ $U->id_user ] = $U;
		}
		$Return['Status'] = true;
	}
}

if( count( $Return['users'] ) < 1 )
	$Return['Status'] = false;

echo json_encode( $Return );