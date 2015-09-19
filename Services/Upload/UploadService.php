<?php

class Upload extends Explorer{
	
	function Upload(){

		$ArrayL = explode( '/', $_POST['Location'] );
		$_POST['Location'] = '';
		foreach( $ArrayL as $v ){
			if( !empty( $v ) && $v != 'Explorer' ){
				$_POST['Location'] .= $v . '/';
			}
		}

		$_POST['Location'] = '/' . $_POST['Location'];
		
		$FileParts  = pathinfo( $_FILES['Filedata']['name'] );
		$TempFile   = $_FILES['Filedata']['tmp_name'];
		
		$Dir = scandir( ROOT . $_POST['Location'] );
		$ConsultName = true;
		$nName = '';
		$L = 1;
		
		while ( $ConsultName ) {

			$FileName = $FileParts['filename'] . $nName . '.' . $FileParts['extension'];
			
			if( !in_array( $FileName, $Dir ) ){
				$ConsultName = false;
			} else {
				$nName = ' (' . $L . ')';
				$L++;
			}
		}

	if( strstr( $_POST['Location'], '/tmp/' ) || strstr( $_POST['Location'], '/Application/Users/' ) ){
		$TargetFile = ROOT . $_POST['Location'] . $FileName;
	} else {
		$TargetFile = ROOT . '/Application/Users/' . $_SESSION['user']['id_user'] . $_POST['Location'] . $FileName;
	}

	$Location = explode( 'sluup', $TargetFile );

		if( move_uploaded_file( $TempFile, $TargetFile ) ){
			$Return['Name'] 	= $FileName;
			$Return['Type'] 	= $this->Type( $TargetFile );
			$Return['Location'] = $Location[1];
			$Return['Icon'] 	= $this->Icon( $TargetFile );
			$Return['Status'] 	= true;
		} else {
			$Return['Name'] 	= $FileName;
			$Return['Status'] 	= false;
			$Return['Type'] 	= $this->Type( $TargetFile );
		}

		echo json_encode( $Return );

	}
}

$Upload = new Upload;