<?php

if( !empty( $_POST['name'] ) ){
	if( $Database->Update('work_groups', "name='" . $_POST['name'] . "'", "user_create='" . $_SESSION['user']['id_user'] . "'") ){
		$Return['Status'] = true;
	} else {
		$Return['Status'] = false;
	}
} else {
	$Return['Status'] = false;
}

echo json_encode( $Return );