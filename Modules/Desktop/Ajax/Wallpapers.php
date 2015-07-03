<?php
$Backgrounds = dir( ROOT . '/Application/System/Backgrounds/' );
while ( $BG = $Backgrounds->read() ){
	if( $BG != '..' && $BG != '.' ){
		$Wallpapers[] = $BG;
	}
}

echo json_encode( $Wallpapers );