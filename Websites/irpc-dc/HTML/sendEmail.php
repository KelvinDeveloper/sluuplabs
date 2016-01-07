<?php

if( !$_POST ){ exit; }

if( $_GET['action'] == 'oracao' ){
    $_GET['action'] = 'Pedido de Oração';
}
else if( $_GET['action'] == 'testemunho' ){
    $_GET['action'] = 'Testemunho';
} else {
    $_GET['action'] = 'Mensagem';
}

include __DIR__ . '/phpmailer/class.phpmailer.php';

$Conf['Email'] = array(
    'Autentic'  => true,
    'Encrypted' => 'tls',
    'Server'    => 'smtp-mail.outlook.com',
    'Port'      => 587,
    'Email'     => 'kelvin.souza@tblmanager.com.br',
    'Password'  => 'Q4w3e2r1',
    'Charset'   => 'UTF-8',
    'HTML'      => true,
);

ini_set( "SMTP", $Conf['Email']['Server'] );
ini_set( "smtp_port", $Conf['Email']['Port'] );

$HTML = '';

$HTML .= 'Mensagem enviada: ' . date('m/d/Y às h:i:s')     . '<br>';
$HTML .= 'Nome:     ' . $_POST['nome']     . '<br>';
$HTML .= 'Email:    ' . $_POST['email']    . '<br>';
$HTML .= 'Cidade:   ' . $_POST['cidade']   . '<br>';
$HTML .= 'Estado:   ' . $_POST['estado']   . '<br>';
$HTML .= 'Mensagem: ' . $_POST['mensagem'] . '<br>';

$mail = new PHPMailer();
$mail->IsSMTP();                                    // Ativar SMTP
$mail->SMTPDebug  = false;                              // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
$mail->SMTPAuth   = $Conf['Email']['Autentic'];     // Autenticação ativada
$mail->SMTPSecure = $Conf['Email']['Encrypted'];    // SSL REQUERIDO pelo GMail
$mail->Host       = $Conf['Email']['Server'];       // SMTP utilizado
$mail->Port       = $Conf['Email']['Port'];         // A porta 587 deverá estar aberta em seu servidor
$mail->Username   = $Conf['Email']['Email'];
$mail->Password   = $Conf['Email']['Password'];
$mail->CharSet    = $Conf['Email']['Charset'];
$mail->IsHTML ( $Conf['Email']['HTML'] );
$mail->SetFrom( $Conf['Email']['Email'], $_POST['nome'] );
$mail->Subject    = $_GET['action'] . ' | enviado por ipri.org.br';
$mail->Body       = $HTML;
$mail->AddAddress('contato@jeriel.com.br');

$send = $mail->Send();

if( $send ){
    $Return['status'] = true;
    echo json_encode( $Return );
    return true;
} else {
    $Return['status'] = false;
    $Return['message'] = $mail->ErrorInfo;
    echo json_encode( $Return );
    return false;
}