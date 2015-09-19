<?php

parse_str( $_POST['array'], $Array );
$Return = array();

if( $Array ){

	$Location = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . '/Projects/';

	if( !file_exists( $Location ) ){
		mkdir( $Location );
		chmod( $Location, 0777 );
	}

	if( !file_exists( $Location  . $Array['nome_projeto'] ) ){
		
		mkdir( $Location . $Array['nome_projeto'] );
		chmod( $Location . $Array['nome_projeto'], 0777 );

		if( !file_exists( $Location . $Array['nome_projeto'] . 'Pages/' ) ){
			mkdir( $Location . $Array['nome_projeto'] . '/Pages/' );
			chmod( $Location . $Array['nome_projeto'] . '/Pages/', 0777 );
		}

		$Array['Autor']	= $_SESSION['user']['Nome'];
		$Array['Date']  = date("Y-m-d H:i:s");
		$Array['Index'] = 'index.pjc';
		$Array['HeaderMenu']	= 'Default';

		$Index['Title'] = 'Home';
		$Index['Url']	= 'index';

		$Function->GenerateIni( $Location . $Array['nome_projeto'] . '/Config.pjc', $Array );
		$Function->GenerateIni( $Location . $Array['nome_projeto'] . '/Pages/1_index.pjc', $Index );

		$Return['Projeto']	= $Array['nome_projeto'];
		$Return['Message'] 	= _('Projeto criado com sucesso');
		$Return['Status']	= true;

	} else {

		$Return['Message'] 	= _('Erro projeto já existe');
		$Return['Status']	= false;
	}

} else {
	$Return['Message'] 	= _('Erro no post');
	$Return['Status']	= false;
}

echo json_encode( $Return );