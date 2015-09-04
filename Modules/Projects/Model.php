<?php

$pUrl = '';

if( empty( $Url[2] ) ){
	$pUrl = 'Public/Blocks/InitialProject.phtml';
} else {
	$pUrl = 'Public/Blocks/' . $Url[2] . 'Project.phtml';
} 