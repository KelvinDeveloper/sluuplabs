<?php
class Login{

	function Verific(){

		if( isset( $_SESSION['user'] ) ){
			return true;
		} else {
			return false;
		}

	}

	function Logar( $Email, $Password ){

		global $Database, $PDO, $Conf, $Domain;

		$Return['status'] = false;

		if( empty( $Email ) ){
			$Return['message'] = 'ERROR_EMAIL';
			return json_encode( $Return );
		}

		else if( empty( $Password ) ){
			$Return['message'] = 'ERROR_PASSWORD';
			return json_encode( $Return );
		}

		$User = $Database->Search( $Conf['Login']['Table'], false, " Email = '" . $Email . "'" );

		if( !$User ){
			$Return['message'] = 'ERROR_USER_EMAIL';
			return json_encode( $Return );
		}

		if( $User->Password != md5( $Password ) ){
			$Return['message'] = 'ERROR_USER_PASSWORD';
			return json_encode( $Return );
		}

		$_SESSION['user'] = array(
			'id_user' 		=> $User->id_user,
			'Nome'			=> $User->Nome,
			'Email'			=> $User->Email,
		);

		setcookie( 'Email', $User->Email, $Conf['Cookie']['Expire'] );

		if( $_SESSION['user'] ){

			$Return['status'] = true;
			$Return['user']   = $_SESSION['user'];
			return json_encode( $Return );

		} else {

			$Return['status'] = 'ERROR_LOGAR';
			return json_encode( $Return );
		}

	}

	function Lagout(){

		foreach ( $_SESSION as $k => $v ) {
			foreach ( $v as $k2 => $v2 ) {
				unset( $_SESSION[ $v2 ] );
				session_destroy( $_SESSION[ $v2 ] );
			}
			unset( $_SESSION[ $v ] );
			session_destroy( $_SESSION[ $v2 ] );
		}
		unset( $_SESSION );
		session_unset(); 
		session_destroy( $_SESSION );

		if( empty( $_SESSION ) ){
			echo '<script>location.href = "/";</script>';
			return '1';
		} else {
			return 'ERROR_LAGOUT';
		}

	}

	function Remember( $thisEmail ){

		global $Email, $Database, $PDO, $Services, $Conf;

		if( empty( $thisEmail ) ){
			return 'ERROR_EMAIL';
		}

		$User    = $Database->Search( 'users' , false, " Email = '" . $thisEmail . "'" );
		$Title   = 'Alterar Senha - ' . Title;
		$Message = 'Olá ' . $User->Nome . ', <br>
					Para altarar sua senha basta <a href="' . $Conf['Email']['Url'] . '/Login/Alterar-Senha/' . md5( $User->id_user . Title . $User->Cadastro . time() ) . '">clicar aqui</a> <br>
					ou copie e cole e seguinte endereço no seu navegador:<br> ' . $Conf['Email']['Url'] . '/Login/Alterar-Senha/' . md5( $User->id_user . Title . $User->Cadastro . time() ) . '<br><br>
					<i>Obs.: Este email é enviado de forma automática, favor não responder.</i> <br><br>
					<b>' . Title . '</b> <br><br>';

		$Database->Update( 'users', "AlterPass = '" . md5( $User->id_user . Title . $User->Cadastro . time() ) . "'", "email = '" . $User->Email . "'" );
		$Services->Run('Email');

		if( $Email->AddQueue( $User->Nome, $User->Email, $Title, $Message ) ){
			return true;
		} else {
			return false;
		}

	}

	function SavePass( $Validation, $Password ){

		global $Database, $PDO;

		if( !$Database ){ $Database = BD; }

		$User = $Database->Search( 'users', false, " AlterPass = '" . $Validation . "'" );
		if( $User && !empty( $Password ) ){
			if( $Database->Update( 'users', " Password = '" . md5( $Password ) . "', AlterPass = ''", " id_user = '" . $User->id_user . "'" ) !== false ){
				return true;
			} else {
				return false;
			}
		}

	}
}

$Login = new Login;