<?php
/*
	Class que inicia os módulos
*/
class Modules{

	function Run( $Module, $View ){
		
		global	$ManagerModule, $Function, $Services, $Modules, $Url, $Title,
				/* Menu */
				$Menu,
				/* Login */
				$Login,
				/* Database */
				$Database, $PDO,
				/* Confg Sistema */
				$Conf,
				/* Formulários */
				$Form,
				/* Upload */
				$Upload, $ConfUpload, 
				/* Image */
				$Image,
				/* Grid */
				$Grid,
				/* Dominio */
				$Domain, $Client, $ClientModules,
				/* Email */
				$Email,
				/* Categorias */
				$Categorias,
				/* Users */
				$Users,
				/* Chat */
				$Chat,
				/* Robo */
				$Robo,
				/* Lang */
				$Lang,
				$Translate,
				/* autoSystem */
				$autoSystem,
				$reg;

		/* Se for protegido, manda para Login */
		$Services->Run('Login');
		if( !$Login->Verific() && $Url[1] != 'Login' ){
			$_SESSION['HeaderURL'] = implode( '/', $Url );
			header( 'Location: /Login' );
			exit;
		}
		/* Verifica se existe a view */
		if(	file_exists( ROOT . '/Modules/' . $Module . '/' . $View . '.phtml' ) ){

			/* lê registros do modulo */
			if( file_exists( ROOT . '/Modules/' . $Module . '/reg.ini' ) ){
				$reg_module = parse_ini_file( ROOT . '/Modules/' . $Modules . '/reg.ini' );
			}

			/* Carregar HEAD HTML */
			if( !$Function->isAjax() ){
				include ROOT . '/Public/Theme/Default/Head.phtml';
			}
			/* Include da view */
			include ROOT . '/Modules/' . $Module . '/' . $View . '.phtml';
			/* Carregar FOOTER HTML */
			if( !$Function->isAjax() ){
				include ROOT . '/Public/Theme/Default/Footer.phtml';
			}

			return true;

		} else {
			echo '<h1>Error loading module</h1>';
			return false;
		}
	}
}