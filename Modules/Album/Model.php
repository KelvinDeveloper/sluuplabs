<?php

$Services->Run('autoSystem');

$album = $autoSystem->create(
	array(
		'bd'				=> 'album_' . $_SESSION['user']['Path'],
		'auto_increment'	=> 'id_album',
		'Fields'	=> 
			array(

				'title'		=>	array(
					'Label'		=>	'Título',
					'Type'		=>	'varchar',
					'Placeholder'	=> 'Título do Album',
					'Lenght'	=>	100
				),

				'Descrição'	=>	array(
					'Label'		=>	'Descrição do Album',
					'Type'		=>	'html',
					'Width'		=>  '$(this).parents(\'.window\').width() + \'px\' '
				),

				'publish'	=> array(
					'Label'	=> 'Publicar',
					'Type'	=> 'select',
					'Options'	=> array(
						1	=> 'Sim',
						2	=> 'Não'
					),
				),

				'coment'	=> array(
					'Label'	=> 'Habilitar Comentários',
					'Type'	=> 'select',
					'Options'	=> array(
						1	=> 'Sim',
						2	=> 'Não'
					),
				),

				'galery'		=> array(
					'Label'		=> 'Galeria de Imagens',
					'Type'		=> 'files',
					'Options'	=> array(
						'Types'	=> 'IMAGE'
					),
				),

				'register'	=>	array(
					'Label'	=>	'Cadastrado',
					'Type'	=>	'datetime',
					'Hide'	=> 	true
				),

				'adduser'	=>	array(
					'Type'	=>	'int',
					'Hide'	=>	true
				),
			),
		'Grid'	=> array(
			'Width'		=> '100%',
			'Hide'		=> array( 'id_album', 'conteudo', 'coment', 'adduser' ),
		),
		'Form'	=> array(
			'Title'	=> 'Album',
			'Buttons'	=> array(
				'Save'	=> array(
					'Class'	=>	'btn btn-primary'
				),
			),
			'Log'	=> array(
				'Register'	=> true,
				'AddUser'	=> true,
			),
		),
	)
);