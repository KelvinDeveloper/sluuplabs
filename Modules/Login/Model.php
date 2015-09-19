<?php
$JS = '<script> ';
	$JS .= '$(document).ready(function(){
		var img = new Image();
		img.src = "' . $_COOKIE['HistoryUsers'][ $_COOKIE['ActiveUserLogin'] ]['Wallpaper'] . '";
		img.onload = function() {
		';
if( isset( $_COOKIE['HistoryUsers'][ $_COOKIE['ActiveUserLogin'] ]['Wallpaper'] ) ){

	$JS .= "$('body').css('background', \"url('" . $_COOKIE['HistoryUsers'][ $_COOKIE['ActiveUserLogin'] ]['Wallpaper'] . "')\");";
}

$JS .= ' };
});
</script>';


echo $JS;