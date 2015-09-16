<?php

$Services->Run('autoSystem');

$blog = $autoSystem->create(
	array(
		'bd'				=> 'blog',
		'auto_increment'	=> 'id_blog',
		'Fields'	=> 
			array(
			
				'title'		=>	array(
					'Label'		=>	'Título',
					'Type'		=>	'varchar',
					'Lenght'	=>	100
				),

				'shot_description'	=>	array(
					'Label'		=>	'Descrição curta',
					'Type'		=>	'html',
					'Lenght'	=>	255
				),

				'description'	=>	array(
					'Label'		=>	'Descrição Completa',
					'Type'		=>	'html',
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
				)
			),
		'Grid'	=> array(
			'Width'		=> '100%',
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