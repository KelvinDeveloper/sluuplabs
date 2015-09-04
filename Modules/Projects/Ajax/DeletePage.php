<?php

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/';

if( unlink( $Location . $_POST['Pjc'] . '/Pages/' . $_POST['Page'] ) ){
	$Return['Status'] = true;
} else {
	$Return['Status'] = false;
}

echo json_encode( $Return );