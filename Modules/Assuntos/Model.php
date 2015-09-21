<?php

$Services->Run('autoSystem');

$assuntos = $autoSystem->create(
	array(

		'bd'				=>	'assuntos',
		'auto_increment'	=>	'id_assunto',

		'Fields'	=> array(

			'name'	=> array(
				'Type'		=> 'varchar',
				'Label'		=> 'Assunto',
				'Lenght'	=> 100,
			),
		),

		'Grid'	=> array(
			'Width'		=> '100%',
		),

		'Form'	=>	array(
			'Title'	=>	'Assuntos'
		),

	)

);