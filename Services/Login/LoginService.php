<?php
class Login{

	function Verific(){

		if( isset( $_SESSION['user'] ) ){
			return true;
		} else {
			return false;
		}

	}

	function getGroup( $id ){

		global $Database;
		return $Database->Search( 'work_groups', false, " user_create = " . $id . " OR user = " . $id, 'user_create DESC', false, 1 );
	}

	function Logar( $Email, $Password ){

		global $Database, $PDO, $Conf, $Domain;

		$Return['status'] = false;

		if( empty( $Email ) ){
			$Return['message'] = _('Email ou senha inválido');
			return json_encode( $Return );
		}

		else if( empty( $Password ) ){
			$Return['message'] = _('Email ou senha inválido');
			return json_encode( $Return );
		}

		$User = $Database->Search( $Conf['Login']['Table'], false, " Email = '" . $Email . "'" );

		if( !$User ){
			$Return['message'] = _('Email ou senha inválido');
			return json_encode( $Return );
		}

		if( $User->Password != md5( $Password ) ){
			$Return['message'] = _('Email ou senha inválido');
			return json_encode( $Return );
		}

		$WG = $this->getGroup( $User->id_user );

		$_SESSION['user'] = array(
			'id_user' 		=> $User->id_user,
			'Nome'			=> $User->Nome,
			'Email'			=> $User->Email,
			'Image'			=> $User->ImagePerfil,
			'Folder'		=> '/Application/Users/' . $User->id_user,
			'Path'			=> ( $WG->user_create == $User->id_user ? $WG->id_work_group : $WG->ide_work_group ),
		);

	    foreach ( $_SESSION['user']  as $k => $v ) {
	    	setcookie( 'HistoryUsers[' . $User->id_user . '][' . $k . ']', $v, $Conf['Cookie']['Expire'], '/' );
	    }

	    setcookie( 'ActiveUserLogin', $User->id_user, $Conf['Cookie']['Expire'], '/' );

		if( $_SESSION['user'] ){

			$Return['status'] = true;
			$Return['user']   = $_SESSION['user'];
			$Return['greeting'] = _('Olá');
			return json_encode( $Return );

		} else {

			$Return['status'] = _('Erro interno, tente novamente mais tarde');
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