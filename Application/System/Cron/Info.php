<?php

echo 
'
<pre>

<ul>

<a href="?action=sess"> Sessions and Cookies</a>
<a href="?action=info"> PHPInfo</a>

</ul>';

switch ( $_REQUEST['action'] ){
	
	case 'sess':
		'<h1>Sessions</h1>';
		print_r( $_SESSION );
		'<h1>Cookies</h1>';
		print_r( $_SESSION );
		break;
	
	default:
		echo phpinfo();
		break;
}