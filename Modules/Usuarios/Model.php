<?php

$Usuarios = array(
	'bd'				=>	'users',
	'auto_increment'	=>	'id_user',
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
		'Hide'	=>	array( 'id_user', 'Password', 'AlterPass', 'Permissions', 'Sexo', 'ide_busines' )
	),
	'Form'	=>	array(
		'Title'	=>	'<i class="material-icons">&#xE8A6;</i> Cadastro de usuário',
		'Log'	=> array(
			'Register'	=> true,
		),
	),


);