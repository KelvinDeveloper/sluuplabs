<?php
class Services {
	
	function Run( $Service ){
		global 	$ManagerService, 
				/* Database */
				$PDO, $Database, $Conf,
				/* Login */
				$Login,
				/* Email */
				$Email,
				/* Form */
				$Form,
				/* Upload */
				$Upload, $ConfUpload,
				/* Image */
				$Image,
				/* Grid */
				$Grid,
				/* Pages */
				$Pages,
				/* Categorias */
				$Categorias,
				/* Websocket */
				$Websocket,
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
				$autoSystem
				;

		$thisService = $ManagerService[ $Service ];
		$ClassesRun = get_declared_classes();

		if( !in_array( $Service, $ClassesRun ) ){
			return include ROOT . '/Services/' . $thisService['Dir'] . 'Service.php';
		}
	}
}