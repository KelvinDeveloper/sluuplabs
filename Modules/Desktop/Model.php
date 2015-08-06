<?php

$JS = '<script> ';
	$JS .= '$(document).ready(function(){
		var img = new Image();
		img.src = "' . $reg['Wallpaper'] . '";
		img.onload = function() {
		';
if( isset( $reg['Wallpaper'] ) ){

	$JS .= "$('body').css('background', \"url('" . $reg['Wallpaper'] . "')\");";
}

$JS .= ' };
});
</script>';


setcookie( 'HistoryUsers[' . $_SESSION['user']['id_user'] . '][Wallpaper]', $reg['Wallpaper'], $Conf['Cookie']['Expire'], '/' );

echo $JS;