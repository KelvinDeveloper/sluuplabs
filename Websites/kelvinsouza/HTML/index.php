<?php
if( !$Function->isAjax() ){

	include __DIR__ . '/Head.php';
	echo '<div class="content">';
}
// contenteditable="true"
include __DIR__ . '/blocks/Lateral.php';
?>


<?php
if( !$Function->isAjax() ){

	echo '</div>';
	include __DIR__ . '/Footer.php';
}