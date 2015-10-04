<?php

$JSON = json_decode( $_POST['File'] );
$File = pathinfo( ROOT . $JSON->Location );

$File['Lenght']   = $Function->FileSizeConvert( filesize( ROOT . $JSON->Location ) );
$File['isImage']  = $Function->is_image( ROOT . $JSON->Location );
$File['isFolder'] = is_dir( ROOT . $JSON->Location );
$File['Location'] = $JSON->Location;

echo json_encode( $File );