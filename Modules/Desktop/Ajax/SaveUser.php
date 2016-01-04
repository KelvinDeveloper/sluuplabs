<?php

$Response['Status'] = false;

if( $Database->Insert( 'work_groups', 'ide_work_group, user', $_POST['id'] . ', ' . $_POST['user'] ) ){
	$Response['Status'] = true;
}

echo json_encode( $Response );