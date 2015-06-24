<?php
/*
	Class que inicia os módulos
*/
class Modules{

	function Run( $Module ){
		
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
				$Translate;
		/* Grava as configurações do módulo na variavel $thisModule */
		$thisModule = $ManagerModule[ $Module ];

		/* Define variaveis */
		$thisModule['Protect'] = isset( $thisModule['Protect'] ) ? $thisModule['Protect'] : false;

		/* Se for protegido, manda para Login */
		if( $thisModule['Protect'] === true ){
			$Services->Run('Login');
			if( !$Login->Verific() ){
				$_SESSION['HeaderURL'] = implode( '/', $Url );
				header( 'Location: /Login' );
				exit;
			}
		}
		
		/* Redireciona para outro módulo */
		if( !empty( $thisModule['Redirect'] ) ){
			$thisModule = $ManagerModule[ $thisModule['Redirect'] ];
		}

		/* Prepara variavel para usar na tag <title> */
		$Title = ( !empty( $thisModule['Title'] ) ? $thisModule['Title'] : Title );
		/* Verifica se o arquivo controller existe */
		if(	file_exists( ROOT . '/Modules/' . $thisModule['Controller'] . 'Controller.php' ) &&
			in_array( $thisModule['Name'], $ClientModules )
		 ){	
			/* Carregar HEAD HTML */
			if( ( $thisModule['Type'] === 'HTML' && empty( $Url[2] ) ||
				$thisModule['SubModule'][ $Url[2] ]['Type'] === 'HTML' || 
				$thisModule['SubModule']['Type'] === 'HTML' ||
				is_numeric( $Url[2] ) ) && 
				!$Function->isAjax() ){
				include ROOT . '/Public/Theme/' . $Conf['Global']['Theme'] . '/Head.phtml';
			}
			/* Include do controller */
			include ROOT . '/Modules/' . $thisModule['Controller'] . 'Controller.php';
			/* Carregar FOOTER HTML */
			if( ( $thisModule['Type'] === 'HTML' && empty( $Url[2] ) ||
				$thisModule['SubModule'][ $Url[2] ]['Type'] === 'HTML' ||
				$thisModule['SubModule']['Type'] === 'HTML' ||
				is_numeric( $Url[2] ) ) && 
				!$Function->isAjax() ){
				include ROOT . '/Public/Theme/' . $Conf['Global']['Theme'] . '/Footer.phtml';
			}

		} else {
			echo '<h1>Error loading module</h1>';
		}
	}
}