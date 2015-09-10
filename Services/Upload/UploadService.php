<?php

class Upload extends Explorer{
	
	function Upload(){
		
		$FileParts  = pathinfo( $_FILES['Filedata']['name'] );
		$TempFile   = $_FILES['Filedata']['tmp_name'];
		
		$Dir = scandir( ROOT . $_POST['Location'] );
		$ConsultName = true;
		$nName = '';
		$L = 1;

		while ( $ConsultName ) {

			$FileName = $FileParts['filename'] . $nName . $FileParts['extension'];
			
			if( !in_array( $FileName, $Dir ) ){
				$ConsultName = false;
			} else {
				$nName = ' (' . $L . ')';
				$L++;
			}
		}

		$TargetFile = ROOT . $_POST['Location'] . '/' . $FileName;


		if( !move_uploaded_file( $TempFile, $TargetFile ) ){
			$Return['Name'] = $FileName;
			$Return['Type'] = $this->Type( $TargetFile );
			$Return['Location'] = $TargetFile;

			echo json_encode( $Return );
		}

	}
}