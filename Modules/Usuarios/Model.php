<?php

$User = $Database->Search('work_groups', "CONCAT( IFNULL( CONCAT( GROUP_CONCAT( user ), ',' ), '' ), IFNULL( CONCAT( GROUP_CONCAT( user_create ), ',' ), '' ) ) as users", " ( user != '' || user_create != '' ) && ( id_work_group = '" . $_SESSION['user']['Path'] . "' || ide_work_group = '" . $_SESSION['user']['Path'] . "' ) " );

$Usuarios = array(
	'bd'				=>	'users',
	'auto_increment'	=>	'id_user',
	'Where'				=> 	" WHERE id_user IN ( " . substr( $User->users, 0, -1 ) . " )",
	'Fields'			=> array(
		'ImagePerfil'	=> array(
			'Label'	=> 'Foto',
			'Type'	=> 'file',
			'Options'	=> array(
				'Types'	=> 'IMAGE'
			),
		),

		'Nome'	=> array(
			'Type'		=>	'varchar',
			'Lenght'	=>	255
		),

		'Sobrenome'	=> array(
			'Type'		=>	'varchar',
			'Lenght'	=>	255
		),

		'Status'	=>	array(
			'Type'	=>	'select',
			'Options'	=>	array(
				1	=> 	'Ativo',
				2	=>	'Inativo',
			),
		),

		'Sexo'	=>	array(
			'Type'		=>	'select',
			'Options'	=> array(
				1	=>	'Masculino',
				2	=>	'Feminino'
			),
		),

		'Email'	=>	array(
			'Type'	=>	'email',
		),

		'Phone'	=> array(
			'Label'	=>	'Telefone',
			'Type'	=>	'phone'
		),

		'Cel'	=> array(
			'Label'	=>	'Celular',
			'Type'	=>	'phone'
		),

		'Password'	=> array(
			'Label'	=>	'Senha',
			'Type'	=>	'password',
			'Lenght'	=>	255
		),

		'wg'	=>	array(
			'Type'	=>	'hidden'
		),

		'register'	=>	array(
			'Label'	=>	'Cadastrado',
			'Type'	=>	'datetime',
			'Hide'	=> 	true
		),
	),
	'Grid'	=>	array(
		'Width'	=>	'100%',
		'Hide'	=>	array( 'id_user', 'Password', 'AlterPass', 'Permissions', 'Sexo', 'ide_busines', 'wg' )
	),
	'Form'	=>	array(
		'Title'	=>	'<i class="material-icons">&#xE8A6;</i> Cadastro de usuário',
		'Log'	=> array(
			'Register'	=> true,
		),
	),


);