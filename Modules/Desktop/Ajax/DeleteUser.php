<?php

$Response['Status'] = false;

if( $Database->Delete( 'work_groups', 'ide_work_group = ' . $_POST['id'] . ' AND user = ' . $_POST['user'] ) ){
	$Response['Status'] = true;
}

echo json_encode( $Response );