<?php
$Json = '';

$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/' . $_POST['Pjc'];

$Pages = explode( ';', $_POST['Sequence'] );
foreach( $Pages as $val ){
	if( !empty( $val ) ){
		$v = explode( ':', $val );
		$r = explode( '_', $v[0] );
		$r = $v[1] . '_' . $r[1];

		rename( $Location . '/Pages/' . $v[0], $Location . '/Pages/' . $r );
		$Json[ $v[0] ] = $r;
	}
}

echo json_encode( $Json );