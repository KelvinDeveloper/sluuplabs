<?php

$Services->Run('autoSystem');

$blog = $autoSystem->create(
	array(
		'bd'				=> 'blog',
		'auto_increment'	=> 'id_blog',
		'Fields'	=> 
			array(

				'image'		=> array(
					'Label'		=> 'Imagem de capa',
					'Type'		=> 'file',
					'Options'	=> array(
						'Types'	=> 'IMAGE'
					),
				),

				'title'		=>	array(
					'Label'		=>	'Título',
					'Type'		=>	'varchar',
					'Placeholder'	=> 'Título da postagem',
					'Lenght'	=>	100
				),

				'conteudo'	=>	array(
					'Label'		=>	'Conteúdo da postagem',
					'Type'		=>	'html',
					'Width'		=>  '$(this).parents(\'.window\').width() + \'px\' '
				),

				'assunto'	=> array(
					'Label'	=> 'Assunto',
					'Type'	=> 'select',
					'Query'	=> 'SELECT * FROM ' . BD . '.assuntos',
					'Key'	=> 'id_assunto',
					'Value'	=> 'name'
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

				'visitas'	=> array(
					'Label'		=> '',
					'Type'		=> 'hidden',
					'Lenght'	=>	11,

				),
			),
		'Grid'	=> array(
			'Width'		=> '100%',
			'Hide'		=> array( 'id_blog', 'conteudo', 'coment' ),
		),
		'Form'	=> array(
			'Title'	=> 'Postagem',
			'Buttons'	=> array(
				'Save'	=> array(
					'Class'	=>	'btn btn-primary'
				),
			),
		),
	)
);